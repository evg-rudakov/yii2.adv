<?php

namespace frontend\controllers;

use common\models\TaskSubscriber;
use Yii;
use common\models\Task;
use frontend\models\search\TaskSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['view', 'create', 'update', 'delete', 'index', 'subscribe', 'unsubscribe'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $isSubscribed = TaskSubscriber::isSubscribed(\Yii::$app->user->id, $id);
        return $this->render('view', [
            'model' => $model,
            'isSubscribed' => $isSubscribed,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $templates = Task::find()->where(['is_template' => true])->all();
        $templates = ArrayHelper::map($templates, 'id', 'title');

        return $this->render('create', [
            'model' => $model,
            'templates' => $templates
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'templates' => []

        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
//        if (($model = Task::findOne(['id'=>$id, 'author_id'=>Yii::$app->user->identity->id])) !== null) {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionSubscribe($id)
    {
        if (TaskSubscriber::subscribe(\Yii::$app->user->id, $id)) {
            Yii::$app->session->setFlash('success', 'Subscribed');
        } else {
            Yii::$app->session->setFlash('error', 'Error');
        }
        $this->redirect(['task/view', 'id' => $id]);
    }

    public function actionUnsubscribe($id)
    {
        if (TaskSubscriber::unsubscribe(\Yii::$app->user->id, $id)) {
            Yii::$app->session->setFlash('success', 'Subscribed');
        } else {
            Yii::$app->session->setFlash('error', 'Error');
        }
        $this->redirect(['task/view', 'id' => $id]);
    }
}
