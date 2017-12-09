<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

class ArticlesTable extends Table {
    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
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
}
