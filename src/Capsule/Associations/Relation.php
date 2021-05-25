<?php

namespace Punk\Query\Capsule\Associations;

use \Punk\Query\Utils\Str;
use \Punk\Query\Utils\Arr;
use \Punk\Query\Script\Builder as QueryBuilder;
use Punk\Query\Capsule\Builder as CapsuleBuilder;
use Punk\Query\Capsule\Capsule as Model;
use \Punk\Query\Utils as Suporte;

abstract class Relation {

    /**
     * variable stringRelationName
     * type String
     * */
    private $stringRelationName;

    /**
     * Get and Set variable stringRelationName
     * @return and @param type String
     * */
    public function getRelationName() {
        return $this->stringRelationName;
    }

    protected function setRelationName($newStringRelationName) {
        $this->stringRelationName = $newStringRelationName;
    }

    /**
     * variable builderQuery
     * type Builder
     * */
    private $builderQuery;

    /**
     * Get and Set variable builderQuery
     * @return and @param type Builder
     * */
    protected function getQuery() {
        return $this->builderQuery;
    }

    protected function setQuery($newBuilderQuery) {
        $this->builderQuery = $newBuilderQuery;
    }

    /**
     * Model|Class proprietário do relacionamento
     * type Class|Model
     * */
    private $classParent;

    /**
     * Retorna Model|Class proprietário do relacionamento
     * @return Capsule|Class|Model proprietário do relacionamento
     * */
    protected function getParent() {
        return $this->classParent;
    }

    /**
     * Seta Model|Class proprietário do relacionamento
     * @param Capsule|Class|Model $newClassParent proprietário do relacionamento
     * */
    protected function setParent($newClassParent) {
        $this->classParent = $newClassParent;
    }

    public function __construct($query, $relationName, $parent) {
        $this->setQuery($query);
        $this->setRelationName($relationName);
        $this->setParent($parent);
    }

    abstract protected function newModel($attributes);

    abstract protected function setRelation($model);

    abstract function getModel();

    abstract function getDefault();

    abstract function getRelationValue();

    abstract function setRelationValue($models);

    abstract function save($models);
}
