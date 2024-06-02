<?php
declare(strict_types=1);

namespace App\Site\Database\Query\Grammars;

use Hyperf\Context\Context;
use Hyperf\Database\Query\Builder;
use Hyperf\Database\Query\Grammars\MySqlGrammar;

class SiteGrammar extends MySqlGrammar
{
    protected array $notSiteTables = [
        'migrations',
        'setting_config',
        'setting_crontab',
        'setting_crontab_log',
        'setting_generate_columns',
        'setting_generate_tables',
        'system_api',
        'system_api_column',
        'system_api_group',
        'system_api_log',
        'system_menu',
        'system_dict_data',
        'system_dict_type',
        'wxc_category',
    ];

    public function compileSelect(Builder $query): string
    {
        if ($this->whetherOverwrite($query)) {
            $table = $query->from;
            $siteIdField = $table . '.site_id';
            $query->whereRaw("$siteIdField = " . $this->getSiteId());
        }

        return parent::compileSelect($query);
    }

    protected function whetherOverwrite(Builder $query): bool
    {
        return $this->isPassedSiteMiddleware() && !in_array($query->from, $this->notSiteTables);
    }

    protected function isPassedSiteMiddleware(): bool
    {
        $siteInfo = get_current_site();
        return !is_null($siteInfo);
    }

    protected function getSiteId()
    {
        return get_current_site()->siteId ?? null;
    }

    public function compileInsert(Builder $query, array $values): string
    {
        if ($this->whetherOverwrite($query)) {
            if (!array_is_list($values)) {
                $count = count($values);
                $values['site_id'] = $this->getSiteId();
                $values = [$values];
            } else {
                $count = count(reset($values));
                array_walk($values, function (&$value) {
                    $value['site_id'] = $this->getSiteId();
                });
            }
            Context::set('compileInsertOverwriteInfo', ['original_field_count' => $count, 'append_values' => [$this->getSiteId()]]);
        }
        return parent::compileInsert($query, $values);
    }
}