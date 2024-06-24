<?php $render('partial/header', $data); ?>
    <div class="card mb-2 border-0 bg-light">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="card-title"><?php $htmlOut($data['product']->name); ?></h2>
                <?php if (isset($data['user']) && ($data['user']->id == $data['product']->createdBy)): ?>
                    <?php $link('Edit products', 'Products', 'Update', ['pid' => $data['product']->id], cssClass: 'btn btn-sm btn-info'); ?>
                <?php else: ?>
                    <div></div>
                <?php endif; ?>
            </div>
            <p><strong>Manufacturer:</strong> <?php $htmlOut($data['product']->manufacturer); ?> <br>
                <strong>Created by:</strong> <?php $htmlOut($data['product']->createdByUserName); ?></p>
            <p><?php $htmlOut($data['product']->description); ?></p>
            <p class=" mb-2 text-black-50">
                <?php $htmlOut(number_format($data['product']->averageRating, 1)); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#a89932"
                     class="bi bi-star-fill mb-1"
                     viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
                out of
                <?php $htmlOut($data['product']->amountOfRatings); ?>
                ratings
            </p>
            <?php if (isset($data['user']) && !($data['ratingFromUserExists'])): ?>
                <?php $link('Rate now', 'Ratings', 'Create', ['pid' => $data['product']->id], cssClass: 'btn btn-sm btn-warning mb-1'); ?>
            <?php endif; ?>
        </div>
    </div>

<?php
if (isset($data['ratings']) && sizeof($data['ratings']) > 0) {
    if (isset($data['user'])) {
        $render('partial/ratingsList', ['ratings' => $data['ratings'], 'userId' => $data['user']->id, 'context' => $data['context']]);
    } else {
        $render('partial/ratingsList', ['ratings' => $data['ratings'], 'context' => $data['context']]);
    }
} else {
    ?>
    <p>No ratings available</p>
    <?php
}
$link('Back to products', 'Products', 'Index', cssClass: 'btn btn-sm btn-danger');
?>

<?php $render('partial/footer', $data); ?>