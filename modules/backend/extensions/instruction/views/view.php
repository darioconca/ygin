<?php

$this->caption = $instruction->name;

echo CHtml::openTag('div', array('class' => 'instruction'));
echo CHtml::tag('div', array(), $instruction->content);

if (count($relations) > 0) {
    echo CHtml::tag('hr', array('class' => 'usefulLinks'));
    echo CHtml::tag('i', array(), 'Ссылки по теме:');
    $items = array();
    foreach ($relations as $item) {
        $items[] = array(
            'active' => false,
            'label' => $item->name,
            'url' => $item->getUrl(),
        );
    }
    $this->widget('zii.widgets.CMenu', array('items' => $items));
}
echo CHtml::tag('hr') . '&laquo; ' . CHtml::link('Назад к разделам инструкции', Yii::app()->createUrl('instruction'));
echo CHtml::closeTag('div');
