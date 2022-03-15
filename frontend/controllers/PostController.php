<?php

namespace frontend\controllers;


use common\models\Make;
use common\models\Model;
use common\models\Post;
use common\models\User;
use common\models\View;
use Yii;
use yii\data\ActiveDataProvider;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\status;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\mongodb\Query;







/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {


        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),

            'pagination' => [
                'pageSize' => 2
            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'id' => SORT_DESC,
//                ]
//            ],

        ]);

//        var_dump($dataProvider);
//        die;

        return $this->render('index', [
            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionSearch()
    {
//        var_dump($this->request->queryParams);
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
//        echo "<pre>";
//        print_r($dataProvider);
//        echo "<br>";
//        print_r($searchModel);
//        die();

//        print_r($searchModel->erros);
//        die;

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function addView($id)
    {
        // phpinfo();die;
        $view=View::find()->where(["post_id"=>(int)$id])->one();
//var_dump($view);die();
//        print_r(View::find()->all());die;
        if($view)
        {
            $view->view_num=$view->view_num+1;
            $view->save();
//            var_dump($view);die;


        }
        else
        {
            $view=new View();
            $view->post_id=$id;
            $view->view_num=1;
            $view->save();
//            var_dump($view);die;
        }
//        $model=$this->findModel($id);
//        var_dump($model->view->view_num);
//        die();

    }

    public function viewNumber($id)
    {
        return View::find()->where(["post_id"=>$id])->one()->view_num;
    }




    public function actionView($id)
    {
//        echo phpinfo()    ;
//        die();
//        // phpinfo();die;
//         $view=View::find()->where(["post_id"=>$id])->count();
//         echo $view;
//        print_r(View::find()->all());die;

//        $viewNum=Post::find()->with("view")->where(["post_id"=>$id])->all() ;

//        var_dump($viewNum);
//        die();

        $this->addView($id);


       // $view_num=$this->viewNumber($id);

//        $cache = Yii::$app->cache;
//
////        echo "</pre>";
////        var_dump($id);
////        die();
//        //
//        $key=$id;
//        $data=$cache->get($key);
////        $data=unserialize($data);
//        var_dump($data);
//        if($data == false)
//        {
//            echo 'from db';
//            $data = Post::find()->where(["id"=>$id])->one();
////            var_dump($data);
////            die();
//
////            var_dump($data->title);die();
////            $se_data=$data;
////            var_dump(serialize(NULL));die();
//          echo  $cache->set($key,$data,60*5);die;
//
////            $cache->set($key,"hello");
////            var_dump($cache->get($key));
////
////            die();
//        } else {
//            echo 'from cache';
//        }
////        else {
////            $data = json_decode($data);
////           // var_dump($data);die();
////        }
////echo var_dump($model->view);die;
//        die;

        $data=$this->findModel($id);
//        $view_num=$this->viewNumber($id);
//        var_dump($data);die();

        return $this->render('view', [
            'model' => $data,
//            'view_num'=>$view_num
        ]);
    }

    public function dynamicFile($id)
    {
        //is_dir to check if a directory(folder0 is created
        //is_file to check if the file is created
        if(is_file(dirname(__DIR__).'/mail/'.$id))
        {
           return dirname(__DIR__).'/mail/'.$id.'.pdf'  ;
        }
        else
        {
            touch(dirname(__DIR__).'/mail/'.$id.'.pdf' );
           return dirname(__DIR__) . '/mail/' . $id.'.pdf';
        }

        // setup kartik\mpdf\Pdf component
    }
    public function actionReport($id)
    {
// var_dump($id);
//        die();
        // get your HTML raw content without any layouts or scripts
        $model=$this->findModel($id);

//        var_dump($model);
//        die();

        $content = $this->renderPartial('@frontend/views/post/pdf',['model'=>$model]);


//        var_dump($content);
//        die();

//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        $formatter = \Yii::$app->formatter;

          $filename=$this->dynamicFile($id);
//        $filename='@frontend/mail/test.pdf'   ;
        $pdf = new Pdf([


            'filename'=>$filename,
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>['Krajee Report Header'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        $pdf->output($pdf->content,$filename,\Mpdf\Output\Destination::FILE);
        // return the pdf output as per the destination setting
//        return $pdf->render();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->setScenario('create');
        $models=Model::find()->all();
        $makes=Make::find()->all();


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'models'=>$models,
            'makes'=>$makes
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function sendEmail($userEmail,$postId,$postTitle)
    {
        Yii::$app->mailer->compose()
            ->setFrom('bla@bla.com')
            ->setTo($userEmail)
            ->setSubject('Status has been changed to INACTIVE')
            ->setTextBody(' Post id: '.$postId.'  and Title is : '.$postTitle)
            ->setHtmlBody('<b>HTML content</b>')
            ->send();
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $status_before_update=$model->status;
        $model->setScenario('update');

        $userEmail=User::findOne($model->created_by)->email;
        $postId=$model->id;
        $postTitle=$model->title;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if($model->status==0 && $model->status!=$status_before_update)
            {
                $this->sendEmail($userEmail,$postId,$postTitle);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
//        var_dump($id);die();
        if (($model = Post::find()->where(['id'=>$id])->one()) !== null) {
//            var_dump($model = Post::find()->where(['id'=>$id])->one());
//            die();
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionModels($makeId)
    {
//            var_dump('hello');
//            die();
//        $model=new Model();

        $models=Model::find()->where(['make_id' => $makeId])->all();

//        print_r($models);
//        print_r(JSON::encode($models));
//        print_r(json_encode($models));
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        so we either use the above with return $model
//        return  $models;
//        or we use encoding and decoding
//        var_dump(JSON::encode($models));
        return JSON::encode($models);

//        return JSON::decode($models);





    }
}
