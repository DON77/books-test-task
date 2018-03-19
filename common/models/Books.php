<?php

namespace common\models;

use common\models\AuthorBook;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property double $price
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthorBook[] $authorBooks
 */
class Books extends ActiveRecord {

    public $author_ids;

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'price',], 'required'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['author_ids', 'required', 'isEmpty' => function ($value) {
                    return empty($value) || $value == '|';
                }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthors() {
        return $this->hasMany(Authors::className(), ['id' => 'author_id'])
                        ->via('authorBook');
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthorBook() {
        return $this->hasMany(AuthorBook::className(), ['book_id' => 'id']);
    }

}
