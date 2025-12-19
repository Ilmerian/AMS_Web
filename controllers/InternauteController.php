<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class InternauteController extends Controller
{
    // On veut etre sur que seuls les personnes connecte peuvent accéder à cette page
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['profil'],
                        'roles' => ['@'], 
                    ],
                ],
            ],
        ];
    }

    public function actionProfil()
    {
        $internaute = Yii::$app->user->identity;
        return $this->render('profil', [
            'internaute' => $internaute,
        ]);
    }
}