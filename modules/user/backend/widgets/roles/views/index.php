<?php

$data = array();
foreach($this->roles as $role) {
    $data[$role->name] = $role->description;
}
$selected = array();
foreach($this->currentRoles as $role) {
    $selected[] = $role;
}

echo CHtml::checkBoxList('roles', $selected, $data);