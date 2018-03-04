<?php

class BackendActiveForm extends CActiveForm
{
    public $errorMessageCssClass = 'label label-danger label-message';
    public $requiredCssClass = 'required';

    public function error($model, $attribute, $htmlOptions = array(), $enableAjaxValidation = true, $enableClientValidation = true)
    {
        $html = '<br class="error-breaker">' . parent::error($model, $attribute, $htmlOptions, $enableAjaxValidation, $enableClientValidation);
        return $html;
    }

    /**
     * @param CModel $model
     * @param string $attribute
     * @param array $htmlOptions
     * @return string
     */
    public function textField($model, $attribute, $htmlOptions = array())
    {
        if ($model->isAttributeRequired($attribute)) {
            $htmlOptions['required'] = 'required';
        }
        return parent::textField($model, $attribute, $htmlOptions);
    }

    /**
     * @param CModel $model
     * @param string $attribute
     * @param array $htmlOptions
     * @return string
     */
    public function textArea($model, $attribute, $htmlOptions = array())
    {
        if ($model->isAttributeRequired($attribute)) {
            $htmlOptions['required'] = 'required';
        }
        return parent::textArea($model, $attribute, $htmlOptions);
    }

    /**
     * @param CModel $model
     * @param string $attribute
     * @param array $htmlOptions
     * @return string
     */
    public function checkBox($model, $attribute, $htmlOptions = array())
    {
        if ($model->isAttributeRequired($attribute)) {
            $htmlOptions['required'] = 'required';
        }
        return parent::checkBox($model, $attribute, $htmlOptions);
    }

    /**
     * @param CModel $model
     * @param string $attribute
     * @param array $data
     * @param array $htmlOptions
     * @return string
     */
    public function dropDownList($model, $attribute, $data, $htmlOptions = array())
    {
        if ($model->isAttributeRequired($attribute)) {
            $htmlOptions['required'] = 'required';
        }
        return parent::dropDownList($model, $attribute, $data, $htmlOptions);
    }

    public function charCounter($model, $attribute, $data, $htmlOptions = array()){
        //@TODO
    }

    public function wordCounter($model, $attribute, $data, $htmlOptions = array()){
        //@TODO
    }
}