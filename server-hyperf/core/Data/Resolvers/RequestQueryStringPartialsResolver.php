<?php

namespace Deepwell\Data\Resolvers;

use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Contracts\BaseDataCollectable;
use Deepwell\Data\Support\DataClass;
use Deepwell\Data\Support\DataConfig;
use Deepwell\Data\Support\Partials\Partial;
use Deepwell\Data\Support\Partials\PartialsCollection;
use Deepwell\Data\Support\Partials\PartialType;
use Deepwell\Data\Support\Partials\Segments\AllPartialSegment;
use Deepwell\Data\Support\Partials\Segments\FieldsPartialSegment;
use Deepwell\Data\Support\Partials\Segments\NestedPartialSegment;
use Deepwell\Data\Support\Partials\Segments\PartialSegment;
use Hyperf\HttpServer\Contract\RequestInterface;

class RequestQueryStringPartialsResolver
{
    public function __construct(
        protected DataConfig $dataConfig,
    )
    {
    }

    public function execute(
        BaseData|BaseDataCollectable $data,
        RequestInterface             $request,
        PartialType                  $type
    ): ?PartialsCollection
    {
        $parameter = $type->getRequestParameterName();

        if (!$request->has($parameter)) {
            return null;
        }

        $dataClass = $this->dataConfig->getDataClass(match (true) {
            $data instanceof BaseData => $data::class,
            $data instanceof BaseDataCollectable => $data->getDataClass(),
        });

        $partials = new PartialsCollection();

        $partialStrings = is_array($request->query($parameter))
            ? $request->query($parameter)
            : explode(',', $request->query($parameter));

        foreach ($partialStrings as $partialString) {
            $partial = Partial::create($partialString);

            $partialSegments = $this->validateSegments(
                $partial->segments,
                $type,
                $dataClass
            );

            if ($partialSegments === null) {
                continue;
            }

            $partials->attach(new Partial($partialSegments, permanent: false, condition: null));
        }

        return $partials;
    }

    /**
     * @param array<PartialSegment> $partialSegments
     *
     * @return array<PartialSegment>|null
     */
    protected function validateSegments(
        array       $partialSegments,
        PartialType $type,
        DataClass   $dataClass,
    ): ?array
    {
        $allowed = $type->getAllowedPartials($dataClass);

        $segment = $partialSegments[0] ?? null;

        if ($segment instanceof AllPartialSegment) {
            if ($allowed === null || $allowed === ['*']) {
                return [$segment];
            }

            return null;
        }

        if ($segment instanceof NestedPartialSegment) {
            $field = $this->findField($segment->field, $dataClass);

            if ($field === null) {
                return null;
            }

            $propertyDataClass = $dataClass->properties->get($field)->type->dataClass;

            if (
                $propertyDataClass &&
                ($allowed === null || $allowed === ['*'] || in_array($field, $allowed))
            ) {
                $nextSegments = $this->validateSegments(
                    array_slice($partialSegments, 1),
                    $type,
                    $this->dataConfig->getDataClass($propertyDataClass)
                );

                if ($nextSegments === null) {
                    return [new FieldsPartialSegment([$field])];
                }

                return [$segment, ...$nextSegments];
            }

            return null;
        }

        if ($segment instanceof FieldsPartialSegment) {
            $validFields = [];

            $allowsAllFields = $allowed === null || $allowed === ['*'];

            foreach ($segment->fields as $field) {
                $field = $this->findField($field, $dataClass);

                if ($field === null) {
                    continue;
                }

                if ($allowsAllFields || in_array($field, $allowed)) {
                    $validFields[] = $field;
                }
            }

            if (count($validFields) === 0) {
                return null;
            }

            return [new FieldsPartialSegment($validFields)];
        }

        return null;
    }

    protected function findField(
        string    $field,
        DataClass $dataClass,
    ): ?string
    {
        if ($dataClass->properties->has($field)) {
            return $field;
        }

        $outputMappedProperties = $dataClass->outputMappedProperties->resolve();

        if (array_key_exists($field, $outputMappedProperties)) {
            return $outputMappedProperties[$field];
        }

        return null;
    }
}
