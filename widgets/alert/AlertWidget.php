<?php

class AlertWidget extends DaWidget
{

    const ERROR = 0;
    const WARNING = 1;
    const SUCCESS = 2;

    public $message = null;
    public $title = null;
    public $btTitle = 'OK';
    public $type = 'success';

    private static $_cnt = 0;

    public function init()
    {
        if ($this->title === null) {
            $this->title = Yii::app()->name;
        }
        $this->registerJsFile('daAlert-min.js');
    }

    public function run()
    {
        $alertTypes = array(
            'success'   => 'alert-success',
            'error'     => 'alert-danger',
            'warning'   => 'alert-info',
        );

        $alertType = HArray::val($alertTypes, $this->type, 'alert-info');

        $this->render("view", array(
            "alertType" => $alertType
        ));

    }

}