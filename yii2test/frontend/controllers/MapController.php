<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\CulturalSite;

/**
 * Map controller
 */
class MapController extends Controller
{
    /**
     * Displays interactive map of cultural sites
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // Get all cultural sites for the map
        $culturalSites = CulturalSite::find()->all();

        // Convert to JSON for JavaScript
        $sitesJson = json_encode(array_map(function($site) {
            return [
                'id' => $site->id,
                'name' => $site->name,
                'description' => $site->description,
                'type' => $site->type,
                'latitude' => (float)$site->latitude,
                'longitude' => (float)$site->longitude,
                'address' => $site->address,
                'phone' => $site->phone,
                'website' => $site->website,
                'image_url' => $site->image_url,
                'opening_hours' => $site->opening_hours,
                'city' => $site->city,
                'region' => $site->region,
            ];
        }, $culturalSites));

        return $this->render('index', [
            'sitesJson' => $sitesJson,
        ]);
    }

    /**
     * Get sites by region (AJAX endpoint)
     *
     * @param string $region
     * @return array
     */
    public function actionGetByRegion($region)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return CulturalSite::getByRegion($region);
    }

    /**
     * Get sites by type (AJAX endpoint)
     *
     * @param string $type
     * @return array
     */
    public function actionGetByType($type)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return CulturalSite::getByType($type);
    }

    /**
     * Get sites by city (AJAX endpoint)
     *
     * @param string $city
     * @return array
     */
    public function actionGetByCity($city)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return CulturalSite::getByCity($city);
    }
}
