<?php

class BackendModelExample extends BaseActiveRecord
{
    public $parent_id;
    public $table;
    public $name;


    public static function getBackendViews(){
        return array(
            'last_products' => [
                'title'         => 'раолыаиолыра',
                'description'   => 'гтшгшгтшг',
                'css'           => '',
                'visible'       => 1,
                'criteria'      => array(
                    'select'    => '',
                    'limit'     => 50,
                    'order'     => '',
                ),
                'fields'         => [

                ],
            ],
        );
    }


    public static function getFrontendViews(){
        return [
            'frontend' => [
                'list' => [
                    'url' => '/products/%%PAGE%%',
                    'title' => 'Продукты',
                ],
                'view' => [
                    'url' => '/product/view/%%ID%%',
                    'title' => 'Продукт %%ID%%',
                ],
            ],
        ];
    }

    public static function getApiViews(){
        return [

        ];
    }


    public static function getFieldPatterns(){
        return [
            'codes' => [
                'hex' => [
                    'pattern' => 'Fsfsf(sdfsf*)',
                    'sql_type' => 'varchar(120)',
                    'title' => 'Hex код',
                    'hint_error' => 'Это пишется вот так ...',
                    'hint_placeholder' => '990',
                ],
                // ...
            ],
            // ...
        ];

    }


    //@todo автоматически созлавть миграции
    //автоматически менять эту модель
    //

    public static function getBackendAttributes(){
        return array(
            'main' => [ //group name
                'title' => [
                    'type'      => 'ygin_type',
                    'title'     => 'sfsdfsfsf',
                    'hint'      => '',
                    'hint_more' => '',
                    'regexp'    => '', //length, types, emails, url,
                    //short_phone long_phone strict_long_phone
                    //ip short_ip ip_6 short_ip_6 mac domain url request email file_path
                    //youtube_video twitter_name
                    //date_dmY date_dmYHis
                    //integer float string //abc Abc ABC abc0 123
                    //money signed_money bitcoin creditcard
                    //passport_russian zip_russian FIO
                    //coords xyz arrays
                    //hex oct rgb hsl md5 base64 css css_size json user_agent
                    //GUID UUID GTIN ISBN
                    'hint_error' =>  '',
                    'default'   => 'czc',
                    //yii ONLY
                    //%%TIMESTAMP //%%AUTOINCREMENT //%%DATE //%%REQUEST //%%QUERY //%%USER //%%REFERRER //%%BROWSER //%%LANG //%%IP
                    'NULL'      => 1, //yii and sql
                    'UNIQUE'    => 1, //yii and sql
                    'SQL_TYPE'  => '', //complementary with regexp synced
                    'visible'   => 1,
                    'search_index' => 1,
                    'widget'    => '',
                    //
                    'filter' => 'filter', //trim //decode //encode //encoding_utf //
                ],
            ],
        );
    }

    //@also types
    /*
     * file field:
     * [
     * 'count' => 5,
     * 'last_id' => '5',
     * 'first_id' => '2',
     * 'updated_at' => '34535',
     * ]
     *
     * file type:
     * [
     * 'file_path' => '/sfsdfsf/',
     * 'min_count' => 5,
     * 'max_count' => 12,
     * 'max_size' => '120KB',
     * 'types' => [ 'jpeg', 'png' ],
     * ]
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     */

}
