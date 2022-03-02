<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use common\models\Post;
use common\Status;

/**
 * PostSearch represents the model behind the search form of `common\models\Post`.
 */
class PostSearch extends Post
{

    public $from_date;

    public $to_date;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'make_id', 'model_id', 'city_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['title', 'created_at', 'updated_at','from_date','to_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        print_r($params);
      //  die;
       var_dump($this->from_date);
        var_dump($this->make_id);
      //die();
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
//            exit($dataProvider);
//            echo 'no';
//            die;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'make_id' => $this->make_id,
            'model_id' => $this->model_id,
            'city_id' => $this->city_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
//        var_dump($this->from_date);
//        var_dump($this->to_date);
//
//        die();
        $query->andFilterWhere(['between', 'created_at', $this->from_date, $this->to_date]);

//        print_r($query);
//        die;

//        echo "<pre>";
//        print_r($dataProvider);
//        die;

        return $dataProvider;
    }
}
