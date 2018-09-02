<?php

/**
 * @var $model Banner
 */
$viewStat = $this->viewStat;
?>
    <b>Количество кликов:</b><br>
    за день: <?php echo (isset($viewStat[BannerPlace::STAT_CLICK_DAY])) ? $viewStat[BannerPlace::STAT_CLICK_DAY] : 0; ?><br>
    за месяц: <?php echo (isset($viewStat[BannerPlace::STAT_CLICK_MONTH])) ? $viewStat[BannerPlace::STAT_CLICK_MONTH] : 0; ?><br>
    всего: <?php echo (isset($viewStat[BannerPlace::STAT_CLICK_ALL])) ? $viewStat[BannerPlace::STAT_CLICK_ALL] : 0; ?><br>
<?php if (Yii::app()->getModule('banners')->viewStatisticAvailable): ?>
    <b>Количество показов:</b><br>
    за день: <?php echo (isset($viewStat[BannerPlace::STAT_VIEW_DAY])) ? $viewStat[BannerPlace::STAT_VIEW_DAY] : 0; ?>
    <br>
    за месяц: <?php echo (isset($viewStat[BannerPlace::STAT_VIEW_MONTH])) ? $viewStat[BannerPlace::STAT_VIEW_MONTH] : 0; ?>
    <br>
    всего: <?php echo (isset($viewStat[BannerPlace::STAT_VIEW_ALL])) ? $viewStat[BannerPlace::STAT_VIEW_ALL] : 0; ?>
<?php endif; ?>