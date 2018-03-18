<?php 
$this->registerCssFile('photogallery-random-widget.css');
?>
<div class="b-photogallery-random-widget">
  <?php if ($photo){ ?>
  <a href="<?= $photoLink ?>"><img src="<?=$photo->getUrl() ?>"></a>
  <?php } ?>
  <a class="btn btn-xs photogallery-link" href="<?= $galleryLink ?>">Фотогалерея »</a>
</div>