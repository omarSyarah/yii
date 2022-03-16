<?php

namespace frontend\controllers;

use common\models\Post;
use http\Message;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\rest\Controller;
use yii\web\UploadedFile;


class ApiController extends controller
{

//    public $modelClass = 'app\models\Post';
//    public $modelClass = 'app\common\models\Post';
//    public $modelClass = 'var\www\html\yii\common\models\Post';

    public function actionIndex()
    {

        $query = Post::find();
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

        $activeData = new ActiveDataProvider(['query' => $query, 'pagination' => ['defaultPageSize' => 2, 'pageSize' => 2, 'pageSizeLimit' => [0, 2],//                 'pageSizeLimit' => [1, 2],

        ]]);
//         $posts=Post::find()->asArray()->all();
//         var_dump($posts);die();
//         return json_encode($posts);
        $response = ["success" => true, "message" => "posts returned successfully ", "errors" => [], "data" => $activeData


        ];
        return $response;

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

    public function actionCreate($title, $price, $make_id, $model_id, $city_id, $status, $is_new)
    {


        $post = new Post();
        $image = UploadedFile::getInstanceByName('image');
//       $post->load($this->request->post())//from PostController
//       $post->load ( \Yii::$app->getRequest ()->getBodyParams (), '' );
//       $post->load(\Yii::$app->getRequest ()->getBodyParams());
//       return Yii::$app->request->getQueryParams();

//       return $request->postRequest()->getBodyParams();
//       return $request->bodyParams;
//       return yii\web\Request::getBodyParams();
//       return yii\rest\Request::getBodyParams();


        if (is_object($image)) {
            $imageName = time() . "_" . uniqid() . "." . $image->extension;
            $imageDir = '/var/www/html/yii/frontend/images';
            $image->saveAs($imageDir . '/' . $imageName);
        }
//return $imageName;

        //return Yii::$app->request->getQueryParams();
//this is from yii->{public boolean load ( $data, $formName = null )} so the liars say $formName by default is null
//that is not true u have to assign it to empty manually/the second empty parameters in th line below is important don't remove it
        $post->load(Yii::$app->request->getQueryParams(), "");
        $post->image = $imageName;
//       return ["attributes"=>$post->getAttributes(),"query params"=>Yii::$app->request->getQueryParams()
//       ,"post load "=>$post->load(Yii::$app->request->getQueryParams(),"")];
//       return ["post validate"=>$post->validate(),"post validate errors"=>$post->getErrors()];

        if ($post->validate() && is_object($image) && $post->save()) {
            $response = ["success" => true, "message" => "post created successfully ", "image" => $imageName, "errors" => [],


            ];
            return $response;
        } else {
            $response = ["success" => false, "message" => "post could not be created ", "errors" => [

                "validation errors" => $post->getErrors(),],


            ];
            return $response;
        }


    }

    public function actionDelete($id)
    {
        $post = Post::find()->where(["id" => $id])->one();

        if ($post) {
            $post->delete();
            $response = ["success" => true, "message" => "post deleted successfully ", "errors" => [],


            ];
            return $response;
        } else {
            $response = ["success" => false, "message" => "post could not be deleted ", "errors" => ["code" => 500, "message" => "server error"],


            ];
            return $response;
        }

    }

    public function actionUpdate($id, $title, $price, $make_id, $model_id, $city_id, $status, $is_new)
    {
        $post = Post::find()->where(["id" => $id])->one();
        $post->title = $title;
        $post->price = $price;
        $post->make_id = $make_id;
        $post->model_id = $model_id;
        $post->city_id = $city_id;
        $post->status = $status;
        $post->is_new = $is_new;
        if ($post->save()) {
            $response = ["success" => true, "message" => "post updated successfully ", "errors" => [],

            ];
            return $response;
        } else {
            $response = ["success" => false, "message" => "post could not be updated ", "errors" => ["code" => 500, "message" => "server error"],


            ];
            return $response;
        }
    }

    protected function verbs()
    {
        return ['index' => ['GET'], //            'view' => ['GET', 'HEAD'],
            'create' => ['POST'], 'update' => ['PUT', 'PATCH'], 'delete' => ['DELETE'],];

    }
}