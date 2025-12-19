<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fredouil.trajet".
 *
 * @property int $id
 * @property string $depart
 * @property string $arrivee
 * @property float $distance
 */
class Trajet extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fredouil.trajet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['depart', 'arrivee', 'distance'], 'required'],
            [['distance'], 'number'],
            [['depart', 'arrivee'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'depart' => 'Depart',
            'arrivee' => 'Arrivee',
            'distance' => 'Distance',
        ];
    }

// On récupère le trajet correspondant au 2 villes (départ et arrivé)
// On utilise static::findOne car il n'existe qu'1 seul trajet entre 2 villes, là où il peut y avoir plusieurs possibilité c'est
// les voyages où il peut y avoir plusieurs voyages pour 1 seul trajet 
    public static function getTrajet($depart, $arrivee) 
    {
        return static::findOne([
            'depart' => $depart,
            'arrivee' => $arrivee
        ]);
    }
}
