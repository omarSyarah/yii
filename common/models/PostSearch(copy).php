<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%posts}}".
 *
 * @property int $id
 * @property string $title
 * @property int $make_id
 * @property int $model_id
 * @property int $city_id
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class PostSearch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'make_id', 'model_id', 'city_id'], 'required'],
            [['make_id', 'model_id', 'city_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'make_id' => 'Make ID',
            'model_id' => 'Model ID',
            'city_id' => 'City ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostSearchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostSearchQuery(get_called_class());
    }
}
