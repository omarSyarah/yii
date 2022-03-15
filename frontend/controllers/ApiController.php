<?php

namespace frontend\controllers;

use common\models\Post;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\rest\Controller;


class ApiController extends controller
{

//    public $modelClass = 'app\models\Post';
//    public $modelClass = 'app\common\models\Post';
//    public $modelClass = 'var\www\html\yii\common\models\Post';

    protected function verbs()
    {
        return [
            'index' => ['GET'],
//            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];

    }

//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => \yii\filters\VerbFilter::class,
//                'actions' => [
//                    'index'  => ['POST'],
////                    'view'   => ['GET'],
//                    'create' => [ 'POST'],
//                    'update' => [ 'PUT', 'PATCH'],
//                    'delete' => ['DELETE'],
//                ],
//            ],
//        ];
//    }

     public function actionIndex()
     {

         $query=Post::find();
//         $query=Post::find()->all();

//         $query = Post::find();
//         // get the total number of users
//         $count = $query->count();
//         //creating the pagination object
//         $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 5]);
//         //limit the query using the pagination and retrieve the users
////         $models = $query->offset($pagination->offset)
////             ->limit($pagination->limit)
////             ->all();

         $activeData = new ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'defaultPageSize' => 2 ,
                 'pageSize' => 2,
                 'pageSizeLimit' => [0, 2],
//                 'pageSizeLimit' => [1, 2],

             ]
         ]);
//         $posts=Post::find()->asArray()->all();
//         var_dump($posts);die();
//         return json_encode($posts);
         return $activeData;

     }
   public function actionCreate($title,$price,$make_id,$model_id,$city_id,$status,$is_new)
   {
       $post=new Post();
       $post->title=$title;
       $post->price=$price;
       $post->make_id=$make_id;
       $post->model_id=$model_id;
       $post->city_id=$city_id;
       $post->status=$status;
       $post->is_new=$is_new;

       if($post->save())
           return "post has been created";
       else
           return "problem while creating";


   }

   public function actionDelete($id)
   {
       $post=Post::find()->where(["id"=>$id])->one();

       if($post->delete())
           return "post has been deleted";
       else
           return "problem while deleting a post";

   }

   public function actionUpdate($id,$title,$price,$make_id,$model_id,$city_id,$status,$is_new)
   {
       $post=Post::find()->where(["id"=>$id])->one();
//       return var_dump($post);
       $post->title=$title;
       $post->price=$price;
       $post->make_id=$make_id;
       $post->model_id=$model_id;
       $post->city_id=$city_id;
       $post->status=$status;
       $post->is_new=$is_new;
       if($post->save())
           return "post has been updated";
       else
           return "problem while updating";
   }
}