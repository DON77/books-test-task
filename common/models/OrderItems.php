<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_items".
 *
 * @property int $id
 * @property int $order_id
 * @property int $book_id
 *
 * @property Books $book
 * @property Orders $order
 */
class OrderItems extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'order_items';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['order_id', 'book_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['book_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'book_id' => 'Book ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBook() {
        return $this->hasOne(Books::className(), ['id' => 'book_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOrder() {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

}
