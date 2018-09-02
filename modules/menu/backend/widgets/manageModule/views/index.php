<?php

/**
 * @var $form CActiveForm
 * @var $this DropDownListWidget
 * @var $model SiteModuleTemplate
 */
$idInstance = $model->getIdInstance();

$modules = $this->modules;
if (count($modules) == 0) {
    return;
}

$collection = new DaActiveRecordCollection($modules);

//Модули есть
$places = $model->modulePlaces;

// Уже задействованные модули
$currentIdModules = array();
$placesArray = array();
foreach ($places AS $place) {
    $currentIdModules[] = $place->id_module;
    $placesArray[$place->place][] = $place;
}

// Получили в массиве nid модули, приписанные каким-либо местам
//+ в $idUpdatedModules идентификаторы этих модулей (пригодится позднее при выводе модулей из архива)
?>
<div id="modulesSeqPlace">
    <div class="col-lg-6">
        <div id="placeNonVisible" class="b-widget-place well affix">
            <h4>Неиспользуемые модули</h4>
            <div>
                <ul>
                    <?php
                    // Если остались модули, которые не видны
                    $position = 0;
                    foreach ($modules as $module) {
                        $moduleId = $module->getIdInstance();
                        if (!in_array($moduleId, $currentIdModules)) {
                            $position++;
                            //todo
                            $moduleViewUrl = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW,array(
                                ObjectUrlRule::PARAM_OBJECT_INSTANCE => $moduleId,
                                ObjectUrlRule::PARAM_OBJECT          => SiteModule::ID_OBJECT,
                                ObjectUrlRule::PARAM_OBJECT_VIEW     => 57, //@todo
                            ));
                            $moduleViewLink = $moduleViewUrl ? "<a target='_blank' href='{$moduleViewUrl}' class='pull-right label-link glyphicon glyphicon-link'></a>" : '';
                            $moduleViewHandler = $module->id_php_script ? "<a title='PHP обработчик' class='pull-right label-link m-r-5'><sup><small>php</small></sup></a>" : '';

                            ?>
                            <li id='module_<?= $moduleId ?>'>
                                <input type='hidden' value='' name='mod_<?= $moduleId ?>_seq' class='contSeq'>
                                <input type='hidden' value='' name='mod_<?= $moduleId ?>_plc' class='contDid'>
                                <span title='<?= $module->content_excerpt ?>' class='label label-danger <?= $module->is_visible ? '' : 'opacity-50' ?>'>
                                    <sup class='contInd'><?= $position ?></sup> <?= $module->name ?> <?= $moduleViewLink ?> <?= $moduleViewHandler ?>
                                </span>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
    <?php
    // Пробег по всем положениям модулей
    $referenceModulePlaces = ReferenceElement::model()->byReference(32)->findAll(); //@todo
    foreach ($referenceModulePlaces as $referenceModulePlace) {
        $idModulePlace = $referenceModulePlace->getIdReferenceElement();
        $placeName = $referenceModulePlace->getValue();
        // После заголовка выводим модули, соответствующие данному местоположению
        ?>
        <div class='b-widget-place well' id='place_<?= $idModulePlace ?>' >
            <h4 data-toggle='collapse' data-target='#js-widget-place-<?= $idModulePlace ?>' class='cur-pointer'><?= $placeName ?> [id=<?= $idModulePlace ?>]</h4>
            <div id='js-widget-place-<?= $idModulePlace ?>' class='collapse in'>
                <ul>
                <?php if (array_key_exists($idModulePlace, $placesArray)) {
                    $placesArrayItems = $placesArray[$idModulePlace];
                    foreach ($placesArrayItems as $placesArrayItemIndex => $placesArrayItem) {
                        $moduleId = $placesArrayItem->id_module;
                        $module = $collection->itemAt($moduleId);
                        //todo
                        $moduleViewUrl = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW,array(
                            ObjectUrlRule::PARAM_OBJECT_INSTANCE => $moduleId,
                            ObjectUrlRule::PARAM_OBJECT          => SiteModule::ID_OBJECT, //page
                            ObjectUrlRule::PARAM_OBJECT_VIEW     => 57,
                        ));
                        $moduleViewLink = $moduleViewUrl ? "<a target='_BLANK' href='{$moduleViewUrl}' class='pull-right label-link glyphicon glyphicon-link'></a>" : '';
                        $moduleViewHandler = $module->id_php_script ? "<a title='PHP обработчик' class='pull-right label-link m-r-5'><sup><small>php</small></sup></a>" : '';
                        //
                        ?>
                        <li id='module_<?= $moduleId ?>'>
                            <input type='hidden' value='<?= $placesArrayItem->sequence ?>' name='mod_<?= $moduleId ?>_seq' class='contSeq'>
                            <input type='hidden' value='<?= $placesArrayItem->place ?>' name='mod_<?= $moduleId ?>_plc' class='contDid'>
                            <span title='<?= $module->content_excerpt ?>' class='label label-success <?= $module->is_visible ? '' : 'opacity-50' ?>'>
                                <sup><?= $placesArrayItemIndex + 1 ?></sup> <?= $module->name ?> <?= $moduleViewLink ?> <?= $moduleViewHandler ?>
                            </span>
                        </li>
                    <?php } ?>
                <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<!-- #modSeqPlace -->
<?php
$js = <<<JS
  $(".b-widget-place ul").sortable({
      connectWith: ".b-widget-place ul",
      placeholder: "highlight",
      stop: function (event, ui) {
          $(".b-widget-place").each(function () {
              m = 1;
              var did = $(this).attr("id").substr(6, $(this).attr("id").length - 6);
              $(this).find("li").each(function () {
                  $(this).find(".contInd").text(m);
                  $(this).find(".contSeq").val(m);
                  $(this).find(".contDid").val(did);
                  m++;
              })
          })
      }
  }).disableSelection();
JS;
Yii::app()->clientScript->registerScript('admin.widgetPlace.init',$js, CClientScript::POS_READY);

?>
