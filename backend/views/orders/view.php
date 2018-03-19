<?php

use common\models\Orders;
use common\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Orders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'sum',
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return User::find($model->user_id)->one()->username;
                },
            ],
            [
                'label' => 'Books',
                'value' => function ($model) {
                    $books = '';
                    foreach ($model->orderItems as $item) {
                        $books .= $item->book->title . ', ';
                    }
                    return rtrim($books, ', ');
                },
            ],
            'created_at',
        ],
    ])
    ?>

</div>
