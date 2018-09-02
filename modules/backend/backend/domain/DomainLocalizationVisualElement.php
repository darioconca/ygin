<?php

class DomainLocalizationVisualElement extends MultiSelectWidget
{

    public $many2manyTable = 'da_domain_localization';
    public $relationField = 'id_domain';
    public $secondaryField = 'id_localization';

    public function getCriteria()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 't.is_use=1 AND t.id_localization != 1';
        return $criteria;
    }

    public function getIdObjectSelectInstance()
    {
        return 54; //DA_OBJECT_LOCALIZATION;  //@todo
    }
}
