<?php
use yii\helpers\Html;

$this->title = 'Rechercher un voyage - CERICar';
?>

<div class="site-voyage-index"> 
    <div class="banner">
        <h1 class="banner_title">Recherchez un trajet</h1>
    </div>

    <div class="card card_recherche p-4">
        <?= Html::beginForm(['voyage/rechercher'], 'post', ['class' => 'row g-3 align-items-end', 'id' => 'form-recherche']) ?>
        
        <div class="col-md-4">
            <label class="form-label text-muted fw-bold small"> DÉPART</label>
            <?= Html::textInput('ville_depart', $villeDepart, ['class' => 'form-control form-control-lg fw-bold', 'placeholder' => 'Ex: Marseille', 'required' => true]) ?>
        </div>

        <div class="col-md-4">
            <label class="form-label text-muted fw-bold small"> ARRIVÉE</label>
            <?= Html::textInput('ville_arrivee', $villeArrivee, ['class' => 'form-control form-control-lg fw-bold', 'placeholder' => 'Ex: Nice', 'required' => true]) ?>
        </div>

        <div class="col-md-2">
            <label class="form-label text-muted fw-bold small">NB. PERS.</label>
            <?= Html::input('number', 'nb_voyageurs', $nbVoyageurs ?? 1, ['class' => 'form-control form-control-lg fw-bold', 'min' => 1, 'required' => true]) ?>
        </div>

        <div class="col-md-2">
            <?= Html::submitButton('Rechercher', ['class' => 'btn btn-primary btn-lg w-100 fw-bold', 'style' => 'border-radius: 10px;']) ?>
        </div>

        <?= Html::endForm() ?>
    </div>
    
    <div id="tableau_resultats"></div>
</div>