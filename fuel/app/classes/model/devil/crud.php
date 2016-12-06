<?php
/**
 * Model_Crudの拡張クラス.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

class Model_Devil_Crud extends \Fuel\Core\Model_Crud
{
    /**
     * @var  バルク処理用
     */
    protected $_bulk_insert_data = array();
    protected $_bulk_update_data = array();


    /**
     * Saves the object to the database by either creating a new record
     * or updating an existing record. Sets the default values if set.
     *
     * @param   bool $validate wether to validate the input
     *
     * @return  mixed  Rows affected and or insert ID
     */
    public function save($validate = true)
    {
        if($this->frozen()) {
            throw new Exception('Cannot modify a frozen row.');
        }

        $vars = $this->_data;

        // Set default if there are any
        isset(static::$_defaults) and $vars = $vars + static::$_defaults;

        if($validate and isset(static::$_rules) and !empty(static::$_rules)) {
            $vars = $this->pre_validate($vars);
            $validated = $this->post_validate($this->run_validation($vars));

            if($validated) {
                $validated = array_filter($this->validation()->validated(), function ($val) {
                    return ($val !== null);
                });

                $vars = $validated + $vars;
            }
            else {
                return false;
            }
        }

        $vars = $this->prep_values($vars);

        if(isset(static::$_properties)) {
            $vars = Arr::filter_keys($vars, static::$_properties);
        }

        if(isset(static::$_updated_at)) {
            if(isset(static::$_mysql_timestamp) and static::$_mysql_timestamp === true) {
                $vars[ static::$_updated_at ] = Date::forge()->format('mysql');
            }
            else {
                $vars[ static::$_updated_at ] = Date::forge()->get_timestamp();
            }
        }

        if($this->is_new()) {
            if(isset(static::$_created_at)) {
                if(isset(static::$_mysql_timestamp) and static::$_mysql_timestamp === true) {
                    $vars[ static::$_created_at ] = Date::forge()->format('mysql');
                }
                else {
                    $vars[ static::$_created_at ] = Date::forge()->get_timestamp();
                }
            }

            $query = DB::insert(static::$_table_name)
                ->set($vars);

            $this->pre_save($query);
            $result = $query->execute(static::get_connection(true));

            if($result[ 1 ] > 0) {
                // workaround for PDO connections not returning the insert_id
                if($result[ 0 ] === false and isset($vars[ static::primary_key() ])) {
                    $result[ 0 ] = $vars[ static::primary_key() ];
                }
                $this->set($vars);
                empty($result[ 0 ]) or $this->{static::primary_key()} = $result[ 0 ];
                $this->is_new(false);
            }

            return $this->post_save($result);
        }


        //更新カラムからプライマリーキーを除外
        $update_vars = $vars;
        if( isset( $update_vars[ static::primary_key() ] ) ) unset( $update_vars[ static::primary_key() ] );
        //更新対象が無い場合処理を抜ける
        if( empty( $update_vars ) ) return;

        $query = DB::update(static::$_table_name)
            ->set($update_vars)
            ->where(static::primary_key(), '=', $this->{static::primary_key()});

        $this->pre_update($query);

        $result = $query->execute(static::get_connection(true));
        $result > 0 and $this->set($vars);

        return $this->post_update($result);
    }


    /**
     * 特定のカラムをINで更新します。
     *
     * @param       $column
     * @param array $updateValue
     * @param array $inColumnArray
     *
     * @return mixed
     * @throws Exception
     */
    public function save_in_update($column, array $updateValue, array $inColumnArray, $user_id = null)
    {
        $query = \DB::update(static::$_table_name)
            ->set($updateValue)
            ->where($column, 'IN', DB::expr('(' . implode(', ', $inColumnArray) . ')'));

        if(!empty($user_id)){
            $query->and_where('user_id', $user_id);
        }

        $connection = \Database_Connection::instance();
        $sql = $query->compile($connection);

        $result = \DB::query($sql)
            ->execute(static::get_connection(true));

        if(count($result) <= 0) throw new \Exception("トランザクションデータがありません");

        return $this->post_update($result);
    }


    /**
     * 特定のカラムを更新します。
     *
     * @param array $updateValue
     * @param array $arrWhere
     *
     * @return mixed
     * @throws Exception
     */
    public function save_update(array $updateValue, array $arrWhere)
    {
        if(empty($updateValue)) return;

        $query = \DB::update(static::$_table_name)
            ->set($updateValue);
        if(is_array($arrWhere)) {
            foreach($arrWhere as $column => $value) {
                $query->where($column, '=', DB::expr($value));
            }
        }

        $connection = \Database_Connection::instance();
        $sql = $query->compile($connection);

//      Log::Debug(Fuel::$env .' save_update -> ' . $sql);

        $result = \DB::query($sql)
            ->execute(static::get_connection(true));

        if(count($result) <= 0) throw new \Exception("SHOP_TRANSACTION_NOT_DATA", "トランザクションデータがありません");

        return $this->post_update($result);
    }


    /**
     * 更新データをセットします。
     * ここでセットされた値がsave_bulk_insertで更新されます。
     *
     * @param   array $insert_record
     */
    public function set_bulk_insert(array $insert_record)
    {
        $this->_bulk_insert_data[] = $insert_record;
        return $this;
    }


    /**
     * set_bulk_insert でセットされたデータを更新します。
     * $on_update_flg true のとき ON DUPLICATE KEY UPDATEになり、
     * $on_update_flg false のとき BULK INSERT になります。
     *
     * @param boolean $on_update_flg
     */
    public function save_bulk_insert($on_update_flg = false)
    {
        if( empty( $this->_bulk_insert_data ) ) return;

        //フィールドを取得
        $fields = array_keys( $this->_bulk_insert_data[0] );
        //クエリビルダー INSERT INTO {static::$_table_name} ( {$fields} )
        $query = \DB::insert( static::$_table_name )
                ->columns( $fields );

        //クエリビルダー VALUES( {$val} )
        foreach($this->_bulk_insert_data as $val) {
            $query = $query->values($val);
        }

        //クエリビルダーからSQLへ　INSERT INTO {static::$_table_name} ( {$fields} ) VALUES( {$val} )
        $sql = $query->compile( static::get_connection(true) );

        //重複キーがある場合UPDATEする
        if($on_update_flg === true)
        {
            $sql .= " ON DUPLICATE KEY UPDATE ";
            foreach($fields as $val) {
                $update_sql[] = "`$val` = VALUES($val)";
            }
            $sql .= implode(",", $update_sql);
        }

//      \Log::debug( Fuel::$env .' SQL -> ' . $sql );

        $result = \DB::query($sql)->execute(static::get_connection(true));
        $this->_bulk_insert_data = [];

        return $on_update_flg === true ? $this->post_update($result): $this->post_save($result) ;
    }

    /**
     * 更新データをセットします。
     * ここでセットされた値がsave_bulk_updateで更新されます。
     *
     * @param   array $update_values [$column => $value...]
     * @param   array $arr_where [$column => $value...]
     */
    public function set_bulk_update(array $update_value, array $arr_where)
    {
        $this->_bulk_update_data[] = [
            'update_value' => $update_value,
            'arr_where' => $arr_where,
        ];
    }


    /**
     * アップデートのSQLをまとめて実行
     * set_bulk_update でセットされたデータを更新します。
     *
     */
    public function save_bulk_update()
    {
        if( empty( $this->_bulk_update_data ) ) return;

        //SQLインジェクション対策用関数を利用したいためDatabase_Connectionクラスをインスタンス化
        $db = \Database_Connection::instance( static::get_connection(true) );

        //SQL組み立て用変数を初期化
        foreach($this->_bulk_update_data as $arr) {
            $tmp = [];
            foreach($arr['arr_where'] as $k => $v) {
                $tmp[] = $k . ' = ' . $v;
                $tmp_where[$k][] = $v;
            }
            $when = implode( ' AND ', $tmp );

            foreach($arr[ 'update_value' ] as $column => $v)
            {
                $value = $db->quote( $v );
                $case[ $column ][] = [
                    'when' => $when,
                    'value' => $value
                ];

            }
        }


        $sql = 'UPDATE ' . static::$_table_name;
        $sql.= ' SET ';
        $arr_case = [];
        foreach($case as $column => $arr)
        {
            $im_case = $column . ' = CASE ';
            foreach($arr as $v)
            {
                $im_case.= ' WHEN ' . $v[ 'when' ] . ' THEN ' . $v[ 'value' ];
            }
            $im_case.= ' ELSE ' . $column . ' END ';
            $arr_case[] = $im_case;
        }
        $sql.= implode(',', $arr_case);

        //where句
        $im_where = [];
        foreach($tmp_where as $column => $arr)
        {
            $arr_unique = array_unique($arr);
            if( count($arr_unique) == 1 )
            {
                $im_where[] = $column . ' = ' . $arr_unique[0];
            }else{
                $im_where[] = $column . ' IN (' . implode(',', $arr_unique) . ')';
            }
        }
        $sql.= ' WHERE ' . implode(' AND ', $im_where);

        \Log::debug( Fuel::$env .' SQL -> ' . $sql );

        $result = \DB::query($sql)->execute(static::get_connection(true));
        $this->_bulk_update_data = [];

        return $this->post_update($result);
    }

    /**
     * クエリ実行前にクエリビルダを操作します。
     */
    protected static function pre_find(&$query) {
        parent::pre_find($query);

        // selectする対象の指定
        // $query->select_array(static::get_select_array(),true);

        // is_deletedを検索条件に追加します。
        $query->where(array("is_deleted" => 0));
    }

}
