<?php
/**
 * @var VisualElementWidget $this
 */

$caption = $this->getCaption();
$hint = $this->getHint();
$parameter = $this->getParameter();

$requireClass = ($this->isAttributeRequired() ? ' required' : '');

?>
<div class="form-group b-object-property<?php echo $requireClass; ?> b-object-property-wide">
    <label class="control-label col-lg-4">
        <?php echo CHtml::encode($caption); ?>
        <?php if (!empty($hint)){ ?>
            <button data-toggle="tooltip" title="<?php echo nl2br(CHtml::encode($hint)); ?>"
                    class="btn btn-default btn-xs" rel="tooltip" tabindex="99"><i
                    class="glyphicon glyphicon-question-sign"></i></button>
        <?php } ?>
        <?php if (!empty($parameter)){ ?>
            <a href="<?php echo $parameter; ?>" title="Настроить свойство" class="btn btn-default btn-xs"
               target="_blank" tabindex="99"><i class="glyphicon glyphicon-wrench"></i></a>
        <?php } ?>
    </label>

    <div class="controls">
        <?php echo $content; ?>
    </div>
</div>
