<?php

class DomainEventHandler extends BackendEventHandler
{

    public function onParameterAvailable(ParameterAvailableEvent $event)
    {
        parent::onParameterAvailable($event);
        if ($event->status == ViewController::ENTITY_STATUS_NOT_VISIBLE) {
            return;
        }

        $param = $event->objectParameter;
        $name = $param->getFieldName();

        $fields = array(
            'name',
            'domain_path',
            'path2data_http',
            'id_default_page',
            'settings',
        );
        if ( in_array($name, $fields) && !Yii::app()->user->checkAccess(DaWebUser::ROLE_DEV) ) {
            $event->status = ViewController::ENTITY_STATUS_NOT_VISIBLE;
        }
    }

}
