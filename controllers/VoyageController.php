<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Trajet;
use app\models\Voyage;
use app\models\Reservation;
use app\models\Marquevehicule;
use app\models\Typevehicule;

class VoyageController extends Controller
{
    public function actionRechercher(){
        $voyages = [];
        $trajetTrouve = null;
        $message = "";
        
        $request = Yii::$app->request;
        $villeDepart = $request->post('ville_depart');
        $villeArrivee = $request->post('ville_arrivee');
        $nbVoyageurs = $request->post('nb_voyageurs');

        if ($request->isPost) {
            
            $trajetTrouve = Trajet::getTrajet($villeDepart, $villeArrivee);

            if ($trajetTrouve) {
                $voyages = Voyage::getVoyagesByTrajetId($trajetTrouve->id);
                
                if (empty($voyages)) {
                    $message = "Aucun voyage n'est proposé pour ce trajet.";
                }
            } else {
                $message = "Désolé, ce trajet n'existe pas dans notre base de données.";
            }
        }

        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $texteNotification = "Recherche terminée avec succès !";
            $typeNotification = "success"; 

            if (!empty($message)) {
                $texteNotification = $message;
                $typeNotification = "warning";
            }

            return [
                'html' => $this->renderAjax('_resultats', [
                    'voyages' => $voyages,
                    'trajet' => $trajetTrouve,
                    'nbVoyageurs' => $nbVoyageurs,
                    'message' => $message
                ]),
                'notification' => $texteNotification, 
                'type' => $typeNotification
            ];
        }

        return $this->render('recherche', [
            'voyages' => $voyages,
            'trajet' => $trajetTrouve,
            'villeDepart' => $villeDepart,
            'villeArrivee' => $villeArrivee,
            'nbVoyageurs' => $nbVoyageurs,
            'message' => $message
        ]);
    }

    public function actionReserver()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = Yii::$app->request;

        // On Vérifie qu'on est connecté
        if (Yii::$app->user->isGuest) {
            return [
                'success' => false,
                'message' => 'Vous devez être connecté pour réserver !'
            ];
        }

        if ($request->isAjax) {
            $voyageId = $request->post('voyage_id');
            $nbPlaces = $request->post('nb_places');

            // 2. Création de la réservation
            $reservation = new Reservation();
            $reservation->voyage = $voyageId; // ID du voyage
            $reservation->voyageur = Yii::$app->user->id; // ID de l'internaute connecté
            $reservation->nbplaceresa = $nbPlaces;

            if ($reservation->save()) {
                return [
                    'success' => true,
                    'message' => 'Réservation confirmée pour ' . $nbPlaces . ' personne(s) !'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de l\'enregistrement en base.'
                ];
            }
        }

        return ['success' => false, 'message' => 'Requête invalide.'];
    }

    public function actionProposer()
    {
        //on vérifie qu'on est connecté
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $voyagePropose = new Voyage();

        // Si le formulaire est validé
        if ($voyagePropose->load(Yii::$app->request->post())) {
            
            // On associe le conducteur à l'utilisateur connecté
            $voyagePropose->conducteur = Yii::$app->user->id;

            // On valide et on sauvegarde
            if ($voyagePropose->save()) {
                Yii::$app->session->setFlash('success', 'Votre voyage a été publié avec succès !');
                return $this->redirect(['internaute/profil']); // Ou vers une page "Mes voyages proposés"
            }
        }
        
        // Liste des Trajets : "Ville Départ -> Ville Arrivée"
        $trajets = Trajet::find()->orderBy(['depart'=> SORT_ASC, 'arrivee'=> SORT_ASC])->all();
        $listeTrajets = \yii\helpers\ArrayHelper::map($trajets, 'id', function($t){
            return $t->depart . ' ➝ ' . $t->arrivee . ' (' . $t->distance . ' km)';
        });
        
        // Liste des Marques
        $marques = \app\models\Marquevehicule::find()->all(); 
        $listeMarques = \yii\helpers\ArrayHelper::map($marques, 'id', 'marquev'); // ou 'marquev'

        // Liste des Types
        $types = \app\models\Typevehicule::find()->all();
        $listeTypes = \yii\helpers\ArrayHelper::map($types, 'id', 'typev'); // ou 'typev'

        return $this->render('proposer', [
            'voyagePropose' => $voyagePropose,
            'listeTrajets' => $listeTrajets,
            'listeMarques' => $listeMarques,
            'listeTypes' => $listeTypes,
        ]);
    }
}
