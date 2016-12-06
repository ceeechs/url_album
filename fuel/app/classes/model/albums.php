<?php

class Model_Albums extends Model_Devil_Crud
{
    protected static $_table_name = 'albums';
    protected static $_primary_key = 'album_id';
    protected static $_properties = [
        'user_id',
        'album_url',
        'resource_num',
        'content_info',
        'is_finished',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

}
