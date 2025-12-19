<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm; 

$this->title = 'Inscription - CERICar';
?>

<div class="site-inscription container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="card shadow p-4">
                <h2 class="text-center mb-4">Créer un compte</h2>
                
                <?php $form = ActiveForm::begin(['id' => 'form-inscription']); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'nom')->textInput(['placeholder' => 'Votre nom']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'prenom')->textInput(['placeholder' => 'Votre prénom']) ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'pseudo')->textInput(['placeholder' => 'Choisissez un pseudo unique']) ?>
                    
                    <?= $form->field($model, 'mail')->input('email', ['placeholder' => 'exemple@email.com']) ?>

                    <?= $form->field($model, 'pass')->passwordInput(['placeholder' => 'Mot de passe secret']) ?>

                    <hr class="my-4">
                    <h5 class="text-muted">Informations Covoitureur (Optionnel)</h5>

                    <?= $form->field($model, 'permis')->textInput(['placeholder' => 'Ex: 12345678910 (Si vous êtes conducteur)']) ?>

                    <?= $form->field($model, 'photo')->textInput(['placeholder' => 'https://... (Lien vers votre photo)']) ?>
                    <small class="text-muted d-block mb-3">Copiez-coller un lien d'une image</small>

                    <div class="d-grid gap-2">
                        <?= Html::submitButton('S\'inscrire', ['class' => 'btn btn-success btn-lg fw-bold']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
                
                <div class="text-center mt-3">
                    <small>Déjà un compte ? <?= Html::a('Connectez-vous ici', ['site/login']) ?></small>
                </div>
            </div>

        </div>
    </div>
</div>