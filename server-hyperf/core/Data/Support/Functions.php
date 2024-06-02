<?php

use Hyperf\Context\ApplicationContext;
use Psr\Container\ContainerInterface;
use function Hyperf\Support\value;

if (!function_exists('container')) {
    /**
     * get container instance
     */
    function container(): ContainerInterface
    {
        return ApplicationContext::getContainer();
    }
}

if (!function_exists('rescue')) {
    /**
     * Catch a potential exception and return a default value.
     * @param callable $callback
     * @param callable|null $rescue
     * @param callable|bool $report
     * @return mixed
     * @throws Throwable
     */
    function rescue(callable $callback, callable $rescue = null, callable|bool $report = true): mixed
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            if (value($report, $e)) {
                throw $e;
            }

            return value($rescue, $e);
        }
    }
}