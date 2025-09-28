<?php

namespace common\decorators;

use common\models\Author;

class AuthorDecorator
{
    private $entity;

    public static function decorate($model)
    {
        return new self($model);
    }

    public function __construct($model)
    {
        $this->entity = $model;
    }

    public function __get($name)
    {
        $methodName = 'get' . ucfirst($name);
        if (method_exists(self::class, $methodName)) {
            return $this->$methodName();
        } else {
            return $this->entity->{$name};
        }
    }

    public function __call($name, $arguments)
    {
        return $this->entity->$name($arguments);
    }

    public function getFullName(): string
    {
        $name = $this->entity->last_name;
        if ($this->entity->first_name) {
            $name .= ' ' . $this->entity->first_name;
        }
        if ($this->entity->middle_name) {
            $name .= ' ' . $this->entity->middle_name;
        }
        return $name;
    }
    public function getBooksCount(): int
    {
        return $this->entity->getBooksCount();
    }

    public function getFormattedCreatedAt(): string
    {
        return date('d.m.Y H:i', $this->entity->created_at);
    }

    public function getFormattedUpdatedAt(): string
    {
        return date('d.m.Y H:i', $this->entity->updated_at);
    }
}
