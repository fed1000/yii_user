<?php

namespace app\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $name
 * @property string $url
 * @property string|null $text
 */
class Menu extends \yii\db\ActiveRecord
{
     public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tree', 'lft', 'rgt', 'depth', 'name', 'url'], 'required'],
            [['tree', 'lft', 'rgt', 'depth'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 50],
            [['text'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => 'Name',
            'url' => 'Url',
            'text' => 'Text',
        ];
    }
}
