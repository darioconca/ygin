<?php

class ReviewPlugin extends PluginAbstract {
  
  public static function createPlugin(array $config) {
    return new ReviewPlugin();
  }
  
  public function getName() {
    return 'Отзывы';
  }
  public function getVersion() {
    return '1.0';
  }
  public function getVersionDate() {
    return '28.08.2012'; // формат?
  }
  public function getShortDescription() {
    return 'Позволяет принимать отзывы клиентов и публиковать их на сайте.';
  }
  
  public function getParametersValueFromConfig($config, $data) {
    if (isset($config['modules']['ygin.review'])) {
      $params = $config['modules']['ygin.review'];
      if (isset($params['idEventType'])) {
        unset($params['idEventType']);
      }
      return $params;
    }
    return array();
  }
  public function getConfigByParamsValue(array $paramsValue, $data) {
    if (isset($data['id_event_type'])) {
      $paramsValue['idEventType'] = $data['id_event_type'];
    }
    return array('modules' => array('ygin.review' => $paramsValue));
  }
  public function getSettingsOfParameters() {
    return array(
        'pageSize' => array(
            'type' => DataType::INT,
            'default' => 15,
            'label' => 'Количество отзывов на страницу',
            'description' => null,
            'required' => true,
        ),
        'moderate' => array(
            'type' => DataType::BOOLEAN,
            'default' => true,
            'label' => 'Проводить модерацию перед отображением на сайте',
            'description' => null,
            'required' => false,
        ),
    );
  }
  
  public function install(Plugin $plugin) {
    $plugin->setData(array(
        'id_object' => 530,
    ));
  }
  public function activate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null) $data = array();
    if (isset($data['id_menu']) && is_numeric($data['id_menu'])) { // не должно быть такого
      return;
    }

    $eventType = $this->prepareEventType('Новый отзыв');
    $eventType->save();
    $data['id_event_type'] = $eventType->id_event_type;

    // создаем раздел меню
    $menu = $this->prepareMenu(
            'Отзывы', 'Отзывы', 'review', '/review/', (isset($data['id_menu_module_template']) ? $data['id_menu_module_template'] : null)
    );
    $menu->save();
    $data['id_menu'] = $menu->id;
    
    $this->createPermission($data['id_object'], 'Просмотр списка данных объекта Отзывы');

    $this->updateMenu = true;

    $plugin->setData($data);
    $plugin->setConfig($this->getConfigByParamsValue($plugin->getParamsValue(), $data));
  }
  
  public function deactivate(Plugin $plugin) {
    $data = $plugin->getData();
    if ($data === null || !isset($data['id_menu'])) {
//      throw new ErrorException('Плагин установлен неверно.');
    }
    
    $data = $this->deleteMenu(@$data['id_menu'], $data, 'id_menu_module_template');
    
    // Удаляем: все отправленные и неотправленные события по типу события + подписчиков + тип события
    $eventType = (isset($data['id_event_type']) ? NotifierEventType::model()->findByPk($data['id_event_type']) : null);
    if ($eventType != null) {
      $eventType->delete();
    }
    
    Yii::app()->authManager->removeAuthItemObject('list', $data['id_object']);
    $this->updateMenu = true;
    
    unset($data['id_menu'], $data['id_event_type']);
    
    $plugin->setData($data);
  }
  
}