<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

class ArticlesTable extends Table {
    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags');
    }

    public function beforeSave($event, $entity, $options) {
        if($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);

            // trim slig to max length defined in schema
            $db = ConnectionManager::get('default');
            $collection = $db->schemaCollection();
            $tableSchema = $collection->describe('articles');
            $length = $tableSchema->column('slug')['length'];
            $entity->slug = substr($sluggedTitle, 0, $length);
        }
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->notEmpty('title')
            ->minLength('title', 10)
            ->maxLength('title', 255)

            ->notEmpty('body')
            ->minlength('body', 10);

        return $validator;
    }

    public function findTagged(Query $query, array $options) {
        $columns = [
            'Articles.id', 'Articles.user_id', 'Articles.title', 'Articles.body', 'Articles.published', 'Articles.created', 'Articles.slug'
        ];

        $query = $query
            ->select($columns)
            ->distinct($columns);

        if(empty($options['tags'])) {
            // no tags -> articles with no tags
            $query->leftJoinWith('Tags')
                ->where(['Tags.title IS' => null]);
        } else {
            $query->innerJoinWith('Tags')
                ->where(['Tags.title IN' => $options['tags']]);
        }

        return $query->group(['Articles.id']);
    }
}
