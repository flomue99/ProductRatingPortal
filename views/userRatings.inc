<?php $render('partial/header', $data); ?>


<?php
if (isset($data['ratings']) && sizeof($data['ratings']) > 0) {
    $render('partial/ratingsList', ['ratings' => $data['ratings'], 'userId' => $data['user']->id, 'options' => $data['options'], 'context' => $data['context']]);
} else {
    ?>
    <p>No ratings available</p>
    <?php
}
?>

<?php $render('partial/footer', $data); ?>
