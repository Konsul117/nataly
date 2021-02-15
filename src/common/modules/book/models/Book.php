<?php

namespace common\modules\book\models;

use common\components\behaviors\TimestampUTCBehavior;
use common\models\Entity;
use common\modules\image\models\Image;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\validators\UrlValidator;

/**
 * @property int    $id
 * @property string $title           Название
 * @property string $url             URL страницы покупки книги
 * @property string $insert_stamp    Дата-время создания поста
 * @property string $update_stamp    Дата-время обновления поста
 *
 * @property Image|null $image
 */
class Book extends ActiveRecord
{
    const ATTR_ID    = 'id';
    const ATTR_TITLE = 'title';
    const ATTR_URL   = 'url';
    const ATTR_INSERT_STAMP = 'insert_stamp';
    const ATTR_UPDATE_STAMP = 'update_stamp';
    const ATTR_FILE = 'file';

    public $file;

    const SCENARIO_SEARCH = 'search';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class'              => TimestampUTCBehavior::class,
                'createdAtAttribute' => static::ATTR_INSERT_STAMP,
                'updatedAtAttribute' => static::ATTR_UPDATE_STAMP,
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [self::ATTR_TITLE, RequiredValidator::class, 'on' => [static::SCENARIO_DEFAULT]],
            [self::ATTR_TITLE, StringValidator::class, 'min' => 1, 'max' => 100, 'on' => [static::SCENARIO_DEFAULT, static::SCENARIO_SEARCH]],
            [self::ATTR_URL, RequiredValidator::class, 'on' => [static::SCENARIO_DEFAULT]],
            [self::ATTR_URL, UrlValidator::class, 'on' => [static::SCENARIO_DEFAULT, static::SCENARIO_SEARCH]],
            [self::ATTR_URL, StringValidator::class, 'max' => 255, 'on' => [static::SCENARIO_DEFAULT, static::SCENARIO_SEARCH]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            static::ATTR_ID           => '№',
            static::ATTR_TITLE        => 'Название',
            static::ATTR_URL          => 'URL для скачивания',
            static::ATTR_INSERT_STAMP => 'Создано',
            static::ATTR_UPDATE_STAMP => 'Обновлено',
            static::ATTR_FILE         => 'Изображение',
        ];
    }

    /**
     * Поиск
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = $this->find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->select($this->tableName() . '.*');
        $this->scenario = static::SCENARIO_SEARCH;

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', static::tableName() . '.' . static::ATTR_URL, $this->url]);
        $query->andFilterWhere(['like', static::tableName() . '.' . static::ATTR_TITLE, $this->title]);

        $query->andFilterWhere([
            static::tableName() . '.' . static::ATTR_ID => $this->id,
        ]);

        return $dataProvider;
    }

    public function getImage() {
        return $this->hasOne(Image::class, [Image::ATTR_RELATED_ENTITY_ITEM_ID => static::ATTR_ID])
            ->andWhere([
                Image::ATTR_RELATED_ENTITY_ID => Entity::ENTITY_BOOK_ID,
            ]);
    }
}
