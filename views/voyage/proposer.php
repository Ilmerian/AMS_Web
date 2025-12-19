<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Proposer un voyage - CERICar';
?>

<div class="site-proposer-voyage container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow p-4">
                <h2 class="text-center mb-4">Proposer un trajet</h2>
                
                <?php $form = ActiveForm::begin(); ?>

                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Le Trajet</h5>
                        <?= $form->field($voyagePropose, 'trajet')->dropDownList($listeTrajets, ['prompt' => '-- Choisir un itinéraire existant --']) ?>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Le Véhicule</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($voyagePropose, 'idmarquev')->dropDownList($listeMarques, ['prompt' => '-- Marque --']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($voyagePropose, 'idtypev')->dropDownList($listeTypes, ['prompt' => '-- Type --']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Détails</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($voyagePropose, 'heuredepart')->input('number', ['min' => 0, 'max' => 23, 'placeholder' => 'Ex: 14']) ?>
                                <small class="text-muted">Heure pile (0-23h)</small>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($voyagePropose, 'nbplacedispo')->input('number', ['min' => 1, 'max' => 9])->label('Places Disponibles') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($voyagePropose, 'nbbagage')->input('number', ['min' => 0, 'max' => 5])->label('Bagages/pers') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($voyagePropose, 'tarif')->input('number', ['step' => '0.01', 'min' => 0])->label('Prix / pers / km (€)') ?>
                            </div>
                        </div>
                        
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Infos complémentaires</h5>
                        <?= $form->field($voyagePropose, 'contraintes')->textarea(['rows' => 3, 'placeholder' => 'Ex: Non fumeur, animaux acceptés, musique...'])->label('Contraintes / Commentaires') ?>
                    </div>

                    <div class="d-grid">
                        <?= Html::submitButton('Publier le voyage', ['class' => 'btn btn-success btn-lg fw-bold']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>