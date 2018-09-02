<?php

class Robokassa extends BillingComponent
{

    public $InvoiceIdParamName = 'InvId';

    public $paramNameLogin = 'robokassa_merchant_login';
    public $paramNamePass1 = 'robokassa_merchant_pass1';
    public $paramNamePass2 = 'robokassa_merchant_pass2';

    private $_testUrl = 'http://test.robokassa.ru/Index.aspx?MrchLogin=%login%&OutSum=%sum%&InvId=%id%&Desc=%desc%&SignatureValue=%sign%&Culture=%culture%%label%';
    private $_liveUrl = 'https://merchant.roboxchange.com/Index.aspx?MrchLogin=%login%&OutSum=%sum%&InvId=%id%&Desc=%desc%&SignatureValue=%sign%&Culture=%culture%%label%';


    protected function getPaySign($nOutSum, $nInvId)
    {
        $keys = array(
            $this->sMerchantLogin,
            $nOutSum,
            $nInvId,
            $this->sMerchantPass1,
        );
        return md5(implode(':', $keys));
    }

    public function pay($nOutSum, $nInvId, $sInvDesc)
    {
        $sign = $this->getPaySign($nOutSum, $nInvId);

        $url = $this->isTest ? $this->_testUrl : $this->_liveUrl;

        Yii::app()->controller->redirect(strtr($url,array(
            '%login%' => $this->sMerchantLogin,
            '%sum%' => $nOutSum,
            '%id%' => $nInvId,
            '%desc%' => $sInvDesc,
            '%sign%' => $sign,
            '%culture%' => $this->sCulture,
            '%label%' => !empty($this->sIncCurrLabel) ? "&IncCurrLabel={$this->sIncCurrLabel}" : '',
        )));
    }

    public function result()
    {
        $var = $_GET + $_POST;
        extract($var);
        $event = new CEvent($this);

        $valid = true;

        if ($valid && !isset($OutSum, $InvId, $SignatureValue)) {
            $this->params = array(
                'reason' => 'Dont set need value',
            );
            $valid = false;
        }

        if ($valid && !$this->checkResultSignature($OutSum, $InvId, $SignatureValue)) {
            $this->params = array(
                'reason' => 'Signature fail',
            );
            $valid = false;
        }

        if ($valid && !$this->isOrderExists($InvId)) {
            $this->params = array(
                'reason' => 'Order not exists',
            );
            $valid = false;
        }

        if ($valid && $this->_order->{$this->priceField} > $OutSum) {
            $this->params = array(
                'reason' => 'Order price error',
            );
            $valid = false;
        }

        if ($valid) {
            if ($this->hasEventHandler('onSuccess')) {
                $this->params = array(
                    'order' => $this->_order,
                );
                $this->onSuccess($event);
            }
        } else {
            if ($this->hasEventHandler('onFail')) {
                $this->onFail($event);
                Yii::app()->end('FAIL');
            }
        }

        echo "OK{$InvId}\n";
    }

}
