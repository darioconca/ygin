<?php

class ObjectPermissionWidget extends VisualElementWidget
{

    public function onPostForm(PostFormEvent $event)
    {
        $this->model->attachEventHandler('onAfterSave', array($this, 'processModel'));
    }

    public function processModel(CEvent $event)
    {
        $permissionsNew = HU::post('setPermission') == null ? array() : HU::post('setPermission');
        $idObject = $this->model->getIdInstance();
        $oldIdObject = $this->model->getPkBeforeSave();

        $roles = Yii::app()->authManager->getAuthItems(CAuthItem::TYPE_ROLE);

        if ($idObject != $oldIdObject) {
            $items = Yii::app()->authManager->getAuthItemByIdObject($oldIdObject);
            foreach ($items as $name => $item) {
                Yii::app()->authManager->removeAuthItem($name);
            }
        }

        $permissionsOld = array();
        if ($idObject != '') {
            $permissions = array(
                DaDbAuthManager::OPERATION_VIEW => 'просмотра',
                DaDbAuthManager::OPERATION_EDIT => 'изменения',
                DaDbAuthManager::OPERATION_DELETE => 'удаления',
                DaDbAuthManager::OPERATION_CREATE => 'создания'
            );
            foreach ($roles as $roleName => $role) {
                /**
                 * @var CAuthItem $role
                 */
                foreach ($permissions as $permId => $perm) {
                    $operation = Yii::app()->authManager->getAuthItemObject($permId, $idObject);
                    if ($operation != null && Yii::app()->authManager->hasItemChild($roleName, $operation->getName())) {
                        $permissionsOld[] = $roleName . '-' . $permId;
                    }
                }
            }
        }
        $object = DaObject::getById($idObject);

        $createPermissions = array_diff($permissionsNew, $permissionsOld);
        foreach ($createPermissions as $info) {
            list($roleName, $action) = explode('-', $info);
            if (!isset($permissions[$action])) {
                continue;
            }
            $operation = Yii::app()->authManager->getAuthItemObject($action, $idObject);
            if ($operation == null) {
                $operation = Yii::app()->authManager->createOperationForObject($action, $idObject, 'Операция ' . $permissions[$action] . ' для объекта ' . $object->getName());
            }
            $role = Yii::app()->authManager->getAuthItem($roleName);
            if (!Yii::app()->authManager->hasItemChild($role->getName(), $operation->getName())) {
                $role->addChild($operation->getName());
            }
        }

        $deletePermissions = array_diff($permissionsOld, $permissionsNew);
        foreach ($deletePermissions as $info) {
            list($roleName, $action) = explode('-', $info);
            if (!isset($permissions[$action])) {
                continue;
            }
            $operation = Yii::app()->authManager->getAuthItemObject($action, $idObject);
            if ($operation == null) {
                continue;
            }
            Yii::app()->authManager->removeItemChild($roleName, $operation->getName());
        }

        // права на общий доступ работы с объектом (доступ к объекту в общем меню)
        foreach ($roles as $roleName => $role) {
            /**
             * @var CAuthItem $role
             */
            $exists = false;
            foreach ($permissions as $permId => $perm) {
                $operation = Yii::app()->authManager->getAuthItemObject($permId, $idObject);
                if ($operation != null && Yii::app()->authManager->hasItemChild($roleName, $operation->getName())) {
                    $exists = true;
                    break;
                }
            }
            $operation = Yii::app()->authManager->getAuthItemObject(DaDbAuthManager::OPERATION_LIST, $idObject);
            if ($exists) { // создаем
                if ($operation == null) {
                    $operation = Yii::app()->authManager->createOperationForObject(DaDbAuthManager::OPERATION_LIST, $idObject, 'Просмотр списка данных объекта ' . $object->getName());
                }
                if (!Yii::app()->authManager->hasItemChild($role->getName(), $operation->getName())) {
                    $role->addChild($operation->getName());
                }
            } else if ($operation != null && !$exists) { // удаляем
                if (Yii::app()->authManager->hasItemChild($role->getName(), $operation->getName())) {
                    Yii::app()->authManager->removeItemChild($roleName, $operation->getName());
                }
            }
        }

    }
}
