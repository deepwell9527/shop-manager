<?php
declare(strict_types=1);

namespace Deepwell\Data\Listeners;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;
use Hyperf\Validation\Validator;

#[Listener]
class ValidatorFactoryResolvedListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class,
        ];
    }

    public function process(object $event): void
    {
        // todo something
//        /**  @var ValidatorFactoryInterface $validatorFactory */
//        $validatorFactory = $event->validatorFactory;
//        // 注册了 foo 验证器
//        $validatorFactory->extend('foo', function (string $attribute, mixed $value, array $parameters, Validator $validator): bool {
//            return $value == 'foo';
//        });
//        // 当创建一个自定义验证规则时，你可能有时候需要为错误信息定义自定义占位符这里扩展了 :foo 占位符
//        $validatorFactory->replacer('foo', function (string $message, string $attribute, string $rule, array $parameters): array|string {
//            return str_replace(':foo', $attribute, $message);
//        });
    }
}