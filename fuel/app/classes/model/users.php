<?php

class Model_Users extends Model_Devil_Crud
{
    protected static $_table_name = 'users';
    protected static $_primary_key = 'user_id';
    protected static $_properties = [
        'user_id',
        'group_type',
        'last_post_back_id',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

}
