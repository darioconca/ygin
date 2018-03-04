<?php

class BackendSort extends CSort
{

    private $_model;

    /**
     * @param string $className
     * @return CActiveRecord
     */
    public function getModel($className)
    {
        if ($this->_model == null) {
            $this->_model = parent::getModel($className);
        }
        return $this->_model;
    }

    /**
     * @param CActiveRecord $model
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }

}
