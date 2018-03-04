<?php

Yii::import('backend.widgets.dropDownList.DropDownListWidget', true);

class DropDownReferenceWidget extends DropDownListWidget
{

    private $_init = false;
    private $_count = null;

    public function init()
    {
        parent::init();
        $this->model->addValidator(CValidator::createValidator('numerical', $this->model, $this->attributeName, array(
            'on' => 'backendInsert, backendUpdate',
            'integerOnly' => true
        )));
    }

    /**
     * @return null
     */
    public function getValueString()
    {
        $idInstance = $this->getValue();
        if ($idInstance == null) {
            return null;
        }
        $model = ReferenceElement::model()->byReferenceElement($this->getObjectParameter()->getAdditionalParameter(), $idInstance)->find();
        return $model->getValue();
    }

    /**
     * @return CDbDataReader|mixed|null|string
     */
    public function getCountData()
    {
        if ($this->_count !== null) {
            return $this->_count;
        }
        $where = $this->getObjectParameter()->getSqlParameter();
        $cr = new CDbCriteria();
        if ($where != null) {
            $cr->addCondition($where);
        }
        $this->_count = ReferenceElement::model()->byReference($this->getObjectParameter()->getAdditionalParameter())->count($cr);
        $this->maxData = $this->_count + 1; // отключаем автодополнения
        return $this->_count;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if ($this->_init) {
            return $this->_data;
        }
        $this->_init = true;

        if ($this->canNull()) {
            $this->htmlOption['prompt'] = '';
        }

        $where = $this->getObjectParameter()->getSqlParameter();
        $cr = new CDbCriteria();
        if ($where != null) {
            $cr->addCondition($where);
        }
        $referenceElements = ReferenceElement::model()->byReference($this->getObjectParameter()->getAdditionalParameter())->findAll($cr);

        foreach ($referenceElements as $referenceElement) {
            /**
             * @var $model ReferenceElement
             */
            $idElement = $referenceElement->getIdReferenceElement();
            $valueElement = $referenceElement->getValue();

            $this->_data[$idElement] = $valueElement;
        }

        return $this->_data;
    }

}
