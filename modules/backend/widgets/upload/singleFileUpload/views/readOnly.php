<?php
foreach ($this->getFiles() as $file) {
    if ($file->getIsImage()) {
        if ($prev = $file->getPreview(70, 50, 'top', '_da')) {
            echo CHtml::link(CHtml::image($prev->getUrl(), 'Превью', array('class' => 'img-thumbnail')),
                $file->getUrl(),
                array('rel' => 'gallery' . $this->getObjectParameter()->id_parameter)
            );
        } else {
            echo CHtml::link($file->getName(), $file->getUrl());
        }
    } else {
        echo CHtml::link($file->getName(), $file->getUrl());
    }
}