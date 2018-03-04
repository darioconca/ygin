<?php
/**
 * @var string $template
 * @var string $menu
 */

echo strtr($template, array(
    '{menu}' => $menu,
));