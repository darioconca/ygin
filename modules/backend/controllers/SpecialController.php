<?php

class SpecialController extends DaObjectController
{
    /**
     * коды операций сброса кеша
     */
    const CLEAR_CACHE_COMPONENT = 1;
    const CLEAR_CACHE_PREVIEWS = 2;
    const CLEAR_CACHE_SCALE = 3;
    const CLEAR_CACHE_ASSETS = 4;


    public function actionSql()
    {
        $delimiter = ';';

        if (isset($_POST['sql']) && $_POST['sql'] != null) {

            try{
                if (preg_match('~^\s*(SELECT|SHOW)~i', $_POST['sql'])) {
                    $dataReader = Yii::app()->db->createCommand(HU::post('sql'))->query();
                    $dataRows = '';
                    $first = true;
                    while (($row = $dataReader->read()) !== false) {
                        $dataRow = '';
                        if ($first) {
                            $first = false;
                            foreach ($row as $k => $v) {
                                $dataRow .= "<td><b>{$k}</b></td>";
                            }
                        } else {
                            foreach ($row as $k => $v) {
                                $dataRow .= "<td>{$v}</td>";
                            }
                        }
                        $dataRows .= "<tr>{$dataRow}</tr>";
                    }
                    //
                    echo '<div><b>Rows count: ' . $dataReader->count() . '</b></div>';
                    echo "<table class='sqlTable' border='1' cellpadding='1' cellspacing='0'>{$dataRows}</table>";
                } else {
                    $_POST['sql'] = str_replace("\r", '', HU::post('sql'));
                    if (preg_match('~\ndelimiter(.*)\n~iUs', $_POST['sql'], $reg)) {
                        $delimiter = trim($reg[1]);
                        $_POST['sql'] = preg_replace('~\ndelimiter(.*)\n~iUs', "\n", $_POST['sql']);
                    }
                    $_POST['sql'] = preg_replace('~--.*\n~iUs', "\n", $_POST['sql']);

                    $sqlArray = explode("$delimiter\n", $_POST['sql']);
                    $errors = array();
                    $affected = 0;
                    foreach ($sqlArray as $k => $sqlQuery) {
                        if (trim($sqlQuery) == null) {
                            unset($sqlArray[$k]);
                            continue;
                        }
                        $affected += Yii::app()->db->createCommand($sqlQuery)->execute();
                    }
                    $queriesCount = count($sqlArray);
                    $errorsCount = count($errors);
                    $successCount = $queriesCount - $errorsCount;

                    echo "<p>Выполнено {$successCount} из {$queriesCount} запросов</p>";
                    echo "<p>Затронуто рядов: {$affected}</p>";
                    if ($errorsCount > 0) {
                        echo "<h3>Ошибки:</h3>";
                        echo '<ul><li>' . implode('</li><li>', $errors) . '</ul>';
                    }
                }
            }catch (Exception $e){
                echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
            }
            return;
            //
        }
        //
        if ( !isset($_POST['sql']) ){
            $this->render('sql', array());
        }
    }

    public function actionClearCache()
    {
        $this->render('clearCache', array());
    }

    public function actionClearPreview()
    {
        $this->render('clearPreview', array());
    }

    public function actionLogView()
    {
        $this->render('logView', array());
    }

    public function actionRecreateSearchIndex()
    {
        $this->render('recreateSearchIndex', array());
    }


}