<?php

namespace frontend\controllers;


use common\models\Make;
use common\models\Model;
use common\models\Post;
use yii\data\ActiveDataProvider;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\status;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Json;



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
    public function actionView($id)
    {
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
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
        if (($model = Post::findOne(['id' => $id])) !== null) {
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
