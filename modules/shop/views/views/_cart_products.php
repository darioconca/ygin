<ul class="tovarList">
    <?php foreach ($products as $product){ ?>
        <li data-qty="<?= $product->countInCart ?>" data-id="<?= $product->id_product ?>" class="item">
            <div class="name"><?= $product->name ?></div>
            <div class="kolvo">
                <input value="<?= $product->countInCart ?>" maxlength="4"> шт.
            </div>
        </li>
    <?php } ?>
</ul>