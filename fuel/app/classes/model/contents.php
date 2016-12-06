<?php

class Model_Contents extends Model_Devil_Crud
{
    protected static $_table_name = 'contents';
    protected static $_primary_key = 'content_id';
    protected static $_properties = [
        'album_id',
        'content_type',
        'content_url',
        'text',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

}
