<?php

/** виджет ссылки на сайт
 * Class RightTopWidget
 */
class RightTopWidget extends DaWidget
{

    public $link = '/';
    public $caption;

    public function run()
    {
        $this->caption = Yii::t('backend','Site');
        echo '<li><a target="_blank" href="' . $this->link . '"><i class="glyphicon glyphicon-home icon-white"></i> ' . $this->caption . '</a></li>';
    }

}
