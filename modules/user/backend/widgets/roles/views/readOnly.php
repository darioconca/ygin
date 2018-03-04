<?php

foreach ($this->roles as $role) {
    if (in_array($role->name, $this->currentRoles)) {
        echo $role->description . '<br>';
    }
}
