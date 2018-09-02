<?php

class PhotogalleryWidget extends DaWidget
{

    public $model = null;

    public function run()
    {
        if ($this->model == null) {
            throw new ErrorException("Для виджета PhotogalleryWidget не установлена модель");
        }

        $assetsPath = $this->getAssetsPath();
        Yii::app()->clientScript->addDependResource('jquery-photowall.css', array(
            $assetsPath . 'exit.gif',
            $assetsPath . 'loader.gif',
            $assetsPath . 'lock.gif',
            $assetsPath . 'lll.png',
            $assetsPath . 'lrr.png',
        ));

//    $photos = PhotogalleryPhoto::model()->with('image')->byInstance($this->model)->findAll();
        $photos = $this->model->photosList;
        $this->render('photogallery', array(
            'photos' => $photos,
        ));
    }
}
