<?php

namespace backend\controllers;

use common\models\AuthorBook;
use common\models\Authors;
use common\models\Books;
use common\models\BooksControl;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller {

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
     * Lists all Books models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BooksControl();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Books model.
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
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Books();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model->author_ids = trim($model->author_ids, '|');
                foreach (explode('|', $model->author_ids) as $author) {
                    if (!empty($author)) {
                        $bulkInsert[] = ['author_id' => $author, 'book_id' => $model->id];
                    }
                }
                if (!empty($bulkInsert)) {
                    Yii::$app->db->createCommand()->batchInsert(AuthorBook::tableName(), ['author_id', 'book_id'], $bulkInsert)->execute();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $authors = [];
        $hidden = '|';
        $authorsDB = Authors::find()->all();
        foreach ($authorsDB as $author) {
            $authors[$author['id']] = $author['first_name'] . ' ' . $author['middle_name'] . ' ' . $author['last_name'];
        }
        return $this->render('create', [
                    'model' => $model,
                    'authors' => $authors,
                    'hidden' => $hidden,
        ]);
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                AuthorBook::deleteAll(['book_id' => $model->id]);
                $model->author_ids = trim($model->author_ids, '|');
                foreach (explode('|', $model->author_ids) as $author) {
                    if (!empty($author)) {
                        $bulkInsert[] = ['author_id' => $author, 'book_id' => $model->id];
                    }
                }
                if (!empty($bulkInsert)) {
                    Yii::$app->db->createCommand()->batchInsert(AuthorBook::tableName(), ['author_id', 'book_id'], $bulkInsert)->execute();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $hidden = '|';
        foreach ($model->authors as $author) {
            $hidden .= $author['id'] . '|';
        }
        $authors = [];
        $authorsDB = Authors::find()->all();
        foreach ($authorsDB as $author) {
            $authors[$author['id']] = $author['first_name'] . ' ' . $author['middle_name'] . ' ' . $author['last_name'];
        }
        return $this->render('update', [
                    'model' => $model,
                    'authors' => $authors,
                    'hidden' => $hidden,
        ]);
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        AuthorBook::deleteAll(['book_id' => $id]);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFindAuthor() {
        if (Yii::$app->request->isAjax && $get = Yii::$app->request->get()) {
            $return = '';
            if (!empty($get['name'])) {
                $authors = Authors::find()->where(['like', 'first_name', $get['name']])->orWhere(['like', 'middle_name', $get['name']])->orWhere(['like', 'last_name', $get['name']])->distinct()->all();
                foreach ($authors as $author) {
                    $return .= '<div class="author" data-author-id="' . $author['id'] . '">' . $author['first_name'] . ' ' . $author['middle_name'] . ' ' . $author['last_name'] . '</div>';
                }
                if (!$return) {
                    $return = '<div>No matching found</div>';
                }
            }
            return $return;
        }
    }

}
