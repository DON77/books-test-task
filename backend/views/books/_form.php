<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Books */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group authors-wrapper">
        <label class="control-label" for="author-search">Authors</label>
        <input type="text" id="author-search" class="form-control" />
        <div id="authors" style="display: none;">
        </div>
    </div>

    <div id="added-authors">
        <?php
        foreach ($model->authors as $author) {
            echo '<div data-author-id="' . $author['id'] . '" class="added-author">' . $author['name'] . ' <span class="delete-author">X</span></div>';
        }
        ?>
    </div>

    <?= $form->field($model, 'author_ids')->hiddenInput(['value' => $hidden])->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>var book_id = <?php echo $model->id ? $model->id : 0; ?>;</script>

