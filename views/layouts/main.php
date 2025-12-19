<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-custom-blue fixed-top shadow-sm']
    ]);

    $menuItemsLeft = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Rechercher Voyages', 'url' => ['/voyage/rechercher']],
    ];

    if (!Yii::$app->user->isGuest) {
        $menuItemsLeft[] = ['label' => 'Proposer un trajet', 'url' => ['/voyage/proposer']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'], 
        'items' => $menuItemsLeft,
    ]);

    $menuItemsRight = [];

    if (Yii::$app->user->isGuest) {
        $menuItemsRight[] = ['label' => 'S\'inscrire', 'url' => ['/site/inscription']];
        $menuItemsRight[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItemsRight[] = ['label' => 'Profil', 'url' => ['/internaute/profil']];
        $menuItemsRight[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->pseudo . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'], 
        'items' => $menuItemsRight,
    ]);

    NavBar::end();
    ?>
</header>
<main id="main" class="flex-shrink-0" role="main">

    <div id="notification" class="alert text-center fw-bold shadow"></div>

    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-white shadow-lg text-secondary">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                &copy; CERICar <?= date('Y') ?> 
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
