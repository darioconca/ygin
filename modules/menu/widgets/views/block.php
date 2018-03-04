<?php
/**
 * @var $modules
 */

foreach ($modules as $module) {
    if ($module->id_php_script != null) { // ������������ ������
        // ��������� ������ � �����������
        $params = array();
        $moduleParams = $module->phpScriptInstance->phpScript->getParametersConfig();
        foreach ($moduleParams as $paramName => $config) {
            $params[$paramName] = $module->phpScriptInstance->getParameterValue($paramName);
        }
        $className = $module->phpScriptInstance->phpScript->import();
        $this->controller->widget($className, $params);
    } else {  // �������
        echo $module->content;
        echo $module->html;
    }
}