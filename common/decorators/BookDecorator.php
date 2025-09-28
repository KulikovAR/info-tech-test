<?php

namespace common\decorators;

use common\models\Book;

class BookDecorator
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

    public function getFormattedYear(): string
    {
        return (string) $this->entity->year;
    }

    public function getShortDescription(int $length = 150): string
    {
        if (!$this->entity->description) {
            return '';
        }
        
        if (mb_strlen($this->entity->description) <= $length) {
            return $this->entity->description;
        }
        
        return mb_substr($this->entity->description, 0, $length) . '...';
    }

    public function getFormattedCreatedAt(): string
    {
        return date('d.m.Y H:i', $this->entity->created_at);
    }

    public function getFormattedUpdatedAt(): string
    {
        return date('d.m.Y H:i', $this->entity->updated_at);
    }

    public function getAuthorsNames(): string
    {
        $names = [];
        foreach ($this->entity->authors as $author) {
            $decorator = AuthorDecorator::decorate($author);
            $names[] = $decorator->getFullName();
        }
        return implode(', ', $names);
    }

    public function getCoverImageUrl(): string
    {
        if (!$this->entity->cover_image) {
            return '/images/no-cover.jpg';
        }
        
        return $this->entity->cover_image;
    }
}
