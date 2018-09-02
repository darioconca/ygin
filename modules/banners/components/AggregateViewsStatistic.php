<?php
Yii::import('ygin.modules.banners.models.*');

class AggregateViewsStatistic extends SchedulerJob
{

    public function run()
    {
        $fileName = Yii::app()->getRuntimePath() . '/banner_stat.dat';
        if (!file_exists($fileName)) {  // статистики нет
            return self::RESULT_OK;
        }
        $tmpFileName = "{$fileName}.tmp";
        if (file_exists($tmpFileName)) {
            Yii::log("Обнаружен файл '{$tmpFileName}', возможно, его обработка еще не завершена.",CLogger::LEVEL_ERROR,__CLASS__);
            return 1;
        }
        rename($fileName, $tmpFileName);
        $resultArr = array();
        $statFile = fopen($tmpFileName, "r");
        if ($statFile) {
            Yii::beginProfile('aggregate views stat', __CLASS__);
            while ($rawStatData = fgets($statFile)) {
                $statData = trim($rawStatData);
                if (empty($statData)) {
                    continue;
                }
                $statData = explode(",", $statData);
                $statDataValue = trim($statData[0]);
                $statDataKey   = trim($statData[1]);
                if (array_key_exists($statDataKey, $resultArr)) {
                    $resultArr[$statDataKey][] = $statDataValue;
                } else {
                    $resultArr[$statDataKey] = array($statDataValue);
                }
            }
            Yii::beginProfile('aggregate views stat', __CLASS__);
        }

        StatView::newViewPacket(Banner::ID_OBJECT, $resultArr, BannerPlace::STAT_VIEW_DAY, 'd.m.Y', false);
        StatView::newViewPacket(Banner::ID_OBJECT, $resultArr, BannerPlace::STAT_VIEW_MONTH, 'm.Y', false);
        StatView::newViewPacket(Banner::ID_OBJECT, $resultArr, BannerPlace::STAT_VIEW_ALL, '', false);

        @unlink($tmpFileName);
        if (file_exists($tmpFileName)) {
            Yii::log("Не удалось удалить временный файл {$tmpFileName}",CLogger::LEVEL_WARNING,__CLASS__);
        }
        return self::RESULT_OK;
    }

}