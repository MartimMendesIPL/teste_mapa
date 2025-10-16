<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cultural_sites".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property float $latitude
 * @property float $longitude
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $image_url
 * @property string|null $opening_hours
 * @property string $city
 * @property string $region
 * @property int $created_at
 * @property int $updated_at
 */
class CulturalSite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cultural_sites';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'latitude', 'longitude', 'city', 'region'], 'required'],
            [['description'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type', 'city', 'region'], 'string', 'max' => 100],
            [['address', 'website', 'image_url', 'opening_hours'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 50],
            [['type'], 'in', 'range' => ['museum', 'monument', 'cultural_site']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'description' => 'Descrição',
            'type' => 'Tipo',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'address' => 'Endereço',
            'phone' => 'Telefone',
            'website' => 'Website',
            'image_url' => 'URL da Imagem',
            'opening_hours' => 'Horário de Abertura',
            'city' => 'Cidade',
            'region' => 'Região',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    /**
     * Get sites by region
     * @param string $region
     * @return array
     */
    public static function getByRegion($region)
    {
        return self::find()->where(['region' => $region])->all();
    }

    /**
     * Get sites by type
     * @param string $type
     * @return array
     */
    public static function getByType($type)
    {
        return self::find()->where(['type' => $type])->all();
    }

    /**
     * Get sites by city
     * @param string $city
     * @return array
     */
    public static function getByCity($city)
    {
        return self::find()->where(['city' => $city])->all();
    }
}
