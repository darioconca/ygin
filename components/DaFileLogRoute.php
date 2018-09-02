<?php

class DaFileLogRoute extends CFileLogRoute
{

    /**
     * @param string $message
     * @param int $level
     * @param string $category
     * @param int $time
     * @return string
     */
    protected function formatLogMessage($message, $level, $category, $time)
    {
        $user       = Yii::app()->user;
        $userName   = $user == null ? 'guest' : $user->name;
        $userIp     = HU::getUserIp();
        return parent::formatLogMessage("[{$userIp}] {$userName} {$message}", $level, $category, $time);
    }

}
