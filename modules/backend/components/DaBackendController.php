<?php

abstract class DaBackendController extends DaWebController
{

    public $layout = 'backend.views.layouts.main';
    public $pageDescription = null;

    private $_counter = 0;

    public function init()
    {
        parent::init();
        $_SERVER['HTTP_X_REWRITE_URL'] = null;
        $components = array('request' => new CHttpRequest());
        Yii::app()->setComponents($components); // для правильной генерации урлов

        Yii::app()->attachEventHandler(BackendApplication::EVENT_ON_YIIGIN_MESSAGE, array($this, 'addSticker'));
    }

    public function addSticker(MessageEvent $event)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $options = array('text' => $event->message, 'type' => $event->type, 'sticked' => $event->sticked, 'time' => $event->time * 1000);
            $this->_counter++;
            Yii::app()->clientScript->registerScript('backend.sticker_' . $this->_counter, '$.daSticker(' . CJavaScript::encode($options) . ');', CClientScript::POS_READY);
        }
    }

    protected function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            //print_r(Yii::app()->authManager->checkObject('list', Yii::app()->user->id));
            $loginPage = ($this->getModule() != null && $this->getModule()->getId() == 'user' && $this->getId() == 'user' && $action->getId() == 'login');
            if (!Yii::app()->user->checkAccess('showAdminPanel')) {
                if (!$loginPage) {
                    $errorPage = ($this->getModule() == null && $this->getId() == 'static' && $action->getId() == 'error');
                    $logoutPage = ($this->getModule() != null && $this->getModule()->getId() == 'user' && $this->getId() == 'user' && $action->getId() == 'logout');
                    if (Yii::app()->user->isGuest && !Yii::app()->request->isAjaxRequest && $action->getId() != 'captcha') {
                        Yii::app()->user->setReturnUrl(Yii::app()->request->url);
                        Yii::app()->user->loginRequired();
                    } else if (!$errorPage && !$logoutPage) {
                        $link = CHtml::link('авторизоваться заново', Yii::app()->createUrl('logout'));
                        throw new CHttpException(httpCode::FORBIDDEN, '<div style="text-align: center;" class="alert alert-danger col-lg-7">Доступ к странице запрещен, попробуйте ' . $link . '.</div>');
                    }
                } else {
                    if (Yii::app()->user->returnUrl == '/') {
                        Yii::app()->user->returnUrl = Yii::app()->createUrl('');
                    }
                }
            } else {
                if ($loginPage) {
                    // переходим на главную
                    Yii::app()->getRequest()->redirect(Yii::app()->createUrl(''));
                }
            }

        }
        return true;
    }

}