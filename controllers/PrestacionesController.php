<?php

namespace app\controllers;

use app\models\GestionarLibrosForm;
use app\models\GestionarSociosForm;
use app\models\Libros;
use app\models\Prestaciones;
use app\models\PrestacionesSearch;
use app\models\Socios;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PrestacionesController implements the CRUD actions for Prestaciones model.
 */
class PrestacionesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Prestaciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrestacionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = [
            'pageSize' => 5,
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGestionar($numero = null, $codigo = null)
    {
        $modelSocio = new GestionarSociosForm([
            'numero' => $numero,
        ]);
        $modelLibro = new GestionarLibrosForm([
            'codigo' => $codigo,
        ]);
        $datos = [];
        if ($numero !== null && $modelSocio->validate()) {
            $datos['socio'] = Socios::findOne(['numero' => $modelSocio->numero]);
            $prestaciones = $datos['socio']
                ->getPrestaciones()
                ->where(['devolucion' => null])
                ->orderBy(['create_at' => SORT_DESC])
                ->limit(10);
            $dataProvider = new ActiveDataProvider([
                'query' => $prestaciones,
                'sort' => false,
                'pagination' => false,
            ]);
            $datos['dataProvider'] = $dataProvider;

            if ($codigo !== null && $modelLibro->validate()) {
                $datos['libro'] = Libros::findOne(['codigo' => $modelLibro->codigo]);
            }
        }
        $datos['modelSocio'] = $modelSocio;
        $datos['modelLibro'] = $modelLibro;
        return $this->render('gestionar', $datos);
    }

    public function actionDevolver($id)
    {
        $prestamo = Prestaciones::findOne(['id' => $id]);
        $prestamo->devolucion = date('Y-m-d H:i:s');
        $prestamo->save();

        $this->redirect(
            [
                'prestaciones/gestionar',
                'numero' => $prestamo->socio->numero,
            ]
        );
    }

    public function actionPrestar($numero)
    {
        $codigo = Yii::$app->request->post('codigo');
        $socio = Socios::findOne(['numero' => $numero]);
        $libro = Libros::findOne(['codigo' => $codigo]);
        $prestacion = new Prestaciones([
            'socio_id' => $socio->id,
            'libro_id' => $libro->id,
        ]);
        $prestacion->save();

        $this->redirect(['prestaciones/gestionar', 'numero' => $numero]);
    }

    /**
     * Displays a single Prestaciones model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Prestaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prestaciones();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Prestaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
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
        ]);
    }

    /**
     * Deletes an existing Prestaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prestaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Prestaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prestaciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
