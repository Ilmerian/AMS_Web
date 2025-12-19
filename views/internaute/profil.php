<?php
use yii\helpers\Html;

$this->title = 'Profil - CERICar';
?>

<?php if ($internaute == null): ?>
    <div class="alert alert-danger">
        Aucun utilisateur trouvé avec ce pseudo.
    </div>
<?php else: ?>
    <div class="card shadow-sm mb-4" style="border: none; border-radius: 10px; overflow: hidden;">
        <div class="card-header bg-primary text-white p-3">
            <h4 class="m-0" style="font-weight: 600;">
                Profil de <?= Html::encode($internaute->prenom) ?> <?= Html::encode($internaute->nom) ?>
            </h4>
        </div>

        <div class="card-body p-4">
            <div class="row align-items-center">
                
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <?php 
                        $photoUrl = !empty($internaute->photo) ? $internaute->photo : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                    ?>
                    <img src="<?= $photoUrl ?>" alt="Avatar" class="img-fluid rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #f8f9fa;">
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <small class="text-muted text-uppercase fw-bold">Pseudo</small>
                            <div class="fs-5 text-dark">@<?= Html::encode($internaute->pseudo) ?></div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <small class="text-muted text-uppercase fw-bold">Email</small>
                            <div class="fs-5 text-dark"><?= Html::encode($internaute->mail) ?></div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <small class="text-muted text-uppercase fw-bold">Identité</small>
                            <div class="fs-5 text-dark"><?= Html::encode($internaute->prenom . ' ' . $internaute->nom) ?></div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <small class="text-muted text-uppercase fw-bold">Permis de conduire</small>
                            <div>
                                <?php if (!empty($internaute->permis)): ?>
                                    <span class="badge bg-success p-2">(N°<?=Html::encode($internaute->permis) ?>)</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary p-2">Non renseigné</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mb-3 mt-5" style="border-left: 5px solid #ffc107; padding-left: 15px; font-weight: bold; color: #495057;">Voyages proposés</h3>
        <?php if (count($internaute->voyages) > 0): ?>
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover align-middle mb-0 bg-white text-center table-stripped">
                    <thead class="bg-warning text-white">
                        <tr>
                            <th>Trajet</th>
                            <th>Heure de départ</th>
                            <th>Véhicule</th>
                            <th>Tarif / km</th>
                            <th>Prix par passager</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($internaute->voyages as $voyage): ?>
                            <tr>
                                <td>
                                    <strong class="fs-5">
                                        <?= Html::encode($voyage->infosTrajet->depart) ?> 
                                        ➝ 
                                        <?= Html::encode($voyage->infosTrajet->arrivee) ?>
                                    </strong>
                                    <br>
                                    <small class="text-muted"><?= $voyage->infosTrajet->distance ?> km</small>
                                </td>

                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <?= Html::encode($voyage->heuredepart) ?>h
                                    </span>
                                </td>

                                <td>
                                    <?= Html::encode($voyage->marque->marquev ?? 'Marque inconnue') ?>
                                    <small class="text-muted">(<?= Html::encode($voyage->type->typev ?? 'Type inconnu') ?>)</small>
                                </td>

                                <td>
                                    <?= Html::encode($voyage->tarif) ?> € / km
                                </td>

                                <td class="fw-bold text-success">
                                    <?php 
                                        // Calcul du prix total pour un passager
                                        $prixTotal = $voyage->tarif * $voyage->infosTrajet->distance;
                                        echo number_format($prixTotal, 2) . ' €';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Cet utilisateur ne propose aucun voyage.</p>
        <?php endif; ?>
        <br>
    <h3 class="mb-3" style="border-left: 5px solid #0d6efd; padding-left: 15px; font-weight: bold; color: #495057;"> Réservations effectuées</h3>
    <?php if (count($internaute->reservations) > 0): ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0 bg-white text-center">
                <thead class="bg-primary">
                    <tr>
                        <th>Trajet</th>
                        <th>Heure de départ</th>
                        <th>Conducteur (pseudo)</th>
                        <th>Places</th>
                        <th>Véhicule</th>
                        <th>Prix Payé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($internaute->reservations as $resa): ?>
                        <tr>
                            <td>
                                <strong class="fs-5">
                                    <?= Html::encode($resa->infosVoyage->infosTrajet->depart) ?> 
                                    ➝ 
                                    <?= Html::encode($resa->infosVoyage->infosTrajet->arrivee) ?>
                                </strong>
                                <br>
                                <small class="text-muted"><?= $resa->infosVoyage->infosTrajet->distance ?> km</small>
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    <?= $resa->infosVoyage->heuredepart ?>h
                                </span>
                            </td>

                            <td>
                                <?= Html::encode($resa->infosVoyage->infosConducteur->prenom) ?> 
                                <?= Html::encode($resa->infosVoyage->infosConducteur->nom) ?>
                                (<?= Html::encode($resa->infosVoyage->infosConducteur->pseudo) ?>)
                            </td>

                            <td class="text-center">
                                <span class="badge bg-secondary rounded-pill">
                                <?= $resa->nbplaceresa ?> pers.
                                </span>
                            </td>

                            <td>
                                <?= Html::encode($resa->infosVoyage->marque->marquev ?? '-') ?>
                                <small class="text-muted">(<?= Html::encode($resa->infosVoyage->type->typev ?? '-') ?>)</small>
                            </td>

                            <td class="fw-bold text-success">
                                <?php 
                                    $prix = $resa->infosVoyage->tarif * $resa->infosVoyage->infosTrajet->distance * $resa->nbplaceresa;
                                    echo number_format($prix, 2) . ' €';
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Cet utilisateur n'a aucune réservation.</p>
    <?php endif; ?>

<?php endif; ?>