<?php

use Deepwell\Data\Casts\DateTimeInterfaceCast;
use Deepwell\Data\Casts\EnumCast;
use Deepwell\Data\Normalizers\ArrayableNormalizer;
use Deepwell\Data\Normalizers\ArrayNormalizer;
use Deepwell\Data\Normalizers\FormRequestNormalizer;
use Deepwell\Data\Normalizers\JsonNormalizer;
use Deepwell\Data\Normalizers\ModelNormalizer;
use Deepwell\Data\Normalizers\ObjectNormalizer;
use Deepwell\Data\Normalizers\RequestNormalizer;
use Deepwell\Data\Normalizers\ResponseNormalizer;
use Deepwell\Data\RuleInferrers\AttributesRuleInferrer;
use Deepwell\Data\RuleInferrers\BuiltInTypesRuleInferrer;
use Deepwell\Data\RuleInferrers\NullableRuleInferrer;
use Deepwell\Data\RuleInferrers\RequiredRuleInferrer;
use Deepwell\Data\RuleInferrers\SometimesRuleInferrer;
use Deepwell\Data\Support\Creation\ValidationStrategy;
use Deepwell\Data\Transformers\ArrayableTransformer;
use Deepwell\Data\Transformers\DateTimeInterfaceTransformer;
use Deepwell\Data\Transformers\EnumTransformer;
use Hyperf\Contract\Arrayable;

return [
    /**
     * 当处理日期时，该程序包将使用此格式。
     * 如果此选项是数组，它将尝试从第一个有效的格式进行转换，并使用数组中的第一个格式序列化日期
     */
    'date_format' => [
        'Y-m-d H:i:s',
        'U'
    ],

    /**
     * It is possible to enable certain features of the package, these would otherwise
     * be breaking changes, and thus they are disabled by default. In the next major
     * version of the package, these features will be enabled by default.
     */
    'features' => [
        'cast_and_transform_iterables' => false,

        /**
         * When trying to set a computed property value, the package will throw an exception.
         * You can disable this behaviour by setting this option to true, which will then just
         * ignore the value being passed into the computed property and recalculate it.
         */
        'ignore_exception_when_trying_to_set_computed_property_value' => false,
    ],

    /**
     * Global transformers will take complex types and transform them into simple
     * types.
     */
    'transformers' => [
        DateTimeInterface::class => DateTimeInterfaceTransformer::class,
        Arrayable::class => ArrayableTransformer::class,
        BackedEnum::class => EnumTransformer::class,
    ],


    /**
     * 在从简单类型创建数据对象时，全局转换将把值转换为复杂类型。
     */
    'casts' => [
        DateTimeInterface::class => DateTimeInterfaceCast::class,
        BackedEnum::class => EnumCast::class,
    ],

    /**
     * 归一化器返回负载的数组表示形式，如果无法归一化负载，则返回 null。
     * 下面的归一化器用于每个数据对象，除非在特定的数据对象类中被覆盖
     */
    'normalizers' => [
        RequestNormalizer::class,
        ResponseNormalizer::class,
        ModelNormalizer::class,
        FormRequestNormalizer::class,
        ArrayableNormalizer::class,
        ObjectNormalizer::class,
        ArrayNormalizer::class,
        JsonNormalizer::class,
    ],

    /**
     * 一个数据对象可以在使用工厂创建时进行验证，也可以在调用 from 方法时进行验证。
     * 默认情况下，只有在传递了请求时才会进行数据验证。
     * 这种行为可以更改为始终进行验证，或者完全禁用验证
     */
    'validation_strategy' => ValidationStrategy::OnlyRequests->value,

    /**
     * 在此处可以配置规则推断器。它们将根据属性的类型自动为数据对象的属性添加验证规则。
     */
    'rule_inferrers' => [
        SometimesRuleInferrer::class,
        NullableRuleInferrer::class,
        RequiredRuleInferrer::class,
        BuiltInTypesRuleInferrer::class,
        AttributesRuleInferrer::class,
    ],

    /**
     * 在转换一系列嵌套的数据对象时，如果包含递归关系，程序可能会陷入无限循环。
     * 为了防止这种情况发生，可以设置最大转换深度作为安全措施。
     * 当设置为 null 时，程序不会强制执行最大深度限制。
     */
    'max_transformation_depth' => null,

    /**
     * 当达到最大转换深度时，程序将抛出一个异常。
     * 你可以通过将此选项设置为 true 来禁用这种行为，这将返回一个空数组。
     */
    'throw_when_max_transformation_depth_reached' => true,
];