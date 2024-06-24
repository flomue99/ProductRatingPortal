<?php $render('partial/header', $data); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1>Products</h1>
        <!--You only can add a rating if you are signed in-->
        <?php if (isset($data['user'])): ?>
            <?php $link('Add new Product', 'Products', 'Create', cssClass: 'btn btn-sm btn-outline-warning') ?>
        <?php else: ?>
            <div></div>
        <?php endif; ?>
    </div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <?php $link('All Products', 'Products', 'Index', ['dispAll' => true], 'nav-link' . (true == $data['displayAllProducts'] ? ' active' : ' ')); ?>
        </li>
        <?php if (isset($data['user'])): ?>
            <li class="nav-item">
                <?php $link('My Products', 'Products', 'Index', ['dispAll' => false], 'nav-link' . (false == $data['displayAllProducts'] ? ' active' : ' ')); ?>
            </li>
        <?php endif; ?>
    </ul>
<?php $beginForm('Products', 'Index', ['dispAll' => $data['displayAllProducts']]); ?>
    <div>
        <div class="input-group w-50 mb-3">
            <input type="text" class="form-control " placeholder="Enter filter..." name="ss"
                   value="<?php $htmlOut($data['searchString']); ?>"">
            <button class="btn btn-outline-secondary">Search</button>
        </div>
    </div>
<?php $endForm(); ?>

<?php
if (isset($data['products']) && sizeof($data['products']) > 0) {
    if (isset($data['user'])) {
        $render('partial/productList', ['products' => $data['products'], 'userId' => $data['user']->id, 'context' => $data['context']]);
    } else {
        $render('partial/productList', ['products' => $data['products'], 'context' => $data['context']]);
    }
} else {
    ?>
    <p>No products available</p>
    <?php
}
?>

<?php $render('partial/footer', $data); ?>