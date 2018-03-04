<?php

abstract class BaseFormModel extends CFormModel
{

    /**
     * @param $modelName
     * @param string $scenario
     * @return mixed
     * @throws CException
     */
    public static function newModel($modelName, $scenario = 'insert')
    {
        $models = array();
        if ( isset(Yii::app()->models) ){
            $models = Yii::app()->models;
        }
        $className = HArray::val($models, $modelName, $modelName);
        $className = Yii::import($className, true);
        return new $className($scenario);
    }

}
