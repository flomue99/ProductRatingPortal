<?php $render('partial/header', $data); ?>

<h1>Edit Product</h1>
<?php $beginForm('Products', 'Update', method: 'post'); ?>
<div class="col-6 card bg-light p-3 mb-3">
    <input type="number" name="pid" value="<?php $htmlOut($data['product']->id); ?>" hidden="hidden">
    <div class="mb-3">
        <label for="name" class="form-label fw-bold">Product name with
            id <?php $htmlOut($data['product']->id); ?></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name"
               value="<?php $htmlOut($data['product']->name); ?>">
    </div>

    <div class="mb-3">
        <label for="manufacturer" class="form-label fw-bold">Manufacturer</label>
        <input type="text" class="form-control" id="manufacturer" name="manu" placeholder="Enter product manufacturer"
               value="<?php $htmlOut($data['product']->manufacturer); ?>">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea rows="10" class="form-control" id="description"
                  name="desc"><?php $htmlOut($data['product']->description); ?></textarea>
    </div>

    <div class="text-center">
        <button type="submit" class="text-center btn btn-sm btn-success w-50 mb-1">Save</button>
    </div>
</div>
<?php $endForm(); ?>
<?php $link('Cancel', 'Details', 'Index', ['pid' => $data['product']->id], 'btn btn-sm btn-danger mb-1') ?>


<?php $render('partial/footer', $data); ?>
