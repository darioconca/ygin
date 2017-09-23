<?php

/** виджет ссылок настроек объекта
 * Class ObjectSettingWidget
 */
class ObjectSettingsWidget extends DaWidget
{

    public function run()
    {
        $view = Yii::app()->backend->objectView;
        $object = Yii::app()->backend->object;

        $this->render('index',array(
            'view'      => $view,
            'object'    => $object,
        ));
    }

}
