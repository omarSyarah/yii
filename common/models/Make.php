<?php

namespace common\models;
use yii\behaviors\BlameableBehavior;

use yii\behaviors\TimestampBehavior;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%makes}}".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 *
 * @property Model[] $models
 * @property Post[] $posts
 */
class Make extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%makes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
     * @return \common\models\query\MakesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MakesQuery(get_called_class());
    }

    public function getModel()
    {
        return $this->hasMany(Model::class, ['make_id' => 'id']);
    }

//    public function getPost()
//    {
//        return $this->hasOne(Post::className(), ['id' => 'make_id']);
//    }




}
