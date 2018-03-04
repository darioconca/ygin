<?php

class DefaultController extends Controller
{

    public function actionIndex()
    {
        if (!YII_DEBUG) {
            throw new CHttpException(HttpCode::NOT_FOUND);
        }

        $model = new CreateViewForm();
        $class = get_class($model);
        if (isset($_POST[$class]) && $data = $_POST[$class]) {
            $this->performAjaxValidation($model);
            $this->createFile($data);
        }

        $form = new CreateViewForm();
        $this->caption = 'Создание файла для вёрстки страницы';
        $this->render('index', array(
            'model' => $form,
        ));
    }

    private function createFile($data)
    {
        if (($filename = $data['filename']) && ($path = $data['path'])) {
            $path = CreateViewForm::VIEWS_PATH . $path;
            if (!file_exists($path)) {
                @mkdir($path, 0777, true);
                @chmod($path, 0777);
            }

            $filename   = trim($filename);
            $path       = trim($path, '/') . '/'; //remove all slashes except last
            $pieces     = explode('.', $filename);
            $filename   = $pieces[0];
            $ext        = '.php';
            $caption    = '';
            if (isset($data['caption'])){
                $caption = CHtml::encode($data['caption']);
            }

            if (file_exists($path)) {
                $file = fopen($path . $filename . $ext, 'w+');

                //генерим html для файла
                $html = '<?php $this->caption = "' . $caption . '";?>';
                $html .= "<div class='alert alert-success'> Файл для редактирования данного представления создан и находится по адресу: <code>{$path}{$filename}{$ext}</code></div>";
                fwrite($file, $html);
                fclose($file);
            } else {
                throw new CHttpException(HttpCode::INTERNAL_SERVER_ERROR, "Файл по адресу {$path}{$filename}{$ext} не создан! Введите правильный путь!");
            }

            if (file_exists($path . $filename . $ext)) {
                Yii::setPathOfAlias('webroot.' . str_replace('/', '.', trim($path, '/')) . "." . $filename, $path . $filename . $ext);

                if (Yii::app()->isBackend) {
                    $link = str_replace('admin/', '', Yii::app()->createUrl('viewGenerator/html/index/', array(
                        'view' => $filename,
                        'path' => $path
                    )));
                } else {
                    $link = Yii::app()->createUrl('viewGenerator/html/index/', array(
                        'view' => $filename,
                        'path' => $path
                    ));
                }

                $this->redirect($link);
            } else {
                throw new CHttpException(HttpCode::INTERNAL_SERVER_ERROR, "Файл по адресу {$path}.{$filename}.{$ext} не создан!");
            }
        }
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'viewGen-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}