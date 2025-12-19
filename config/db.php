<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=127.0.0.1;port=5433;dbname=etd',
    'username' => 'uapv2307081',
    'password' => 'Tnw5jx',
    'charset' => 'utf8',

    // Toujours le schéma fredouil
    'on afterOpen' => function ($event) {
        $event->sender->createCommand("SET search_path TO fredouil")->execute();
    },

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
