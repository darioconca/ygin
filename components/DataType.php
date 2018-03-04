<?php

class DataType
{

    const INT = 1;
    const VARCHAR = 2;
    const EDITOR = 3;
    const TIMESTAMP = 4;
    const REFERENCE = 6;
    const OBJECT = 7;
    const FILE = 8;
    const BOOLEAN = 9;
    const ABSTRACTIVE = 10;
    const PRIMARY_KEY = 11;
    const ID_PARENT = 12;
    const SEQUENCE = 13;
    const TEXTAREA = 14;

    const FILE_LIST = 15;
    const HIDDEN = 17;

    const RADIO = 19;
    const EVAL_EXPRESSION = 20;

    public static $sqlType = array(
        self::INT => 'INT(8)',
        self::VARCHAR => 'VARCHAR(255)',
        self::EDITOR => 'LONGTEXT',
        self::TIMESTAMP => 'INT(10) UNSIGNED',
        self::REFERENCE => 'INT(8)',
        self::OBJECT => 'INT(8)',
        self::FILE => 'INT(8)',
        self::BOOLEAN => 'TINYINT(1)',
        self::PRIMARY_KEY => 'INT(8)',
        self::ID_PARENT => 'INT(8)',
        self::SEQUENCE => 'INT(8)',
        self::TEXTAREA => 'LONGTEXT',
        self::HIDDEN => 'VARCHAR(255)',
        self::FILES => null,
        self::ABSTRACTIVE => null,
    );

    /**
     * @param $type
     * @return null|string
     */
    public static function getSqlType($type)
    {
        $sqlType = null;
        if ( isset(self::$sqlType[$type]) ){
            $sqlType = self::$sqlType[$type];
        }
        return $sqlType;
    }

}
