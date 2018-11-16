<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag_control".
 *
 * @property int $id
 * @property string $tag_
 * @property string $time
 * @property string $note
 * @property string $comment
 */
class TagControl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_control';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_'], 'required'],
            [['time'], 'safe'],
            [['tag_', 'note', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_' => 'Tag',
            'time' => 'Time',
            'note' => 'Note',
            'comment' => 'Comment',
        ];
    }
}
