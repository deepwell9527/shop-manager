<?php

namespace Deepwell\Data\Contracts;

interface ResponsableData extends TransformableData
{
    public function toResponse($request);

    public static function allowedRequestIncludes(): ?array;

    public static function allowedRequestExcludes(): ?array;

    public static function allowedRequestOnly(): ?array;

    public static function allowedRequestExcept(): ?array;
}
