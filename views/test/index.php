<h1>Test Base de donnees</h1>

<?php if ($internaute == null): ?>
    <div class="alert alert-danger">
        Aucun utilisateur trouvé avec ce pseudo.
    </div>
<?php else: ?>

    <div class="card" style="margin-bottom: 20px; padding: 10px; border: 1px solid #ccc;">
        <h2> Profil de <?= $internaute->prenom ?> <?= $internaute->nom ?></h2>
        <ul>
            <li><strong>Pseudo :</strong> <?= $internaute->pseudo ?></li>
            <li><strong>Email :</strong> <?= $internaute->mail ?></li>
            <li><strong>Nom : </strong> <?= $internaute->nom ?></li>
            <li><strong>Permis :</strong> <?= $internaute->permis ? $internaute->permis : 'Non renseigné' ?></li>
        </ul>
    </div>

    <h3> Voyages proposés</h3>
    <?php if (count($internaute->voyages) > 0): ?>
        <ul>
            <?php foreach ($internaute->voyages as $voyage): ?>
                <li>
                    <strong>Trajet :</strong> 
                    <?= $voyage->infosTrajet->depart ?> -> <?= $voyage->infosTrajet->arrivee ?>
                    (<?= $voyage->infosTrajet->distance ?> km)
                    <br>
                    Heure : <?= $voyage->heuredepart ?>h | 
                    Tarif : <?= $voyage->tarif ?> €/km soit <?= $voyage->tarif * $voyage->infosTrajet->distance ?> €
                    <br>
                    <em>Voiture : <?= $voyage->marque->marquev ?? 'Marque inconnue' ?> (<?= $voyage->type->typev ?? 'Type inconnu' ?>)</em>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Cet utilisateur ne propose aucun voyage.</p>
    <?php endif; ?>

    <h3> Réservations effectuées</h3>
    <?php if (count($internaute->reservations) > 0): ?>
        <ul>
            <?php foreach ($internaute->reservations as $resa): ?>
                <li>
                    Réservation n°<?= $resa->id ?> pour le trajet :
                    <strong>
                        <?= $resa->infosVoyage->infosTrajet->depart ?> -> <?= $resa->infosVoyage->infosTrajet->arrivee ?>
                    </strong>
                    <br>
                    Places réservées : <?= $resa->nbplaceresa ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Cet utilisateur n'a aucune réservation.</p>
    <?php endif; ?>

<?php endif; ?>