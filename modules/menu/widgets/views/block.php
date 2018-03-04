<?php
/**
 * @var $modules
 */

foreach ($modules as $module) {
    if ($module->id_php_script != null) { // динамический модуль
        // формируем массив с параметрами
        $params = array();
        $moduleParams = $module->phpScriptInstance->phpScript->getParametersConfig();
        foreach ($moduleParams as $paramName => $config) {
            $params[$paramName] = $module->phpScriptInstance->getParameterValue($paramName);
        }
        $className = $module->phpScriptInstance->phpScript->import();
        $this->controller->widget($className, $params);
    } else {  // статика
        echo $module->content;
        echo $module->html;
    }
}