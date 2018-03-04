<?php

$fileResultStr = "";
$fileResultStr2 = "";
$countPreview = File::model()->count('id_parent_file IS NOT NULL');
if (HU::get('mode') == $this::CLEAR_CACHE_PREVIEWS) {
    if ($countPreview == 0) {
        Yii::app()->clientScript->registerScript('admin.special.cacheClear.image', 'alert("Превью-файлов в базе данных нет.");');
    } else {
        $fileResultStr = "<p style='margin-top:10px; padding-top:10px; border-top:1px solid'>Удалено превью-файлов: <b>{$countPreview}</b></p>";
        $allFiles = File::model()->findAll('id_parent_file IS NOT NULL');
        foreach ($allFiles as $file) {
            /**
             * @var $file File
             */
            $file->delete();
            if (!file_exists($file->getFilePath(true))) {
                $fileResultStr .= '<p><i class="glyphicon glyphicon-ok icon-green"></i> ';
            } else {
                $fileResultStr .= '<p><i class="glyphicon glyphicon-remove icon-red"></i> ';
            }
            $fileResultStr .= $file->getFilePath() . "</p>";
        }
        $countPreview = File::model()->count('id_parent_file IS NOT NULL');
    }
} else if (HU::get("mode") == $this::CLEAR_CACHE_COMPONENT) {
    //Очищаем Yii'шный кеш
    if (isset(Yii::app()->cache)) {
        Yii::app()->cache->flush();
    }
    Yii::app()->clientScript->registerScript('admin.special.cacheClear.yii', 'alert("Процедура завершена");');
} else if (HU::get("mode") == $this::CLEAR_CACHE_SCALE) {
    $allFiles = File::model()->findAll('id_parent_file IS NULL AND id_file_type=' . File::FILE_IMAGE);
    $count = 0;
    foreach ($allFiles as $file) {
        if ($file->resizeImage()) {
            $count++;
            if ($fileResultStr2 == "") {
                $fileResultStr2 .= "<br>Были обработаны следующие картинки: <br>";
            }
            $fileResultStr2 .= $file->getUrlPath() . "<br>";
        }
    }
    Yii::app()->clientScript->registerScript('admin.special.cacheClear.yii', "alert('Процедура завершена, обработано изображений: {$count}');");
} else if (HU::get("mode") == $this::CLEAR_CACHE_ASSETS) {
    $path = Yii::app()->assetManager->basePath;
    HFile::removeDirectoryRecursive($path, false, false, false, array('.gitignore'));
    //Yii::app()->request->redirect('/admin/page/89/');
}
$countImage = File::model()->count('id_parent_file IS NULL AND id_file_type=' . File::FILE_IMAGE);

?>
<fieldset class="form-horizontal">
    <legend>Служебные файлы (кэш и превью)</legend>

    <div class="form-group">
        <label class="text-right col-lg-4">Кэш стилей и js-файлов</label>

        <div class="controls col-lg-8">
            <p>Местонахождение: <b><?php echo Yii::app()->assetManager->basePath; ?></b></p>

            <form method="get" submit="">
                <input type="hidden" name="mode" value="<?= $this::CLEAR_CACHE_ASSETS ?>">
                <button class="btn btn-default" type="submit">Очистить</button>
            </form>
        </div>
    </div>

    <div class="form-group">
        <label class="text-right  col-lg-4">Файловый кэш и кэш в базе данных</label>

        <div class="controls col-lg-8">
            <?php if (isset(Yii::app()->cache)){ ?>
                <p>Компонент Yii::app()->cache: <b><?php echo get_class(Yii::app()->cache); ?></b></p>
            <?php } ?>
            <form method="get" submit="">
                <input type="hidden" name="mode" value="<?= $this::CLEAR_CACHE_COMPONENT ?>">
                <button class="btn btn-default" type="submit">Очистить</button>
            </form>
        </div>
    </div>

    <div class="form-group">
        <label class="text-right  col-lg-4">Превью-файлы изображений</label>

        <div class="controls col-lg-8">
            <p>Местонахождение: <b>/content/</b></p>
            <p>Количество превьюшек: <b><?php echo $countPreview; ?></b></p>

            <form method="get" submit="">
                <input type="hidden" name="mode" value="<?= $this::CLEAR_CACHE_PREVIEWS ?>">
                <button class="btn btn-default" type="submit"
                        onclick="if (!confirm('Вы действительно хотите удалить все превью-файлы?')) return false"<?= ($countPreview == 0 ? ' disabled' : '') ?>
                ">Очистить</button>
            </form>
            <?php echo $fileResultStr; ?>
        </div>
    </div>

    <div class="form-group">
        <label class="text-right col-lg-4">Провести пропорциональное уменьшение всех картинок до
            размера <?php echo Yii::app()->params['upload_image_width'] . "x" . Yii::app()->params['upload_image_height']; ?></label>

        <div class="controls col-lg-8">
            <p>Местонахождение: <b>/content/</b></p>
            <p>Количество картинок: <b><?php echo $countImage; ?></b></p>

            <form method="get" submit="">
                <input type="hidden" name="mode" value="<?= $this::CLEAR_CACHE_SCALE ?>">
                <button class="btn btn-default" type="submit"
                        onclick="if (!confirm('Вы действительно хотите провести уменьшение всех картинок (восстановить оригиналы будет невозможно)?')) return false"<?= ($countImage == 0 ? ' disabled' : '') ?>
                ">Запустить</button>
            </form>
            <?php echo $fileResultStr2; ?>
        </div>
    </div>
</fieldset>