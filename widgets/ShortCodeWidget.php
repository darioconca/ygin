<?php

class ShortCodeWidget extends CWidget {

    const EMBEDDING_SCHEME = '[w:%]';

    /**
     * @return string
     */
    public static function getSchemeStart(){
        return explode('%',self::EMBEDDING_SCHEME)[0];
    }

    /**
     * @return string
     */
    public static function getSchemeEnd(){
        return explode('%',self::EMBEDDING_SCHEME)[1];
    }

    /**
     * @return string
     */
    public static function getSuffix(){
        return str_replace('Widget','',get_class());
    }

}