<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%cities}}".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cities}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['status'], 'integer'],
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
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CitiesQuery(get_called_class());
    }


}
