<?php $render('partial/header', $data); ?>

<h1>Create new Product</h1>
<?php $beginForm('Products', 'Create', method: 'post'); ?>
<div class="col-6 card bg-light p-3 mb-3">
    <div class="mb-3">
        <label for="name" class="form-label fw-bold">Product name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name"
               value="<?php $htmlOut($data['name']); ?>">
    </div>

    <div class="mb-3">
        <label for="manufacturer" class="form-label fw-bold">Manufacturer</label>
        <input type="text" class="form-control" id="manufacturer" name="manu" placeholder="Enter product manufacturer"
               value="<?php $htmlOut($data['manufacturer']); ?>">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea rows="10" class="form-control" id="description"
                  name="desc"><?php $htmlOut($data['description']); ?></textarea>
    </div>

    <div class="text-center">
        <button type="submit" class="text-center w-50 btn btn-sm btn-outline-success">Add product</button>
    </div>
</div>
<?php $endForm(); ?>
<?php $link('Back to products', 'Products', 'Index', cssClass: 'btn btn-sm btn-outline-danger'); ?>


<?php $render('partial/footer', $data); ?>
