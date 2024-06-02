<?php

namespace Deepwell\Data\Support\Validation;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationRuleParser;
use Deepwell\Data\Attributes\Validation\Accepted;
use Deepwell\Data\Attributes\Validation\AcceptedIf;
use Deepwell\Data\Attributes\Validation\ActiveUrl;
use Deepwell\Data\Attributes\Validation\After;
use Deepwell\Data\Attributes\Validation\AfterOrEqual;
use Deepwell\Data\Attributes\Validation\Alpha;
use Deepwell\Data\Attributes\Validation\AlphaDash;
use Deepwell\Data\Attributes\Validation\AlphaNumeric;
use Deepwell\Data\Attributes\Validation\ArrayType;
use Deepwell\Data\Attributes\Validation\Bail;
use Deepwell\Data\Attributes\Validation\Before;
use Deepwell\Data\Attributes\Validation\BeforeOrEqual;
use Deepwell\Data\Attributes\Validation\Between;
use Deepwell\Data\Attributes\Validation\BooleanType;
use Deepwell\Data\Attributes\Validation\Confirmed;
use Deepwell\Data\Attributes\Validation\CurrentPassword;
use Deepwell\Data\Attributes\Validation\Date;
use Deepwell\Data\Attributes\Validation\DateEquals;
use Deepwell\Data\Attributes\Validation\DateFormat;
use Deepwell\Data\Attributes\Validation\Declined;
use Deepwell\Data\Attributes\Validation\DeclinedIf;
use Deepwell\Data\Attributes\Validation\Different;
use Deepwell\Data\Attributes\Validation\Digits;
use Deepwell\Data\Attributes\Validation\DigitsBetween;
use Deepwell\Data\Attributes\Validation\Dimensions;
use Deepwell\Data\Attributes\Validation\Distinct;
use Deepwell\Data\Attributes\Validation\DoesntEndWith;
use Deepwell\Data\Attributes\Validation\DoesntStartWith;
use Deepwell\Data\Attributes\Validation\Email;
use Deepwell\Data\Attributes\Validation\EndsWith;
use Deepwell\Data\Attributes\Validation\Enum;
use Deepwell\Data\Attributes\Validation\ExcludeIf;
use Deepwell\Data\Attributes\Validation\ExcludeUnless;
use Deepwell\Data\Attributes\Validation\ExcludeWith;
use Deepwell\Data\Attributes\Validation\ExcludeWithout;
use Deepwell\Data\Attributes\Validation\Exists;
use Deepwell\Data\Attributes\Validation\File;
use Deepwell\Data\Attributes\Validation\Filled;
use Deepwell\Data\Attributes\Validation\GreaterThan;
use Deepwell\Data\Attributes\Validation\GreaterThanOrEqualTo;
use Deepwell\Data\Attributes\Validation\Image;
use Deepwell\Data\Attributes\Validation\In;
use Deepwell\Data\Attributes\Validation\InArray;
use Deepwell\Data\Attributes\Validation\IntegerType;
use Deepwell\Data\Attributes\Validation\IP;
use Deepwell\Data\Attributes\Validation\IPv4;
use Deepwell\Data\Attributes\Validation\IPv6;
use Deepwell\Data\Attributes\Validation\Json;
use Deepwell\Data\Attributes\Validation\LessThan;
use Deepwell\Data\Attributes\Validation\LessThanOrEqualTo;
use Deepwell\Data\Attributes\Validation\Lowercase;
use Deepwell\Data\Attributes\Validation\MacAddress;
use Deepwell\Data\Attributes\Validation\Max;
use Deepwell\Data\Attributes\Validation\MaxDigits;
use Deepwell\Data\Attributes\Validation\Mimes;
use Deepwell\Data\Attributes\Validation\MimeTypes;
use Deepwell\Data\Attributes\Validation\Min;
use Deepwell\Data\Attributes\Validation\MinDigits;
use Deepwell\Data\Attributes\Validation\MultipleOf;
use Deepwell\Data\Attributes\Validation\NotIn;
use Deepwell\Data\Attributes\Validation\NotRegex;
use Deepwell\Data\Attributes\Validation\Nullable;
use Deepwell\Data\Attributes\Validation\Numeric;
use Deepwell\Data\Attributes\Validation\Password;
use Deepwell\Data\Attributes\Validation\Present;
use Deepwell\Data\Attributes\Validation\Prohibited;
use Deepwell\Data\Attributes\Validation\ProhibitedIf;
use Deepwell\Data\Attributes\Validation\ProhibitedUnless;
use Deepwell\Data\Attributes\Validation\Prohibits;
use Deepwell\Data\Attributes\Validation\Regex;
use Deepwell\Data\Attributes\Validation\Required;
use Deepwell\Data\Attributes\Validation\RequiredArrayKeys;
use Deepwell\Data\Attributes\Validation\RequiredIf;
use Deepwell\Data\Attributes\Validation\RequiredUnless;
use Deepwell\Data\Attributes\Validation\RequiredWith;
use Deepwell\Data\Attributes\Validation\RequiredWithAll;
use Deepwell\Data\Attributes\Validation\RequiredWithout;
use Deepwell\Data\Attributes\Validation\RequiredWithoutAll;
use Deepwell\Data\Attributes\Validation\Same;
use Deepwell\Data\Attributes\Validation\Size;
use Deepwell\Data\Attributes\Validation\Sometimes;
use Deepwell\Data\Attributes\Validation\StartsWith;
use Deepwell\Data\Attributes\Validation\StringType;
use Deepwell\Data\Attributes\Validation\Timezone;
use Deepwell\Data\Attributes\Validation\Ulid;
use Deepwell\Data\Attributes\Validation\Unique;
use Deepwell\Data\Attributes\Validation\Uppercase;
use Deepwell\Data\Attributes\Validation\Url;
use Deepwell\Data\Attributes\Validation\Uuid;
use Deepwell\Data\Exceptions\CouldNotCreateValidationRule;

class ValidationRuleFactory
{
    public function create(string $rule): ValidationRule
    {
        [$keyword, $parameters] = ValidationRuleParser::parse($rule);

        /** @var \Deepwell\Data\Attributes\Validation\StringValidationAttribute|null $ruleClass */
        $ruleClass = $this->mapping()[Str::snake($keyword)] ?? null;

        if ($ruleClass === null) {
            throw CouldNotCreateValidationRule::create($rule);
        }

        return $ruleClass::create(...$parameters);
    }

    protected function mapping(): array
    {
        return [
            Accepted::keyword() => Accepted::class,
            AcceptedIf::keyword() => AcceptedIf::class,
            ActiveUrl::keyword() => ActiveUrl::class,
            After::keyword() => After::class,
            AfterOrEqual::keyword() => AfterOrEqual::class,
            Alpha::keyword() => Alpha::class,
            AlphaDash::keyword() => AlphaDash::class,
            AlphaNumeric::keyword() => AlphaNumeric::class,
            ArrayType::keyword() => ArrayType::class,
            Bail::keyword() => Bail::class,
            Before::keyword() => Before::class,
            BeforeOrEqual::keyword() => BeforeOrEqual::class,
            Between::keyword() => Between::class,
            BooleanType::keyword() => BooleanType::class,
            Confirmed::keyword() => Confirmed::class,
            CurrentPassword::keyword() => CurrentPassword::class,
            Date::keyword() => Date::class,
            DateEquals::keyword() => DateEquals::class,
            DateFormat::keyword() => DateFormat::class,
            Declined::keyword() => Declined::class,
            DeclinedIf::keyword() => DeclinedIf::class,
            Different::keyword() => Different::class,
            Digits::keyword() => Digits::class,
            DigitsBetween::keyword() => DigitsBetween::class,
            Dimensions::keyword() => Dimensions::class,
            Distinct::keyword() => Distinct::class,
            Email::keyword() => Email::class,
            DoesntEndWith::keyword() => DoesntEndWith::class,
            DoesntStartWith::keyword() => DoesntStartWith::class,
            EndsWith::keyword() => EndsWith::class,
            Enum::keyword() => Enum::class,
            ExcludeIf::keyword() => ExcludeIf::class,
            ExcludeUnless::keyword() => ExcludeUnless::class,
            ExcludeWith::keyword() => ExcludeWith::class,
            ExcludeWithout::keyword() => ExcludeWithout::class,
            Exists::keyword() => Exists::class,
            File::keyword() => File::class,
            Filled::keyword() => Filled::class,
            GreaterThan::keyword() => GreaterThan::class,
            GreaterThanOrEqualTo::keyword() => GreaterThanOrEqualTo::class,
            Image::keyword() => Image::class,
            In::keyword() => In::class,
            InArray::keyword() => InArray::class,
            IntegerType::keyword() => IntegerType::class,
            IP::keyword() => IP::class,
            IPv4::keyword() => IPv4::class,
            IPv6::keyword() => IPv6::class,
            Json::keyword() => Json::class,
            LessThan::keyword() => LessThan::class,
            LessThanOrEqualTo::keyword() => LessThanOrEqualTo::class,
            Lowercase::keyword() => Lowercase::class,
            MacAddress::keyword() => MacAddress::class,
            Max::keyword() => Max::class,
            MaxDigits::keyword() => MaxDigits::class,
            Mimes::keyword() => Mimes::class,
            MimeTypes::keyword() => MimeTypes::class,
            Min::keyword() => Min::class,
            MinDigits::keyword() => MinDigits::class,
            MultipleOf::keyword() => MultipleOf::class,
            NotIn::keyword() => NotIn::class,
            NotRegex::keyword() => NotRegex::class,
            Nullable::keyword() => Nullable::class,
            Numeric::keyword() => Numeric::class,
            Password::keyword() => Password::class,
            Present::keyword() => Present::class,
            Prohibited::keyword() => Prohibited::class,
            ProhibitedIf::keyword() => ProhibitedIf::class,
            ProhibitedUnless::keyword() => ProhibitedUnless::class,
            Prohibits::keyword() => Prohibits::class,
            Regex::keyword() => Regex::class,
            Required::keyword() => Required::class,
            RequiredArrayKeys::keyword() => RequiredArrayKeys::class,
            RequiredIf::keyword() => RequiredIf::class,
            RequiredUnless::keyword() => RequiredUnless::class,
            RequiredWith::keyword() => RequiredWith::class,
            RequiredWithAll::keyword() => RequiredWithAll::class,
            RequiredWithout::keyword() => RequiredWithout::class,
            RequiredWithoutAll::keyword() => RequiredWithoutAll::class,
            Same::keyword() => Same::class,
            Size::keyword() => Size::class,
            Sometimes::keyword() => Sometimes::class,
            StartsWith::keyword() => StartsWith::class,
            StringType::keyword() => StringType::class,
            Timezone::keyword() => Timezone::class,
            Unique::keyword() => Unique::class,
            Uppercase::keyword() => Uppercase::class,
            Url::keyword() => Url::class,
            Ulid::keyword() => Ulid::class,
            Uuid::keyword() => Uuid::class,
        ];
    }
}
