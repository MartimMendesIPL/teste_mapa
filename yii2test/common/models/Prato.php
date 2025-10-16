<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prato".
 *
 * @property int $id
 * @property string|null $nome
 * @property float|null $preco
 */
class Prato extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prato';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'preco'], 'default', 'value' => null],
            [['preco'], 'number'],
            [['nome'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'preco' => 'Preco',
        ];
    }

}
