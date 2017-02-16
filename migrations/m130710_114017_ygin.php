<?php

class m130710_114017_ygin extends CDbMigration {
  public function safeUp() {
    
    $this->execute("UPDATE `da_object` SET `id_object`='101', `name`='Наборы виджетов', `id_field_order`='16', `order_type`=2, `table_name`='da_site_module_template', `id_field_caption`='13', `object_type`=1, `folder_name`=NULL, `parent_object`=102, `sequence`=7, `use_domain_isolation`=0, `field_caption`='name', `yii_model`='SiteModuleTemplate' WHERE `da_object`.`id_object`='101'");
    $this->execute("INSERT IGNORE INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_101')");
    $this->execute("UPDATE `da_object` SET `id_object`='103', `name`='Виджеты сайта', `id_field_order`='542', `order_type`=1, `table_name`='da_site_module', `id_field_caption`='542', `object_type`=1, `folder_name`='content/modules', `parent_object`=102, `sequence`=8, `use_domain_isolation`=0, `field_caption`='name', `yii_model`='SiteModule' WHERE `da_object`.`id_object`='103'");
    $this->execute("INSERT IGNORE INTO `da_auth_item_child` (`parent`, `child`) VALUES ('dev', 'list_object_103')");
    $this->execute("UPDATE `da_object_view` SET `id_object_view`='57', `id_object`='103', `name`='Виджеты &raquo; Виджеты сайта', `order_no`=1, `visible`=1, `sql_select`=NULL, `sql_from`=NULL, `sql_where`=NULL, `sql_order_by`='name ASC', `count_data`=50, `icon_class`=NULL, `id_parent`=NULL WHERE `da_object_view`.`id_object_view`='57'");
    $this->execute("UPDATE `da_object_view` SET `id_object_view`='55', `id_object`='101', `name`='Виджеты &raquo; Наборы виджетов', `order_no`=1, `visible`=1, `sql_select`=NULL, `sql_from`=NULL, `sql_where`=NULL, `sql_order_by`='id_module_template ASC', `count_data`=50, `icon_class`=NULL, `id_parent`=NULL WHERE `da_object_view`.`id_object_view`='55'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='101', `id_parameter`='13', `id_parameter_type`=2, `sequence`=8, `widget`=NULL, `caption`='Название набора', `field_name`='name', `add_parameter`='0', `default_value`=NULL, `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='101' AND `da_object_parameters`.`id_parameter`='13'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='101', `id_parameter`='16', `id_parameter_type`=9, `sequence`=8, `widget`=NULL, `caption`='Использовать по умолчанию', `field_name`='is_default_template', `add_parameter`='0', `default_value`='0', `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='101' AND `da_object_parameters`.`id_parameter`='16'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='101', `id_parameter`='14', `id_parameter_type`=10, `sequence`=10, `widget`='menu.backend.widgets.manageModule.ManageModuleWidget', `caption`='Виджеты', `field_name`=NULL, `add_parameter`='2', `default_value`=NULL, `not_null`=0, `sql_parameter`='SiteModuleTemplateListOfModule', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='101' AND `da_object_parameters`.`id_parameter`='14'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='101', `id_parameter`='16', `id_parameter_type`=9, `sequence`=8, `widget`=NULL, `caption`='Использовать по умолчанию', `field_name`='is_default_template', `add_parameter`='0', `default_value`='0', `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Набор виджетов будет применяться к новым пунктам Меню корневого уровня' WHERE `da_object_parameters`.`id_object`='101' AND `da_object_parameters`.`id_parameter`='16'");
    $this->execute("UPDATE `da_object_parameters` SET `id_parameter`='15', `id_parameter_type`=7, `sequence`=13, `widget`=NULL, `caption`='Набор виджетов', `field_name`='id_module_template', `add_parameter`='101', `default_value`='SiteModuleTemplate::getIdDefaultTemplate();', `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=1, `need_locale`=0, `search`=0, `is_additional`=1, `hint`='' WHERE `da_object_parameters`.`id_parameter`='15'");
    $this->execute("UPDATE `da_object_parameters` SET `id_parameter`='127', `id_parameter_type`=2, `sequence`=3, `widget`=NULL, `caption`='В адресной строке', `field_name`='alias', `add_parameter`='0', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=1, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Обязательно на английском языке. Необходимо для формирования человекопонятных URLов.' WHERE `da_object_parameters`.`id_parameter`='127'");
    $this->execute("UPDATE `da_object_parameters` SET `id_parameter`='330', `id_parameter_type`=9, `sequence`=21, `widget`=NULL, `caption`='Разрешить удаление', `field_name`='removable', `add_parameter`='0', `default_value`='1', `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=1, `hint`='Актуально для динамических разделов, удаление которых приводит к возникновению критических ошибок.' WHERE `da_object_parameters`.`id_parameter`='330'");
    $this->execute("UPDATE `da_object_view` SET `id_object_view`='2018', `id_object`='520', `name`='Витрина', `order_no`=1, `visible`=1, `sql_select`=NULL, `sql_from`=NULL, `sql_where`=NULL, `sql_order_by`='sequence ASC', `count_data`=50, `icon_class`='icon-retweet', `id_parent`=NULL WHERE `da_object_view`.`id_object_view`='2018'");
    $this->execute("UPDATE `da_object_view` SET `id_object_view`='55', `id_object`='101', `name`='Виджеты &raquo; Наборы виджетов', `order_no`=1, `visible`=1, `sql_select`=NULL, `sql_from`=NULL, `sql_where`=NULL, `sql_order_by`='id_module_template ASC', `count_data`=50, `icon_class`='icon-list-alt', `id_parent`=NULL WHERE `da_object_view`.`id_object_view`='55'");
    $this->execute("UPDATE `da_object_view` SET `id_object_view`='57', `id_object`='103', `name`='Виджеты &raquo; Виджеты сайта', `order_no`=1, `visible`=1, `sql_select`=NULL, `sql_from`=NULL, `sql_where`=NULL, `sql_order_by`='name ASC', `count_data`=50, `icon_class`='icon-list-alt', `id_parent`=NULL WHERE `da_object_view`.`id_object_view`='57'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='20', `id_parameter`='157', `id_parameter_type`=2, `sequence`=16, `widget`=NULL, `caption`='yii-модель', `field_name`='yii_model', `add_parameter`='0', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Например: ygin.models.File или просто Domain, если есть точная уверенность, что система уже знает о модели' WHERE `da_object_parameters`.`id_object`='20' AND `da_object_parameters`.`id_parameter`='157'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='20', `id_parameter`='155', `id_parameter_type`=2, `sequence`=7, `widget`=NULL, `caption`='Путь к документам', `field_name`='folder_name', `add_parameter`='0', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Путь к папке на сервере относительно корня сайта для хранения загружаемых файлов. Например, \"content/news\" для сохранения загрузки фотографий к новостям.' WHERE `da_object_parameters`.`id_object`='20' AND `da_object_parameters`.`id_parameter`='155'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='63', `id_parameter`='409', `id_parameter_type`=9, `sequence`=7, `widget`=NULL, `caption`='Видимость', `field_name`='visible', `add_parameter`='0', `default_value`='1', `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Определяет видимость представления в меню системы управления. В случае отсутствия видимости, представление остаётся доступным по прямой ссылке.' WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='409'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='63', `id_parameter`='407', `id_parameter_type`=1, `sequence`=12, `widget`=NULL, `caption`='Экземпляров на странице', `field_name`='count_data', `add_parameter`='0', `default_value`='50', `not_null`=1, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Определяет количество отображаемых экземпляров объекта на одной странице' WHERE `da_object_parameters`.`id_object`='63' AND `da_object_parameters`.`id_parameter`='407'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='66', `id_parameter`='418', `id_parameter_type`=2, `sequence`=4, `widget`=NULL, `caption`='Заголовок', `field_name`='caption', `add_parameter`='0', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='66' AND `da_object_parameters`.`id_parameter`='418'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='66', `id_parameter`='420', `id_parameter_type`=7, `sequence`=7, `widget`='backend.backend.objectParameter.selectObjectParameterWidget.SelectObjectParameterWidget', `caption`='Свойство объекта', `field_name`='id_object_parameter', `add_parameter`='21', `default_value`=NULL, `not_null`=0, `sql_parameter`=NULL, `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='' WHERE `da_object_parameters`.`id_object`='66' AND `da_object_parameters`.`id_parameter`='420'");
    $this->execute("UPDATE `da_object_parameters` SET `id_object`='66', `id_parameter`='423', `id_parameter_type`=7, `sequence`=10, `widget`=NULL, `caption`='Обработчик', `field_name`='handler', `add_parameter`='80', `default_value`=NULL, `not_null`=0, `sql_parameter`='id_php_script_interface IN (6, 7)', `is_unique`=0, `group_type`=0, `need_locale`=0, `search`=0, `is_additional`=0, `hint`='Особый зарегистрированный в системе скрипт, который будет формировать колонку' WHERE `da_object_parameters`.`id_object`='66' AND `da_object_parameters`.`id_parameter`='423'");

    $path = dirname(__FILE__)."/../../assets/";
    @HFile::removeDirectoryRecursive($path, false, false, false, array(".gitignore"));
  }

  public function safeDown() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }
}
