<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fredouil.marquevehicule".
 *
 * @property int $id
 * @property string $marquev
 */
class Marquevehicule extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fredouil.marquevehicule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['marquev'], 'required'],
            [['marquev'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'marquev' => 'Marquev',
        ];
    }

}
