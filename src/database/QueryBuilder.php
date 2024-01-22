<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use App\Exception\NotFoundException;
use InvalidArgumentException;

class QueryBuilder
{
    protected $connection; // pdo or mysql
    protected $table;
    protected $statement; // result set
    protected $fields;
    protected $placeholders; // protect against sql injection
    protected $bindings; // name = ? ['terry']
    protected $operation = self::DML_TYPE_SELECT; // DML (select, insert, update, delete)
    public $query;

    const OPERATORS = ['=', '>=', '>', '<=', '<', '<>'];
    const PLACEHOLDER = '?';
    const COLUMNS = '*';
    const DML_TYPE_SELECT = 'SELECT';
    const DML_TYPE_INSERT = 'INSERT';
    const DML_TYPE_UPDATE = 'UPDATE';
    const DML_TYPE_DELETE = 'DELETE';

    use Query;

    public function __construct(DatabaseConnectionInterface $databaseConnection)
    {
        $this->connection = $databaseConnection->getConnection();
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function where(string $column, string $operator = self::OPERATORS[0], $value = null)
    {
        if(!in_array($operator, self::OPERATORS)) {
            if ($value === null) {
                $value = $operator;
                $operator = self::OPERATORS[0];
            } else {
                throw new NotFoundException('Operator is not valid', ['operator' => $operator]);
            }
        }

        $this->parseWhere([$column => $value], $operator);
        $this->query = $this->getQuery($this->operation);

        return $this;
    }

    private function parseWhere(array $conditions, string $operator)
    {
        foreach ($conditions as $column => $value) {
            $this->placeholders[] = sprintf('%s %s %s', $column, $operator, self::PLACEHOLDER); // ex: name = ?
            $this->bindings[] = $value;
        }
        return $this;
    }

    public function select(string $fields = self::COLUMNS)
    {
        $this->operation = self::DML_TYPE_SELECT;
        $this->fields = $fields;
        return $this;
    }

    public function getBindings()
    {
        return $this->bindings;
    }

    public function getPlaceholders()
    {
        return $this->placeholders;
    }

}