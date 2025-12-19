<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "fredouil.internaute".
 *
 * @property int $id
 * @property string $pseudo
 * @property string $pass
 * @property string $nom
 * @property string $prenom
 * @property string $mail
 * @property string $photo
 * @property float|null $permis
 */
class Internaute extends \yii\db\ActiveRecord implements IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fredouil.internaute';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permis'], 'default', 'value' => null],
            [['photo'], 'default', 'value' => 'https://www.europe-escapade.com/img/articles/13baf0dc6fd2e29bc5a46162403ee6812bbacf01.jpeg'],
            [['pseudo', 'pass', 'nom', 'prenom', 'mail'], 'required', 'message' => 'Ce champ est obligatoire.'],
            [['permis'], 'number'],
            [['pseudo', 'pass', 'nom', 'prenom', 'mail'], 'string', 'max' => 45],
            [['photo'], 'string', 'max' => 200],
            [['mail'], 'email', 'message' => 'Format d\'email invalide.'],
            [['pseudo'], 'unique', 'message' => 'Ce pseudo est déjà pris.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pseudo' => 'Pseudo',
            'pass' => 'Pass',
            'nom' => 'Nom',
            'prenom' => 'Prenom',
            'mail' => 'Mail',
            'photo' => 'Photo',
            'permis' => 'Permis',
        ];
    }


    public static function findByUsername($username) // On récup un internaute par son pseudo
    {
        return static::findOne(['pseudo' => $username]);
    }

    public function estConducteur() // On vérifie si oui ou non cette internaute est un conducteur (donc a le permis)
    {
        return !empty($this->permis);
    }

    // On va récupérer tout les voyages que cette internaute propose, 
    // donc dans la bdd tout les 'voyages' où le 'conducteur' = 'id' de cette internaute
    // renvoie un tableau d'objet voyage
    public function getVoyages() 
    {
        return $this->hasMany(Voyage::class, ['conducteur' => 'id']);
    }

    // On récup toute les réservations que cette internaute a faite, 
    // donc dans la bdd toute les réservations où la colonne 'voyageur' = 'id' de cette internaute, 
    // renvoie un tableau d'objet reservation 
    public function getReservations() 
    {
        return $this->hasMany(Reservation::class, ['voyageur' => 'id']);
    }

    public function getId() //Renvoie l'ID de l'utilisateur courant
    {
        return $this->id;
    }

    public function beforeSave($insert) // Méthode magique appelé automatiquement par yii avant model->save()
    {
        if (parent::beforeSave($insert)) {
            
            // Si c'est un nouvel utilisateur OU si le mot de passe a été modifié
            if ($this->isNewRecord || $this->isAttributeChanged('pass')) {
                $this->pass = sha1($this->pass);
            }
            
            return true;
        }
        return false;
    }

    public function validatePassword($password)
    {
        return $this->pass === sha1($password); //On utilise sha1 car max taille mdp dans bdd = 45
    }



    //Méthode à implémenter obligatoire car on utilise l'interface identityINterface...

    public static function findIdentityByAccessToken($token, $type = null) //Trouve une identité via un token
    {
        return null; // On ne gère pas les tokens API pour l'instant
    }

     //Renvoie la clé d'authentification (cookie "Se souvenir de moi")
    public function getAuthKey()
    {
        return null; // return null car pas de colonne auth_key
    }

    public function validateAuthKey($authKey) //Valide la clé d'authentification
    {
        return $this->getAuthKey() === $authKey;
    }

    // Trouve une identité via son id
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


}
