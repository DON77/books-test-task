<?php

namespace frontend\controllers;

use common\models\Books;
use common\models\OrderItems;
use common\models\Orders;
use common\models\OrdersControl;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new OrdersControl();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $sum = 0;
            foreach ($model->books as $book) {
                $sum += Books::find($book)->one()->price;
                $bulkInsert[] = ['order_id' => $model->id, 'book_id' => $book];
            }
            $model->sum = $sum;
            $model->update();
            if (!empty($bulkInsert)) {
                Yii::$app->db->createCommand()->batchInsert(OrderItems::tableName(), ['order_id', 'book_id'], $bulkInsert)->execute();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $books = [];
        foreach (Books::find()->all() as $book) {
            $books[$book['id']] = $book['title'] . ' (';
            foreach ($book->authors as $author) {
                $books[$book['id']] .= ' ' . mb_substr($author->first_name, 0, 1) . '.' . mb_substr($author->middle_name, 0, 1) . '.' . $author->last_name . ',';
            }
            $books[$book['id']] = rtrim($books[$book['id']], ',') . ' )' . ' - ' . $book['price'];
        }

        return $this->render('create', [
                    'model' => $model,
                    'books' => $books,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
