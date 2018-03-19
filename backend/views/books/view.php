<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Books */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'price',
            [
                'label' => 'Authors',
                'value' => function ($model) {
                    $authors = '';
                    foreach ($model->authors as $author) {
                        $authors .= mb_substr($author->first_name, 0, 1) . '.' . mb_substr($author->middle_name, 0, 1) . '.' . $author->last_name . ',';
                    }
                    return rtrim($authors, ',');
                },
            ]
        ],
    ])
    ?>

</div>
