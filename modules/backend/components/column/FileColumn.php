<?php

class FileColumn extends BaseColumn
{

    public $previewHeight = 50;

    public function renderDataCell($row)
    {
        //@todo title - file size
        if ($this->objectParameter == null) {
            throw new Exception("Не указан ид параметр у колонки с типом Файл");
        }
        $field = $this->name;
        $data = $this->grid->dataProvider->data[$row];
        $value = $data->$field;

        if ($value != null) {
            $this->htmlOptions = array('class' => 'col-img');
            $file = File::model()->findByPk($value);
            if ($file == null) {
                $value = "";
            } else {
                $link = $file->getUrlPath();
                $fileType = $file->getFileType();
                if ($fileType == null) {
                    $fileType = $file->definitionFileType();
                }
                if ($fileType == File::FILE_IMAGE) {   //Если свойством являетеся картинка, то пробуем сделать для неё превью.
                    if ($file->getStatusProcess() == 1) {
                        $memory = @ini_get("memory_limit");
                        $value = "<div style='text-align:center'><img src=\"/engine/admin/gfx/msg.png\" title=\"Для данного изображения не может быть сгенирована превью-картинка. Как правило, это связано с ограничением оперативной памяти (" . $memory . ") на хостинг-площадке.\" alt=\"\"></div>";
                    } else {
                        $idInstance = $data->getIdInstance();
                        $filePreview = $file->getPreview(0, $this->previewHeight, '_da');
                        if ($filePreview == null) {
                            $value = '<b>Открыть текущий файл для просмотра</b>';
                        } else {
                            $value = '<img src="' . $filePreview->getUrlPath() . '" alt="" />';
                        }
                    }
                    $value = '<a rel="daG" target="_blank" href="' . $link . '">' . $value . '</a>';
                } else {
                    $value = '<a target="_blank" href="' . $link . '" title="Открыть текущий файл для просмотра"><i></i></a>';
                    $this->htmlOptions = array('class' => 'col-action-view');
                }
            }
        }
        echo CHtml::openTag('td', $this->htmlOptions);
        echo $value;
        echo '</td>';
    }
}
