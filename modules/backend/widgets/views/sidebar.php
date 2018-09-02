<?php

foreach ($items as $item) {
    $this->items = $item['items'];
    if (count($this->items) == 0) {
        continue;
    }
    ?>
    <div class="panel panel-default">
        <a class="panel-heading collapsed" href="#smm-<?= $item['id_object'] ?>" data-toggle="collapse"><?= $item['label'] ?></a>

        <div id="smm-<?= $item['id_object'] ?>" class="collapse panel-collapse">
            <?php $this->parentRun() ?>
        </div>
    </div>
<?php } ?>