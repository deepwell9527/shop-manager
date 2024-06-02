<?php

namespace HyperfTests\Cases;

use Dotenv\Dotenv;
use HyperfTests\HttpTestCase;

class DockerTest extends HttpTestCase
{
    public function testDockerEnv()
    {
        var_dump(env('DB_USER'), getenv('DB_USER'));

        $this->assertSame(env('DB_USER'), getenv('DB_USER'));
    }

    public function testDockerEnvMerge()
    {
        $before = getenv('DB_USER');
//        $repository = RepositoryBuilder::createWithNoAdapters()
//            ->addAdapter(PutenvAdapter::class)
//            ->immutable()
//            ->make();
//
//        $data = Dotenv::create($repository, [BASE_PATH])->load();
//        var_dump($data,$before,env('DB_USER'));
        $data = Dotenv::createMutable([BASE_PATH])->safeLoad();
        $new = [];
        foreach ($data as $key => $value) {
            $new[$key] = !empty(getenv($key)) ? getenv($key) : $value;
        }
        $content = implode("\n", array_map(function ($key, $value) {
            return "{$key}={$value}";
        }, array_keys($new), array_values($new)));
        var_dump($content);
        file_put_contents(BASE_PATH . '/.env', $content);
        $this->assertGreaterThan(0, count($data));
    }
}