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
                foreach ($modules AS $module) {
                    $id = $module->getIdInstance();
                    if (!in_array($id, $currentIdModules)) {
                        $position++;
                        $isVisible = $module->is_visible ? '' : 'opacity-50';
                        //todo
                        $moduleViewUrl = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW,array(
                            ObjectUrlRule::PARAM_OBJECT_INSTANCE => $id,
                            ObjectUrlRule::PARAM_OBJECT          => 103, //page
                            ObjectUrlRule::PARAM_OBJECT_VIEW     => 57,
                        ));
                        $moduleViewLink = $moduleViewUrl ? "<a target='_BLANK' href='{$moduleViewUrl}' class='pull-right label-link glyphicon glyphicon-link'></a>" : '';
                        echo "<li id='module_{$id}'>
                                <input type='hidden' value='' name='mod_{$id}_seq' class='contSeq'>
                                <input type='hidden' value='' name='mod_{$id}_plc' class='contDid''>
                                <span class='label label-danger {$isVisible}'><sup>{$position}</sup> {$module->name} {$moduleViewLink}</span>
                              </li>";
                    }
                } ?>
            </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
    <?php
    // Пробег по всем положениям модулей
    $ref = ReferenceElement::model()->byReference(32)->findAll();
    foreach ($ref as $r) {
        $idModulePlace = $r->getIdReferenceElement();
        $placeName = $r->getValue();


        // После заголовка выводим модули, соответствующие данному местоположению
        $placeItems = '';
        if (array_key_exists($idModulePlace, $placesArray)) {
            $arrayItem = $placesArray[$idModulePlace];
            $i = 0;
            foreach ($arrayItem AS $v) {
                $id = $v->id_module;
                $i++;
                $module = $collection->itemAt($id);
                //
                $isVisible = $module->is_visible ? '' : 'opacity-50';

                //todo
                $moduleViewUrl = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_VIEW,array(
                    ObjectUrlRule::PARAM_OBJECT_INSTANCE => $id,
                    ObjectUrlRule::PARAM_OBJECT          => 103, //page
                    ObjectUrlRule::PARAM_OBJECT_VIEW     => 57,
                ));
                $moduleViewLink = $moduleViewUrl ? "<a target='_BLANK' href='{$moduleViewUrl}' class='pull-right label-link glyphicon glyphicon-link'></a>" : '';
                //
                $placeItems .= "<li id='module_{$id}'>
                      <input type='hidden' value='{$v->sequence}' name='mod_{$id}_seq' class='contSeq'>
                      <input type='hidden' value='{$v->place}' name='mod_{$id}_plc' class='contDid'>
                      <span class='label label-success {$isVisible}'><sup>{$i}</sup> {$module->name} {$moduleViewLink}</span>
                    </li>";
            }
        }
        $collapseId = 'js-widget-place-'.$idModulePlace;
        echo "<div class='b-widget-place well' id='place_{$idModulePlace}' >
                  <h4 data-toggle='collapse' data-target='#{$collapseId}' class='cur-pointer'>{$placeName} [id={$idModulePlace}]</h4>
                  <div id='{$collapseId}' class='collapse in'><ul>{$placeItems}</ul></div>
              </div>";
    } ?>
    </div>
</div>
<!-- #modSeqPlace -->
<?php
Yii::app()->clientScript->registerScript('admin.widgetPlace.init', '
          $(".b-widget-place ul").sortable({
              connectWith: ".b-widget-place ul",
              placeholder: "highlight",
              stop: function (event, ui) {
                  $(".b-widget-place").each(function () {
                      m = 1;
                      var did = $(this).attr("id").substr(6, $(this).attr("id").length - 6);
                      $(this).find("li").each(function () {
                          $(this).find("sup").text(m);
                          $(this).find(".contSeq").val(m);
                          $(this).find(".contDid").val(did);
                          m++;
                      })
                  })
              }
          }).disableSelection();
        ', CClientScript::POS_READY);

?>
