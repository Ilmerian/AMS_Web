<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fredouil.typevehicule".
 *
 * @property int $id
 * @property string $typev
 */
class Typevehicule extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fredouil.typevehicule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['typev'], 'required'],
            [['typev'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'typev' => 'Typev',
        ];
    }

}
