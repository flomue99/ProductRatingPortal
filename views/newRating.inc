<?php $render('partial/header', $data); ?>
    <h1>Add rating</h1>
    <div class="card bg-light col-6 mb-3">
        <div class="card-body">
            <h2 class="card-title"><?php $htmlOut($data['product']->name); ?></h2>
            <p><strong>Manufacturer:</strong> <?php $htmlOut($data['product']->manufacturer); ?></p>
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
        </div>
    </div>
<?php $beginForm('Ratings', 'Create', ['pid' => $data['product']->id], method: 'post'); ?>
    <div class="col-6 card bg-light mb-3 p-3">
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Rating</label>

            <select class="form-select" aria-label="Default select example" name="rat">
                <option selected>Select rating grade</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label fw-bold">Comment</label>
            <textarea rows="5" class="form-control" id="comment"
                      name="com"><?php $htmlOut($data['comment']); ?></textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="text-center w-50 btn btn-sm btn-success">Add rating</button>
        </div>
    </div>
<?php $endForm(); ?>
<?php $link('Cancel', 'Details', 'Index', ['pid' => $data['product']->id], 'btn btn-sm btn-danger mb-1') ?>

<?php $render('partial/footer', $data); ?>