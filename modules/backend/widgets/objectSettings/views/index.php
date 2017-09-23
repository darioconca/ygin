<?php
$buttons = array(
    'object' => array(
        'title' => Yii::t('backend','Object settings'),
        'icon'  => 'glyphicon glyphicon-wrench',
        'link'  => '/',
    ),
    'views' => array(
        'title' => Yii::t('backend','Object views'),
        'icon'  => 'glyphicon glyphicon-eye-open',
        'link'  => '/',
    ),
    'fields' => array(
        'title' => Yii::t('backend','Object fields'),
        'icon'  => 'glyphicon glyphicon-list',
        'link'  => '/',
    ),
);

if ($object != null && Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, DaObject::ID_OBJECT)) {
    $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW, array(
        ObjectUrlRule::PARAM_OBJECT => DaObject::ID_OBJECT,
        ObjectUrlRule::PARAM_OBJECT_INSTANCE => $object->id_object,
        ObjectUrlRule::PARAM_OBJECT_VIEW => 2,
        ObjectUrlRule::PARAM_OBJECT_PARENT => $object->parent_object,
    ));
    $buttons['object']['link'] = $link;
}
if ($view != null && Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_LIST, Yii::app()->user->id, DaObjectView::ID_OBJECT)) {
    $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
        ObjectUrlRule::PARAM_OBJECT => DaObjectView::ID_OBJECT,
        ObjectUrlRule::PARAM_GROUP_OBJECT => DaObject::ID_OBJECT,
        ObjectUrlRule::PARAM_GROUP_INSTANCE => $object->id_object,
        ObjectUrlRule::PARAM_GROUP_PARAMETER => 401,
    ));
    $buttons['views']['link'] = $link;
}
if ($object != null && $object->object_type == DaObject::OBJECT_TYPE_TABLE) {
    if (Yii::app()->authManager->checkObject(DaDbAuthManager::OPERATION_EDIT, Yii::app()->user->id, ObjectParameter::ID_OBJECT)) {
        $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW, array(
            ObjectUrlRule::PARAM_OBJECT => ObjectParameter::ID_OBJECT,
            ObjectUrlRule::PARAM_GROUP_OBJECT => DaObject::ID_OBJECT,
            ObjectUrlRule::PARAM_GROUP_INSTANCE => $object->id_object,
            ObjectUrlRule::PARAM_GROUP_PARAMETER => 75,
        ));
        $buttons['fields']['link'] = $link;
    }
}
//
foreach ($buttons as $key => $button){
    echo "<a href='{$button['link']}' target='_blank' title='{$button['title']}' class='btn btn-default btn-xs'><i class='{$button['icon']}'></i></a>";
}

?>