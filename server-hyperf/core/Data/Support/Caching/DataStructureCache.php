<?php

namespace Deepwell\Data\Support\Caching;

use Deepwell\Data\Support\DataClass;
use Hyperf\Di\Annotation\Inject;
use Psr\SimpleCache\CacheInterface;
use Throwable;

class DataStructureCache
{
    #[Inject]
    protected CacheInterface $store;

    private string $prefix;

    private ?int $duration;

    public function __construct(
        protected array $cacheConfig,
    )
    {
        $this->prefix = ($this->cacheConfig['prefix'] ?? '') ? "{$this->cacheConfig['prefix']}." : '';
        $this->duration = $this->cacheConfig['duration'] ?? null;
    }

    public function getConfig(): ?CachedDataConfig
    {
        /** @var ?CachedDataConfig $cachedConfig */
        $cachedConfig = $this->get('config');

        if ($cachedConfig) {
            $cachedConfig->setCache($this);
        }

        return $cachedConfig;
    }

    private function get(string $key): mixed
    {
        $serialized = $this->store->get($this->prefix . $key);

        if ($serialized === null) {
            return null;
        }

        try {
            return unserialize($serialized);
        } catch (Throwable) {
            return null;
        }
    }

    public function storeConfig(CachedDataConfig $config): void
    {
        $this->set('config', $config);
    }

    private function set(string $key, mixed $value): void
    {
        if (is_null($this->duration)) {
            $this->store->set($this->prefix . $key, serialize($value));
        } else {
            $this->store->set($this->prefix . $key, serialize($value), $this->duration);
        }
    }

    public function getDataClass(string $className): ?DataClass
    {
        return $this->get("data-class.{$className}");
    }

    public function storeDataClass(DataClass $dataClass): void
    {
        $this->set("data-class.{$dataClass->name}", $dataClass);
    }
}
