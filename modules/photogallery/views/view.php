<?php
/*
  $currentGallery,
  $childGallery,
*/

$this->caption = $currentGallery->name;

$this->renderPartial('/index', array(
  'childGallery' => $childGallery,
));

$this->widget('PhotogalleryWidget', array(
    "model" => $currentGallery
));
