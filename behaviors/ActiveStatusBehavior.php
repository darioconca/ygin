<?php

class ActiveStatusBehavior extends CBehavior
{
    public $statusProperty;

    /**
     * @return bool
     */
    public function isActive(){
        return $this->owner->{$this->statusProperty} == DaActiveRecord::IS_ACTIVE;
    }
}