<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use App\Database\QueryBuilder;
use App\Entities\Entity;

abstract class Repository implements RepositoryInterface
{
    protected static $table;
    protected static $entity;

    /** @var QueryBuilder $queryBuilder */
    private $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function find(int $id): ?object
    {
        return $this->findOneBy('id', $id);
    }

    public function findOneBy(string $field, $value): ?object
    {
        $result = $this->queryBuilder
                ->table(static::$table)
                ->select()
                ->where($field, $value)
                ->runQuery()
                ->fetchInto(static::$entity);

        return ($result) ? $result[0] : null;
    }

    public function findBy(array $criterias)
    {
        $this->queryBuilder->table(static::$table)->select();
        foreach($criterias as $criteria) {
            $this->queryBuilder->where(...$criteria);
        }
        return $this->queryBuilder->runQuery()->fetchInto(static::$entity);
    }

    public function findAll()
    {
        return $this->queryBuilder
            ->raw(sprintf("SELECT * FROM %s", static::$table))
            ->fetchInto(static::$entity);
    }

    public function sql(string $query)
    {
        return $this->queryBuilder->raw($query)->fetchInto(static::$entity);
    }

    public function create(Entity $entity): object
    {
        $id = $this->queryBuilder->table(static::$table)->create($entity->toArray());
        return $this->find($id);
    }

    public function update(Entity $entity, array $conditions = []): object
    {
        $this->queryBuilder->table(static::$table)->update($entity->toArray());

        foreach($conditions as $condition) {
            $this->queryBuilder->where(...$condition);
        }

        $this->queryBuilder->where('id', $entity->getId())->runQuery();
        return $this->find($entity->getId());
    }

    public function delete(Entity $entity, array $conditions = []): void
    {
        $this->queryBuilder->table(static::$table)->delete($entity->toArray());
        foreach($conditions as $condition) {
            $this->queryBuilder->where(...$condition);
        }
        $this->queryBuilder->where('id', $entity->getId())->runQuery();
    }
}
