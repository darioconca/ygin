<?php

Yii::import('backend.widgets.dropDownList.DropDownListWidget', true);

class DropDownParentWidget extends DropDownListWidget
{

    private $_init = false;
    private $_count = null;

    public function init()
    {
        parent::init();
        $this->model->addValidator(CValidator::createValidator('length', $this->model, $this->attributeName, array(
            'on' => 'backendInsert, backendUpdate',
            'max' => 255
        )));
    }

    /**
     * @return mixed|null
     */
    public function getValueString()
    {
        $idParent = $this->getValue();
        if ($idParent == null) {
            return null;
        }
        $model = $this->model->findByIdInstance($idParent);
        return $model->getInstanceCaption();
    }

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
        $this->_count = $this->model->count($cr);
        return $this->_count;
    }

    private function processArray($allChildren, $idParent, $name, $level)
    {
        if ($level > 1) {
            $name = "|→ " . $name;
            $name = str_repeat('|--', ($level - 2)) . $name;
        }
        $data = array($idParent => $name);
        // Обработка child
        if (isset($allChildren[$idParent])) {
            foreach ($allChildren[$idParent] as $model) {
                $caption = $model->getInstanceCaption();
                if ( isset($model->statusProperty) && !$model->isActive() ){
                    $caption = HText::crossOut($caption);
                }
                $data = $data + $this->processArray($allChildren, $model->getIdInstance(), $caption, $level + 1);
            }
        }
        return $data;
    }

    public function getData()
    {
        if ($this->_init) {
            return $this->_data;
        }
        $this->_init = true;

        $this->htmlOption['prompt'] = "--- Корневой уровень ---";

        $object = $this->model->getObjectInstance();
        $where = $this->getObjectParameter()->getSqlParameter();
        $cr = new CDbCriteria();
        if ($where != null) {
            $cr->addCondition($where);
        }
        $cr->limit = $this->maxData;
        $cr->order = $object->getOrderBy();
        $data = $this->model->resetScope()->findAll($cr);

        $attributeName = $this->attributeName;

        $idInstance = $this->model->getIdInstance();
        $res = array();   // Результат, формата [id, level]
        $childes = array();
        foreach ($data as $model) {
            /**
             * @var $model DaActiveRecord
             */
            $curIdInst = $model->getIdInstance();
            $curIdInstP = $model->$attributeName;
            if (!$model->isNewRecord) {
                if ($idInstance == $curIdInst || $idInstance == $curIdInstP) {
                    continue;
                }
            }
            if (is_null($curIdInstP)) {
                $caption = $model->getInstanceCaption();
                if ( isset($model->statusProperty) && !$model->isActive() ){
                    $caption = HText::crossOut($caption);
                }
                $res[$curIdInst] = $caption;
            } else {
                if (isset($childes[$curIdInstP])) {
                    $childes[$curIdInstP][] = $model;
                } else {
                    $childes[$curIdInstP] = array($model);
                }
            }
        }

        $options = array();
        if (count($res) > 0) {
            foreach ($res as $idInstance => $caption) {
                $options = $options + $this->processArray($childes, $idInstance, $caption, 1);
            }
        } else {  // Если нет корневых элементов. Т.е. все элементы подвешены. Выводим их "в ряд".
            foreach ($data as $model) {
                $caption = $model->getInstanceCaption();
                if ( isset($model->statusProperty) && !$model->isActive() ){
                    $caption = HText::crossOut($caption);
                }
                $options = $options + $this->processArray(array(), $model->getIdInstance(), $caption, 1);
            }
        }

        $this->_data = $options;
        return $this->_data;
    }

}
