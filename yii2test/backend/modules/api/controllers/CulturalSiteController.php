<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * CulturalSite controller for the `api` module
 */
class CulturalSiteController extends ActiveController
{
    public $modelClass = 'common\models\CulturalSite';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * Get all cultural sites with optional filters
     * GET /api/cultural-sites
     */
    public function actions()
    {
        $actions = parent::actions();
        
        // Customize the data provider for the "index" action
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        
        return $actions;
    }

    /**
     * Prepare data provider with filters
     */
    public function prepareDataProvider()
    {
        $model = new $this->modelClass;
        $query = $model::find();

        // Apply filters from query parameters
        if ($type = \Yii::$app->request->get('type')) {
            $query->andWhere(['type' => $type]);
        }

        if ($city = \Yii::$app->request->get('city')) {
            $query->andWhere(['city' => $city]);
        }

        if ($region = \Yii::$app->request->get('region')) {
            $query->andWhere(['region' => $region]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
    }

    /**
     * Get cultural sites by region
     * GET /api/cultural-sites/by-region/{region}
     */
    public function actionByRegion($region)
    {
        $model = new $this->modelClass;
        $sites = $model::find()->where(['region' => $region])->all();
        return $sites;
    }

    /**
     * Get cultural sites by city
     * GET /api/cultural-sites/by-city/{city}
     */
    public function actionByCity($city)
    {
        $model = new $this->modelClass;
        $sites = $model::find()->where(['city' => $city])->all();
        return $sites;
    }

    /**
     * Get cultural sites by type
     * GET /api/cultural-sites/by-type/{type}
     */
    public function actionByType($type)
    {
        $model = new $this->modelClass;
        $sites = $model::find()->where(['type' => $type])->all();
        return $sites;
    }

    /**
     * Get cultural sites within a geographic bounding box
     * GET /api/cultural-sites/in-bounds
     */
    public function actionInBounds()
    {
        $minLat = \Yii::$app->request->get('minLat');
        $maxLat = \Yii::$app->request->get('maxLat');
        $minLng = \Yii::$app->request->get('minLng');
        $maxLng = \Yii::$app->request->get('maxLng');

        $model = new $this->modelClass;
        $sites = $model::find()
            ->andWhere(['>=', 'latitude', $minLat])
            ->andWhere(['<=', 'latitude', $maxLat])
            ->andWhere(['>=', 'longitude', $minLng])
            ->andWhere(['<=', 'longitude', $maxLng])
            ->all();

        return $sites;
    }

    /**
     * Get count of cultural sites
     * GET /api/cultural-sites/count
     */
    public function actionCount()
    {
        $model = new $this->modelClass;
        $count = $model::find()->count();
        
        return ['count' => $count];
    }
}
