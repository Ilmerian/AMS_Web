<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fredouil.voyage".
 *
 * @property int $id
 * @property int $conducteur
 * @property int $trajet
 * @property int $idtypev
 * @property int $idmarquev
 * @property float $tarif
 * @property int $nbplacedispo
 * @property int $nbbagage
 * @property int $heuredepart
 * @property string|null $contraintes
 */
class Voyage extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fredouil.voyage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contraintes'], 'default', 'value' => null],
            [['nbplacedispo'], 'default', 'value' => 1],
            [['heuredepart'], 'default', 'value' => 0],

            [['conducteur', 'trajet', 'idtypev', 'idmarquev', 'tarif', 'heuredepart', 'nbplacedispo', 'nbbagage'], 'required', 'message' => 'Ce champ est obligatoire.'],

            [['conducteur', 'trajet', 'idtypev', 'idmarquev', 'nbplacedispo', 'nbbagage', 'heuredepart'], 'default', 'value' => null],
            [['conducteur', 'trajet', 'idtypev', 'idmarquev', 'nbplacedispo', 'nbbagage', 'heuredepart'], 'integer'],
            [['tarif'], 'number'],
            [['contraintes'], 'string', 'max' => 500],

            [['conducteur'], 'exist', 'skipOnError' => true, 'targetClass' => Internaute::class, 'targetAttribute' => ['conducteur' => 'id']],
            [['idmarquev'], 'exist', 'skipOnError' => true, 'targetClass' => Marquevehicule::class, 'targetAttribute' => ['idmarquev' => 'id']],
            [['trajet'], 'exist', 'skipOnError' => true, 'targetClass' => Trajet::class, 'targetAttribute' => ['trajet' => 'id']],
            [['idtypev'], 'exist', 'skipOnError' => true, 'targetClass' => Typevehicule::class, 'targetAttribute' => ['idtypev' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conducteur' => 'Conducteur',
            'trajet' => 'Trajet',
            'idtypev' => 'Type du véhicule',
            'idmarquev' => 'Marque du véhicule',
            'tarif' => 'Tarif',
            'nbplacedispo' => 'Nbplacedispo',
            'nbbagage' => 'Nbbagage',
            'heuredepart' => 'Heure de départ',
            'contraintes' => 'Contraintes',
        ];
    }

    public function getInfosTrajet(){ // On récupère un trajet car un voyage = un trajet  
        // hasOne(ClasseCible, [CléEtrangèreCible => CléLocale])
        return $this->hasOne(Trajet::class, ['id' => 'trajet']);
    }

    public function getInfosConducteur(){ // On récupère le conducteur du voyage car un voyage est proposé par un conducteur (qui est un internaute)
        return $this->hasOne(Internaute::class, ['id' => 'conducteur']);
    }

    public function getMarque(){ // On récupère la marque du véhicule du voyage
        return $this->hasOne(Marquevehicule::class, ['id' => 'idmarquev']);
    }

    public function getType(){ // On récupère le type du véhicule
        return $this->hasOne(Typevehicule::class, ['id' => 'idtypev']);
    }

    public static function getVoyagesByTrajetId($idTrajet){ // On récup l'ensemble des voyages correspondant à un id de trajet
        return static::findAll(['trajet' => $idTrajet]);
    } 

     // Un voyage possède PLUSIEURS réservations.
     // On cherche dans la table 'reservation' toutes les lignes où la colonne 'voyage' = mon ID. 
    public function getReservations()
    {
        return $this->hasMany(Reservation::class, ['voyage' => 'id']);
    }
}
