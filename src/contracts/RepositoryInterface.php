<?php declare(strict_types=1);

namespace App\Contracts;

use App\Entities\Entity;

interface RepositoryInterface
{
    public function find(int $id): ?object;
    public function findOneBy(string $field, $value): ?object;
    public function findBy(array $criteria): ?object;
    public function findAll(int $id): array;
    public function sql(string $query);
    public function create(Entity $entity): object;
    public function update(Entity $entity, array $condition = []): object;
    public function delete(Entity $entity, array $condition = []): void;
}