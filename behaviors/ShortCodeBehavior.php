<?php

class ShortCodeBehavior extends CActiveRecordBehavior
{
    public $shortCodeContentField;

    public $shortCodeStatusField;

    public $schemeStart = '[w:';
    public $schemeEnd   = ']';

    const STATUS_NOT_FOUND  = 0;
    const STATUS_FOUND      = 1;
    const STATUS_FORBIDDEN  = 2; //не  искать

    /**
     * @var string alias if needle using default location 'path.to.widgets'
     */
    public $location = '';
    /**
     * @var string global classname suffix like 'Widget'
     */
    public $classSuffix = '';

    /**
     * @var
     */
    protected $_widgetToken;

    /**
     * @return bool
     */
    public function isDetected(){
        return $this->getOwner()->{$this->shortCodeStatusField} == self::STATUS_FOUND;
    }


    public function beforeSave($event)
    {
        if ( $this->getOwner()->{$this->shortCodeStatusField} !=  self::STATUS_FORBIDDEN){
            $text = $this->getOwner()->{$this->shortCodeContentField};
            if ( $this->findShortCode($text) ){
                $this->getOwner()->{$this->shortCodeStatusField} = self::STATUS_FOUND;
            }else{
                $this->getOwner()->{$this->shortCodeStatusField} = self::STATUS_NOT_FOUND;
            }
        }

        $this->_initToken();
    }

    /**
     * @param $text
     * @return bool
     */
    protected function findShortCode($text){

        $pattern = sprintf(
            '/%s(.+?)%s/ims',
            preg_quote($this->schemeStart, '/'), preg_quote($this->schemeEnd, '/')
        );

        if (preg_match($pattern, $text, $matches)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @todo add force rendering with search
     * @return mixed
     */
    public function renderShortCodes()
    {
        $text = $this->getOwner()->{$this->shortCodeContentField};
        if ( $this->getOwner()->{$this->shortCodeStatusField} == self::STATUS_FOUND ){
            $text = $this->_clearAutoParagraphs($text);
            $text = $this->_replaceBlocks($text);
            $text = $this->_processWidgets($text);
        }
        return $text;
    }
    /**
     * Content cleaner
     * Use $this->clearWidgets($model->text) in view
     * @param $text
     * @return mixed
     */
    public function clearWidgets($text)
    {
        $text = $this->_clearAutoParagraphs($text);
        $text = $this->_replaceBlocks($text);
        $text = $this->_clearWidgets($text);
        return $text;
    }

    /**
     * @param $text
     * @return mixed
     */
    protected function _processWidgets($text)
    {
        if (preg_match_all('|\{' . $this->_widgetToken . ':(.+?)' . $this->_widgetToken . '\}|is', $text, $widgets))
        {
            foreach ($widgets[1] as $widgetIndex => $widget){
                $widgetFields = explode(' ',trim($widget));
                $widgetClass = array_shift($widgetFields);
                $widgetAttributes = $this->_parseAttributes($widgetFields);
                $widgetContent = $this->_loadWidget($widgetClass, $widgetAttributes);
                $text = str_replace($widgets[0][$widgetIndex],$widgetContent , $text);
            }
            return $text;
        }
        return $text;
    }
    protected function _clearWidgets($text)
    {
        return preg_replace('|\{' . $this->_widgetToken . ':.+?' . $this->_widgetToken . '\}|is', '', $text);
    }
    protected function _initToken()
    {
        $this->_widgetToken = md5(microtime());
    }

    /**
     * @param $text
     * @return mixed
     */
    protected function _replaceBlocks($text)
    {
        $text = str_replace($this->schemeStart, '{' . $this->_widgetToken . ':', $text);
        $text = str_replace($this->schemeEnd, $this->_widgetToken . '}', $text);
        return $text;
    }
    protected function _clearAutoParagraphs($output)
    {
        $output = str_replace('<p>' . $this->schemeStart, $this->schemeStart, $output);
        $output = str_replace($this->schemeEnd . '</p>', $this->schemeEnd, $output);
        return $output;
    }

    /**
     * @param $name
     * @param $attributes
     * @return mixed|string
     */
    protected function _loadWidget($name, $attributes)
    {
        $cache = $this->_extractCacheExpireTime($attributes);
        $index = 'widget_' . $name . '_' . serialize($attributes);
        if ($cache && $cachedHtml = Yii::app()->cache->get($index)) {
            $html = $cachedHtml;
        } else {
            //$html = '';
            ob_start();
            $widgetClass = $this->_getFullClassName($name);

            //set_error_handler(function($errno, $errstr, $errfile, $errline ){
                //@todo logging
                //$html = '';
                //echo 'sdfsdf';
                //return $html;
            //});
            $widget = Yii::app()->getWidgetFactory()->createWidget($this->owner, $widgetClass, $attributes);
            //restore_error_handler();

            $widget->init();
            $widget->run();
            $html = trim(ob_get_clean());
            Yii::app()->cache->set($index, $html, $cache);
        }
        return $html;
    }

    /**
     * @param $attributeStrings
     * @return array
     */
    protected function _parseAttributes($attributeStrings)
    {
        $attributes = array();
        if ( empty($attributesString)){
            return $attributes;
        }
        foreach ($attributeStrings as $attributeValueString){
            $attributePair = explode('=',$attributeValueString);
            if ( isset($attributePair[1]) ){ //attr[0] => value[1]
                $attributes[ $attributePair[0] ] = $attributePair[1];
            }
        }
        return $attributes;
    }

    /**
     * @param $attrs
     * @return int
     */
    protected function _extractCacheExpireTime(&$attrs)
    {
        $cache = 0;
        if (isset($attrs['cache']))
        {
            $cache = (int)$attrs['cache'];
            unset($attrs['cache']);
        }
        return $cache;
    }

    /**
     * @param $name
     * @return string
     */
    protected function _getFullClassName($name)
    {
        $widgetClass = $name . $this->classSuffix;
        if ($this->_getClassByAlias($widgetClass) == $widgetClass && $this->location){
            $widgetClass = $this->location . '.' . $widgetClass;
        }
        return $widgetClass;
    }

    protected function _getClassByAlias($alias)
    {
        $paths = explode('.', $alias);
        return array_pop($paths);
    }
}