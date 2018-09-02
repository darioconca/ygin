<?php

require_once dirname(__FILE__) . '/BaseApplication.php';

/**
 * FrontendApplication
 *
 * The followings are the available component:
 * @property DaDomain $domain
 * @property DaMenu $menu
 */
class FrontendApplication extends BaseApplication
{

    public $isFrontend = true;

}