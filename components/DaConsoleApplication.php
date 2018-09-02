<?php

class DaConsoleApplication extends CConsoleApplication
{

    private $_params = null;

    public function getParams()
    {
        if ($this->_params !== null){
            //nothing
        }else {
            $this->_params = new DaApplicationParameters();
            $this->_params->caseSensitive = true;
        }
        return $this->_params;
    }

    public function __construct($config = null)
    {
        parent::__construct($config);
        register_shutdown_function(array(
            $this,
            'onShutdownHandler',
        ));
    }

    public function onShutdownHandler()
    {
        //http://habrahabr.ru/post/136138/
        // 1. error_get_last() returns NULL if error handled via set_error_handler
        // 2. error_get_last() returns error even if error_reporting level less then error
        $lastError = error_get_last();

        $errorsToHandle = E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING;

        if (!is_null($lastError) && ($lastError['type'] & $errorsToHandle)) {
            $message = 'Fatal error: ' . $lastError['message'];
            // it's better to set errorAction = null to use system view "error.php" instead of run another controller/action (less possibility of additional errors)
            Yii::app()->errorHandler->errorAction = null;
            // handling error
            Yii::app()->handleError($lastError['type'], $message, $lastError['file'], $lastError['line']);
        }
    }
}