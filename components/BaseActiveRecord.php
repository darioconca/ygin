<?php

abstract class BaseActiveRecord extends CActiveRecord
{
    /**
     * Значение TRUE для булевой колонки
     * @var integer
     */
    const TRUE_VALUE = 1;
    /**
     * Значение FALSE для булевой колонки
     * @var integer
     */
    const FALSE_VALUE = 0;

    private static $_isStart = false;

    /**
     * @static
     * @param $model CActiveRecord
     * @return mixed
     */
    private static function processModelRelation($model)
    {
        $models = self::getModels();
        $metaData = $model->getMetaData();
        $relations = $metaData->relations;
        foreach ($relations as $name => $relationClass) {
            if (isset($models[$relationClass->className])) {
                $className = Yii::import($models[$relationClass->className], false);
                $relationClass->className = $className;
                $metaData->relations[$name] = $relationClass;
            }
        }
        return $model;
    }

    /**
     * @param string $className
     * @return mixed|static
     */
    public static function model($className = __CLASS__)
    {
        $models = self::getModels();
        $className = HArray::val($models, $className, $className);
        $className = Yii::import($className, true);
        $model = parent::model($className);
        // такая обработка будет сделана только в случае когда ::model вызывается первый раз (вызов будет сделан в конструкторе).
        if (self::$_isStart) {
            $model = self::processModelRelation($model);
        }
        return $model;
    }

    /**
     * @param $modelName
     * @param string $scenario
     * @return mixed
     */
    public static function newModel($modelName, $scenario = 'insert')
    {
        $models = self::getModels();
        $className = HArray::val($models, $modelName, $modelName);
        $className = Yii::import($className, true);
        return new $className($scenario);
    }

    public function __construct($scenario = 'insert')
    {
        parent::__construct($scenario);
        if (!self::$_isStart) {
            self::$_isStart = true;
            self::processModelRelation($this);
            self::$_isStart = false;
        }
    }

    /**
     * @return array
     */
    private static function getModels(){
        $models = array();
        if ( isset(Yii::app()->models) ){
            $models = Yii::app()->models;
        }
        return $models;
    }

    public function addValidator(CValidator $validator)
    {
        $this->getValidatorList()->add($validator);
    }

}
