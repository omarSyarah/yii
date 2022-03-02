<?php

namespace common\models;
use yii\behaviors\BlameableBehavior;

use yii\behaviors\TimestampBehavior;


use Yii;

/**
 * This is the model class for table "{{%models}}".
 *
 * @property int $id
 * @property string $name
 * @property int|null $make_id
 * @property int|null $status
 */
class Model extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%models}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['make_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'make_id' => 'Make ID',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ModelsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ModelsQuery(get_called_class());
    }
        public function getMake()
    {
        return $this->hasOne(Make::className(), ['id' => 'make_id']);
    }


}
