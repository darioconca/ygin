<?php
if (!isset($parameter)) {
    $parameter = '';
}
if (!isset($hint)) {
    $hint = '';
}

/*<label class="control-label"><?php echo $label.$hint.$parameter; ?></label>*/
?>
<div class="form-group">
    <?= $label.$parameter ?>
    <div class="controls col-lg-8">
        <?= $content ?>
        <?php if ($hint) { ?>
            <p><span class="label label-default"><?= $hint ?></span></p>
        <?php } ?>
    </div>
</div>