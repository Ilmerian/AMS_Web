<?php

namespace app\models;

use Yii;
use app\models\Internaute;

/**
 * This is the model class for table "fredouil.reservation".
 *
 * @property int $id
 * @property int $voyage
 * @property int $voyageur
 * @property int $nbplaceresa
 */
class Reservation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fredouil.reservation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nbplaceresa'], 'default', 'value' => 1],
            [['voyage', 'voyageur'], 'required'],
            [['voyage', 'voyageur', 'nbplaceresa'], 'default', 'value' => null],
            [['voyage', 'voyageur', 'nbplaceresa'], 'integer'],
            [['voyageur'], 'exist', 'skipOnError' => true, 'targetClass' => Internaute::class, 'targetAttribute' => ['voyageur' => 'id']],
            [['voyage'], 'exist', 'skipOnError' => true, 'targetClass' => Voyage::class, 'targetAttribute' => ['voyage' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'voyage' => 'Voyage',
            'voyageur' => 'Voyageur',
            'nbplaceresa' => 'Nbplaceresa',
        ];
    }


    public function getInfosVoyage() // On récupère le voyage lié à cette réservation
    {
        return $this->hasOne(Voyage::class, ['id' => 'voyage']);
    }

    public function getVoyageur() // On récup le voyageur, c.a.d l'internaute qui a réservé ce voyage 
    {
        return $this->hasOne(Internaute::class, ['id' => 'voyageur']);
    }

    public static function getReservationsByVoyageId($idVoyage) // On récup l'ensemble des réservations correspondant à un id de voyage
    {
        return static::findAll(['voyage' => $idVoyage]);
    }
}
