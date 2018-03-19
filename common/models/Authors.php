<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthorBook[] $authorBooks
 */
class Authors extends ActiveRecord {

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
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['first_name', 'last_name', 'middle_name',], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBooks() {
        return $this->hasMany(Books::className(), ['id' => 'book_id'])
                        ->via('authorBook');
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthorBook() {
        return $this->hasMany(AuthorBook::className(), ['author_id' => 'id']);
    }

}
