<?php

declare(strict_types=1);

namespace Deepwell\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Database\Schema\Schema;
use Hyperf\DbConnection\Db;
use Mine\Mine;
use Mine\MineCommand;
use Psr\Container\ContainerInterface;
use function Hyperf\Support\env;
use function Hyperf\Support\make;

#[Command]
class InstallCommand extends MineCommand
{
    public function __construct(protected ContainerInterface $container)
    {
        parent::__construct('shop-manager:install');
    }

    public function configure(): void
    {
        parent::configure();
        $this->setDescription('项目初始化安装');
    }

    public function handle()
    {
        /* @var Mine $mine */
        $this->line("Installation of local modules is about to begin...\n", 'comment');
        $mine = make(Mine::class);
        $modules = $mine->getModuleInfo();
        foreach ($modules as $name => $info) {
            $this->call('mine:migrate-run', ['name' => $name, '--force' => 'true']);
            if ($name === 'System') {
                $this->initUserData();
            }
            $this->call('mine:seeder-run', ['name' => $name, '--force' => 'true']);
            $this->line($this->getGreenText(sprintf('"%s" module install successfully', $name)));
        }
    }

    protected function initUserData(): void
    {
        // 清理数据
        Db::table('system_user')->truncate();
        Db::table('system_role')->truncate();
        Db::table('system_user_role')->truncate();
        if (Schema::hasTable('system_user_dept')) {
            Db::table('system_user_dept')->truncate();
        }

        // 创建超级管理员
        Db::table('system_user')->insert([
            'id' => env('SUPER_ADMIN', 1),
            'username' => 'superAdmin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'user_type' => '100',
            'nickname' => '创始人',
            'email' => 'admin@adminmine.com',
            'phone' => '18520015605',
            'signed' => '广阔天地，大有所为',
            'dashboard' => 'statistics',
            'created_by' => 0,
            'updated_by' => 0,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        // 创建管理员角色
        Db::table('system_role')->insert([
            'id' => env('ADMIN_ROLE', 1),
            'name' => '超级管理员（创始人）',
            'code' => 'superAdmin',
            'data_scope' => 0,
            'sort' => 0,
            'created_by' => env('SUPER_ADMIN', 0),
            'updated_by' => 0,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'remark' => '系统内置角色，不可删除',
        ]);
        if (env('DB_DRIVER') == 'pgsql') {
            Db::select("SELECT setval('system_user_id_seq', 1)");
            Db::select("SELECT setval('system_role_id_seq', 1)");
        }
        Db::table('system_user_role')->insert([
            'user_id' => env('SUPER_ADMIN', 1),
            'role_id' => env('ADMIN_ROLE', 1),
        ]);
    }
}
