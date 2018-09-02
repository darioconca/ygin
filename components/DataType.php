<?php

class DataType
{

    const INT = 1;
    const VARCHAR = 2; //@todo remove
    const EDITOR = 3; //@todo remove
    const TIMESTAMP = 4;
    const REFERENCE = 6; //@todo remove
    const OBJECT = 7;
    const FILE = 8;
    const BOOLEAN = 9;
    const ABSTRACTIVE = 10;
    const PRIMARY_KEY = 11;
    //const FOREIGN_KEY = 12; @todo
    const ID_PARENT = 12; //@todo remove
    const SEQUENCE = 13;
    const TEXTAREA = 14;

    const FILE_LIST = 15; //@todo remove
    const HIDDEN = 17;

    const RADIO = 19;
    const EVAL_EXPRESSION = 20;

    //const JSON = 21; //@todo

    /**
     * @param $type
     * @param null $default
     * @return null
     */
    public static function getSqlType($type, $default = null)
    {
        $sqlType = $default;
        $sqlTypes = self::getSqlTypes();
        if ( isset($sqlTypes[$type]) ){
            $sqlType = $sqlTypes[$type];
        }
        return $sqlType;
    }

    /**
     * @param $type
     * @param string $default
     * @return string
     */
    public static function getLabel($type, $default = 'неизвестно')
    {
        $label = $default;
        $labels = self::getLabels();
        if ( isset($labels[$type]) ){
            $label = $labels[$type];
        }
        return $label;
    }
    /**
     * @return array
     */
    public static function getSqlTypes(){
        return array(
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
            self::FILE_LIST => null,
            self::ABSTRACTIVE => null,
        );
    }

    /**
     * @return array
     */
    public static function getLabels(){
        return array(
            self::INT => 'Число',
            self::VARCHAR => 'Строка',
            self::EDITOR => 'Редактор',
            self::TIMESTAMP => 'Время',
            self::REFERENCE => 'Справочник',
            self::OBJECT => 'Объект',
            self::FILE => 'Файл',
            self::BOOLEAN => 'Булев',
            self::PRIMARY_KEY => 'Первичный ключ',
            self::ID_PARENT => 'Внешний ключ',
            self::SEQUENCE => 'Последовательность',
            self::TEXTAREA => 'Текстовое поле',
            self::HIDDEN => 'Скрытый',
            self::FILE_LIST => 'Список файлов',
            self::ABSTRACTIVE => 'Абстрактный',
        );
    }

}
