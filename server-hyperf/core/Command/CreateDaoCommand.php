<?php

declare(strict_types=1);

namespace Deepwell\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Database\ConnectionResolverInterface;
use Hyperf\Database\Schema\Builder;
use Hyperf\Stringable\Str;
use Mine\Mine;
use Mine\MineCommand;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function Hyperf\Support\env;
use function Hyperf\Support\make;

#[Command]
class CreateDaoCommand extends MineCommand
{
    protected ?ConnectionResolverInterface $resolver = null;

    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('shop-manager:gen-dao');
    }

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/hyperf.php shop-manager:gen-dao <--module | -M <module>> [--table | -T [table]]"');
        $this->setDescription('Generate entity & do to module according to data table');
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $this->resolver = $this->container->get(ConnectionResolverInterface::class);
        return parent::run($input, $output);
    }

    public function handle()
    {
        $mine = make(Mine::class);
        $module = $this->input->getOption('module');
        if ($module) {
            $module = ucfirst(trim($this->input->getOption('module')));
        }

        $table = $this->input->getOption('table');
        if ($table) {
            $table = env('DB_PREFIX') . trim($this->input->getOption('table'));
        }

        $builder = $this->getSchemaBuilder();
        $table = Str::replaceFirst(env('DB_PREFIX'), '', $table);
        $columns = $this->formatColumns($builder->getColumnTypeListing($table));

        var_dump($columns);

//        if (empty($module)) {
//            $this->line('Missing parameter <--module < module_name>>', 'error');
//        }
//
//        $moduleInfos = $mine->getModuleInfo();
//
//        if (isset($moduleInfos[$module])) {
//            $path = "app/{$module}/Model";
//
//            $db = env('DB_DATABASE');
//            $prefix = env('DB_PREFIX');
//
//            $tables = Db::select('SHOW TABLES');
//            $key = "Tables_in_{$db}";
//
//            $tableList = [];
//            foreach ($tables as $k) {
//                $tmp = $k->{$key};
//                if (!empty($prefix) && preg_match(sprintf('/%s_%s[_a-zA-Z0-9]+/i', $prefix, $module), $tmp)) {
//                    $tableList[] = $tmp;
//                }
//                if (preg_match(sprintf('/%s(\\b|_[a-zA-Z0-9]+)/i', $module), $tmp)) {
//                    $tableList[] = $tmp;
//                }
//            }
//
//            if (!empty($table)) {
//                if (!in_array($table, $tableList)) {
//                    $this->confirm("Table \"{$table}\" does not exist or not belong to the \"{$module}\" module. Are you sure to generate the model?", false)
//                    && $this->call('gen:model', ['table' => $table, '--path' => $path]);
//                } else {
//                    $this->call('gen:model', ['table' => $table, '--path' => $path]);
//                }
//            } else {
//                foreach ($tableList as $table) {
//                    $this->call('gen:model', ['table' => $table, '--path' => $path]);
//                }
//            }
//        }
    }

    protected function getSchemaBuilder(): Builder
    {
        $connection = $this->resolver->connection();
        return $connection->getSchemaBuilder();
    }

    protected function formatColumns(array $columns): array
    {
        return array_map(function ($item) {
            return array_change_key_case($item, CASE_LOWER);
        }, $columns);
    }

    protected function getOptions(): array
    {
        return [
            ['module', '-M', InputOption::VALUE_REQUIRED, 'Please enter the module to be generated'],
            ['table', '-T', InputOption::VALUE_OPTIONAL, 'Which table you want to associated with the Model.'],
        ];
    }
}
