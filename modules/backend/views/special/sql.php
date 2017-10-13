<style>
    .sqlTable {
        font: 12px Arial;
        empty-cells: show
    }

    .sqlTable > tbody > tr:nth-child(odd) td{
        background: #f5f5f5;
    }
    .sqlTable > tbody > tr:first-child td {
        background: #2fa4e7;
        font-weight: 500;
        color: #FFF;
    }
    .sqlTable > tbody > tr:hover td{
        background: #d9edf7;
    }

    .sqlTable td {
        vertical-align: top;
        background-color: white
    }
</style>
<h3><?= Yii::t('backend','Run SQL'); ?></h3>
<form name="form1" method="post" action="">
    <textarea name="sql" style="width:100%; height:150px; padding:3px; font-family: 'Courier'; font-size: 12px;"
              id="sqlId"><?php echo HU::post('sql') ?></textarea>
    <p>
        <br>
        <?= CHtml::ajaxSubmitButton(Yii::t('backend','Run SQL'), '', array(
            'type'   => 'POST',
            'update' => '#sqlResult',
        ),array(
            'class'  => 'btn btn-default',
        )); ?>
        <br><br>
    </p>
</form>
<script language="javascript">
    document.getElementById('sqlId').focus()
</script>
<div id="sqlResult"></div>

