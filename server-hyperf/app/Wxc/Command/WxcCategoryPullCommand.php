<?php

declare(strict_types=1);

namespace App\Wxc\Command;

use App\Wxc\Concern\ManageChannelsShopApp;
use App\Wxc\Model\WxcCategory;
use Carbon\Carbon;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\DbConnection\Db;

#[Command]
class WxcCategoryPullCommand extends HyperfCommand
{
    use ManageChannelsShopApp;

    protected ?string $signature = 'wxc:category:pull';

    protected string $description = '拉取微信视屏号小店类目更新';


    public function handle()
    {
        Db::table('wxc_category')->truncate();

        $app = $this->initApplicationByAppId('wx028b072b6afd5694');
        $client = $app->category;
        $res = $client->getAll();

        $res->cats->each(function ($catInfoSet) {
            foreach ($catInfoSet->cat_and_qua as $catAndQua) {
                $datalist[$catAndQua->cat->cat_id] = [
                    'category_id' => $catAndQua->cat->cat_id,
                    'title' => $catAndQua->cat->name,
                    'pid' => $catAndQua->cat->f_cat_id,
                    'level_id' => $catAndQua->cat->level,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $c = WxcCategory::find($catAndQua->cat->cat_id);
                if (!$c) {
                    $c = new WxcCategory();
                }
                $c->fill([
                    'category_id' => $catAndQua->cat->cat_id,
                    'title' => $catAndQua->cat->name,
                    'pid' => $catAndQua->cat->f_cat_id,
                    'level_id' => $catAndQua->cat->level,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $c->save();
            }
        });
    }
}