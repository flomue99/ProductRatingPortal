<table class="table align-middle table-striped table-hover">
    <thead class="">
    <tr>
        <th>Rating from</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Created at</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data['ratings'] as $rating) : ?>
        <?php if ((isset($data['userId'])) && ($data['userId'] == $rating->userId)) : ?>
            <tr class="table-info">
        <?php else: ?>
            <tr>
        <?php endif; ?>
        <td><?php $htmlOut($rating->userName); ?></td>
        <td><?php $htmlOut($rating->rating); ?></td>
        <td><?php $htmlOut($rating->comment); ?></td>
        <td><?php $htmlOut($rating->createdAt); ?></td>
        <?php if (isset($data['options']) && (isset($data['userId'])) && ($data['userId'] == $rating->userId)) : ?>
            <td class="">
                <div class="btn-group gap-1">
                    <?php $link('Edit rating', 'Ratings', 'Update', ['pid' => $rating->productId], cssClass: 'btn btn-sm btn-info '); ?>
                    <?php $beginForm('Ratings', 'Delete', method: 'post'); ?>
                    <input type="number" name="pid" value="<?php $htmlOut($rating->productId); ?>" hidden="hidden">
                    <input type="number" name="rid" value="<?php $htmlOut($rating->id); ?>" hidden="hidden">
                    <button class="btn btn-sm btn-danger " type="submit">Delete rating</button>
                    <?php $endForm(); ?>
                </div>
            </td>
        <?php else: ?>
            <td>
            </td>
        <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

