<?php

declare(strict_types=1);

namespace App\Site\Database;

use App\Site\Database\Query\Grammars\SiteGrammar as QueryGrammar;
use Hyperf\Context\Context;
use Hyperf\Database\MySqlConnection;
use PDO;
use PDOStatement;

class SiteMySQLConnection extends MySqlConnection
{
    public function insert(string $query, array $bindings = []): bool
    {
        $info = Context::get('compileInsertOverwriteInfo');
        if ($info) {
            $chunks = array_chunk($bindings, $info['original_field_count']);
            $newList = [];
            foreach ($chunks as $chunk) {
                array_push($newList, ...$chunk, ...$info['append_values']);
            }

            $bindings = $newList;
            unset($newList);
            Context::set('compileInsertOverwriteInfo', null);
        }
        return parent::insert($query, $bindings);
    }

    public function bindValues(PDOStatement $statement, array $bindings): void
    {
        foreach ($bindings as $key => $value) {
            $type = PDO::PARAM_STR;
            if (in_array($value, [0, 1], true)) {
                $type = PDO::PARAM_INT;
            }
            $statement->bindValue(
                is_string($key) ? $key : $key + 1,
                $value,
                $type
            );
        }
    }

    protected function getDefaultQueryGrammar(): QueryGrammar
    {
        $g = new QueryGrammar();
        $g->setTablePrefix($this->tablePrefix);
        return $g;
    }
}
