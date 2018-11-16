<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reader_control".
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string $comment
 */
class ReaderControl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reader_control';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'key', 'value', 'comment'], 'string', 'max' => 255],
            [
                ['key'],
                'match',
                'pattern' => '#^[a-zA-Z0-9\-\_\.]+$#',
                'message' => Yii::t('app', 'This value must consist only of alpha-numerical characters plus hyphen ( - ), underscore ( _ ) or period ( . ).')
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'comment' => 'Comment',
        ];
    }
}
