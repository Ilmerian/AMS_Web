<?php
use yii\helpers\Html;
?>

<?php if (isset($message) && $message): ?>
    <div class="alert alert-warning mt-4 shadow-sm">
        <?= $message ?>
    </div>
<?php endif; ?>

<?php if (!empty($voyages)): ?>

    <?php
        $voyagesAffichables = [];
        foreach ($voyages as $voyage) {
            if ($voyage->nbplacedispo >= $nbVoyageurs) {
                $voyagesAffichables[] = $voyage;
            }
        }
    ?>

    <?php if (empty($voyagesAffichables)): ?>
        <div class="alert alert-info mt-5 shadow-sm text-center">
            <h4>Aucun véhicule assez grand</h4>
            <p>
                Des voyages existent pour ce trajet, mais aucun véhicule ne dispose de 
                <strong><?= $nbVoyageurs ?> places ou + au total</strong>.
                <br>Essayez de réduire le nombre de voyageurs ou de faire plusieurs groupes.
            </p>
        </div>
    <?php else: ?>
        <div class="mt-5 fade-in-animation"> <h3 class="mb-3">
                Trajets disponibles : 
                <span class="text-primary"><?= Html::encode($trajet->depart) ?> ➝ <?= Html::encode($trajet->arrivee) ?></span>
            </h3>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-top text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Conducteur</th>
                            <th>Heure de départ</th>
                            <th>Véhicule</th>
                            <th>Dispo</th>
                            <th>Prix</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($voyagesAffichables as $voyage): ?>
                            <?php 
                                $placesReservees = 0;
                                if ($voyage->reservations) {
                                    foreach ($voyage->reservations as $resa) $placesReservees += $resa->nbplaceresa;
                                }
                                $placesDisponibles = $voyage->nbplacedispo - $placesReservees;
                                $estComplet = ($placesDisponibles < $nbVoyageurs);
                                $prixTotal = $voyage->tarif * $voyage->infosTrajet->distance * $nbVoyageurs;
                            ?>

                            <tr class="<?= $estComplet ? 'table-danger' : '' ?>">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($voyage->infosConducteur->photo)): ?>
                                            <img src="<?= Html::encode($voyage->infosConducteur->photo) ?>" 
                                                class="rounded-circle me-2 border" 
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 40px; height: 40px;">
                                                <?= strtoupper(substr($voyage->infosConducteur->prenom, 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <span class="fw-bold"><?= $voyage->infosConducteur->prenom ?></span>
                                            <br><small class="text-muted"><?= $voyage->infosConducteur->pseudo ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="fs-5 fw-bold"><?= $voyage->heuredepart ?>h</span></td>
                                <td><?= $voyage->marque->nom ?? '-' ?> <small class="text-muted"><?= $voyage->type->typev ?? '' ?></small></td>
                                <td>
                                    <?php if ($estComplet): ?>
                                        <span class="badge bg-danger">COMPLET</span>
                                        <br>
                                        <small class="text-danger">
                                            Reste <?= $placesDisponibles ?> places (<?= $placesReservees ?>/<?= $voyage->nbplacedispo ?>)
                                        </small>
                                    <?php else: ?>
                                        <span class="badge bg-success">
                                            <?= $placesDisponibles ?> places
                                        </span>
                                        <br>
                                        <small class="text-muted" style="font-size:0.85em;">
                                            (<?= $placesReservees ?>/<?= $voyage->nbplacedispo ?> réservées)
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td><span class="text-primary fw-bold fs-5"><?= number_format($prixTotal, 2) ?> €</span></td>
                                <td>
                                    <?php if (!$estComplet): ?>
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-reserve"
                                                data-voyage-id="<?= $voyage->id ?>"
                                                data-nb-places="<?= $nbVoyageurs ?>">
                                                Réserver
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm rounded-pill px-3" disabled>Plein</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>