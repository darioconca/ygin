<?php

Yii::import('backend.widgets.dropDownList.DropDownObjectWidget', true);

/**
 * Визуальный элемент, выводящий свойства конкретного объекта
 */
class SelectObjectParameterWidget extends DropDownObjectWidget
{

    public $parameterOfObject = null;
    public $parameterOfObjectParameter = null;

    public function init()
    {
        parent::init();

        $object = $this->model->getObjectInstance();
        $params = $object->parameters;
        foreach ($params as $param) {
            /**
             * @var $p ObjectParameter
             */
            if ($param->getType() == DataType::OBJECT && $param->getAdditionalParameter() == ObjectParameter::ID_OBJECT) {
                $this->parameterOfObjectParameter = $param;
            } else if ($param->getType() == DataType::OBJECT && $param->getAdditionalParameter() == DaObject::ID_OBJECT) {
                $this->parameterOfObject = $param;
            }
        }
    }

}
