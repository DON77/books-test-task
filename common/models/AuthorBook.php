<?php

namespace common\models;

use common\models\Authors;
use common\models\Books;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "author_book".
 *
 * @property int $id
 * @property int $author_id
 * @property int $book_id
 *
 * @property Authors $author
 * @property Books $book
 */
class AuthorBook extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'author_book';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['author_id', 'book_id'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'book_id' => 'Book ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor() {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBook() {
        return $this->hasOne(Books::className(), ['id' => 'book_id']);
    }

}
