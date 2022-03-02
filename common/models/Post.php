<?php

namespace common\models;
use yii\behaviors\BlameableBehavior;

use yii\behaviors\TimestampBehavior;


use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%posts}}".
 *
 * @property int $id
 * @property string $title
 * @property int $price
 * @property int $make_id
 * @property int $model_id
 * @property int $city_id
 * @property int|null $status
 * @property int|null $is_new
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property string $updated_by
 */
class Post extends \yii\db\ActiveRecord
{
//    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CREATE = 'create';

    //this function is used to specify THE DEFAULT SCENARIO
    //in ADDITION to the NEW SCENARIOS
    public function scenarios()
    {
        $scenarios = parent::scenarios();
//        $scenarios[self::SCENARIO_UPDATE] =
//            [
//                'title',
//                'price',
//                'make_id',
//                'model_id',
//                'city_id',
//                'status',
//                'created_at',
//                'updated_at',
//                'created_by',
//                'updated_by'
//            ];
        $scenarios[self::SCENARIO_CREATE] =// i MUST specify all atrributes for the scenario
            [                              //because if i didnt specify it doesnt check the default scenario
                'title',
                'price',
                'make_id',
                'model_id',
                'city_id',
                'status',
                'is_new',//this is different
                'created_at',
                'updated_at',
                'created_by',
                'updated_by'
            ];
        return $scenarios;
    }



    const IS_NEW = 1;
    const IS_OLD = 0;

    private static $newArray= [self::IS_OLD => 'Old Car',self::IS_NEW => 'New Car'];

    static public function getAllPostNewness()
    {
        return [
            self::IS_NEW => 'New Car',
            self::IS_OLD=>'Old Car'
        ];
    }

    static public function getPostNewness($is_new_id)
    {
        return self::$newArray[$is_new_id];
    }

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

//    RULES USED FOR VALIDATION IN PAGE
    public function rules()
    {
        return [
            [['title', 'make_id', 'model_id', 'city_id','price','status'], 'required'],
            [['title', 'make_id', 'model_id', 'city_id','price','is_new','status'], 'required','on'=>self::SCENARIO_CREATE],

            [['make_id', 'model_id', 'city_id', 'status', 'created_by','price'], 'integer'],
            [['created_at', 'updated_at','is_new'], 'safe'],
            [['is_new'],'integer'],
            ['is_new','checkPrice'],
            [['title'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['make_id'], 'exist', 'skipOnError' => true, 'targetClass' => Make::className(), 'targetAttribute' => ['make_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Model::className(), 'targetAttribute' => ['model_id' => 'id']],

        ];
    }
    public function checkPrice($attribute,$params)
    {
        if($this->is_new == 1 && $this->price<50000)
        {
            $this->addError($attribute,'the price for new cars must start from 50 000');
        }elseif ($this->is_new == 0 && ($this->price>50000 || $this->price<10000))
        {
            $this->addError($attribute,'the price for old cars must be between 10 000 and 50 000');

        }
    }

    public function beforeSave($insert)
    {
//        var_dump($insert);
//        die();
        if (!parent::beforeSave($insert))
        {
            return false;
        }
        if($insert)
        {
            //$insert true says we are CREATING , do concatenation here
            $this->title=$this->title." ".$this->make->name." ".$this->model->name;

//            var_dump($this->title);
//            die();
            return true;
        }


        return true;
        //if we add the commented above the update statement works just fine

    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'make_id' => 'Make ID',
            'model_id' => 'Model ID',
            'city_id' => 'City ID',
            'is_new'=>'Is New',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostsQuery(get_called_class());
    }

    public function getMake()
    {
          return $this->hasOne(Make::className(), ['id' => 'make_id']);
    }

    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'model_id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function behaviors()
    {
        return [


                    [
                     'class'=>  BlameableBehavior::class,
                     ]
                    ,

                    'timestamp' => [
                        'class' => TimestampBehavior::className(),
                        'attributes' => [
                                        ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                                        ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                                                    ],
                                        'value' => function() { return date('Y-m-d h:i:s'); },
                                        ],
                                    ]


                                ;
    }


}
