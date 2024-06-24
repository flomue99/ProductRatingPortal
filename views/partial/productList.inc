<?php foreach ($data['products'] as $product) : ?>
    <div class="card mb-2 bg-light product-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="card-title"><?php $htmlOut($product->name); ?></h2>
                <?php if (isset($data['userId']) && $data['userId'] == $product->createdBy): ?>
                    <h5 class="text-danger">Owned</h5>
                <?php else: ?>
                    <div></div>
                <?php endif; ?>
            </div>
            <p><strong>Manufacturer:</strong> <?php $htmlOut($product->manufacturer); ?> <br>
                <strong>Created by:</strong> <?php $htmlOut($product->createdByUserName); ?></p>
            <p><?php $htmlOut($product->description); ?></p>
            <p class=" mb-2 text-black-50">
                <?php $htmlOut(number_format($product->averageRating, 1)); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#a89932"
                     class="bi bi-star-fill mb-1"
                     viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
                out of
                <?php $htmlOut($product->amountOfRatings); ?>
                ratings
            </p>
            <div class="row">
                <div class="col-3">
                    <?php $link('View details', 'Details', 'Index', ['pid' => $product->id], cssClass: 'btn btn-sm btn-outline-primary mb-1') ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>