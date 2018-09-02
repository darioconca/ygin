<?php
    $script = "daAlert(" . CJavaScript::encode($this->title) . ", " . CJavaScript::encode($this->message) . ", '" . $this->btTitle . "', '" . $alertType . "');";
    $cs = Yii::app()->clientScript;
    $cs->registerScript(__CLASS__ . (self::$_cnt++), $script, CClientScript::POS_READY);