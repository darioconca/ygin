<?php

class InfoStatus extends BaseColumn
{

    private $arrayOfInstance = array();

    public $sortable = false;
    public $htmlOptions = array('class' => 'col-rel');

    protected function renderHeaderCellContent()
    {
        return '';
    }

    protected function renderDataCellContent($row, $data)
    {
        $text = "";
        Yii::app()->urlManager->frontendMode = true;
        $link = $data->getUrl();
        Yii::app()->urlManager->frontendMode = false;
        if ($link != null) {
            $text .= "<td><a class='btn btn-mini' href='{$link}' target='_blank' title='открыть страницу на сайте'><i class='glyphicon glyphicon-hand-up'></i></a></td>";
        }

        if (($handler = null) != null) {

        } else {
            if ($data->getGoToType() == Menu::GO_TO_FILE) {
                $text .= '<td><i class="glyphicon glyphicon-download-alt" title="ссылка на загруженный файл"></i></td>';
            }
            if ($data->getExternalLink() != null) {
                $text .= '<td><i class="glyphicon glyphicon-share" title="ссылка на внешний адрес"></i></td>';
            }
            if ($data->content == null) {
                if ($data->getGoToType() == Menu::GO_TO_LIST_CHILD) {
                    $text .= '<td><i class="glyphicon glyphicon-indent-left" title="выводится список вложенных разделов"></i></td>' . "\n";
                } else if ($data->getGoToType() == Menu::GO_TO_FIRST_CHILD) {
                    $text .= '<td><i class="glyphicon glyphicon-step-forward" title="переход к первому потомку"></i></td>' . "\n";
                }
            }
        }

        if ($text != "") {
            $text = "<table class='b-status-bar'><tr>\n{$text}</tr></table>\n";
        }
        echo $text;
    }

}

