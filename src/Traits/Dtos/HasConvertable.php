<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Traits\Dtos;

use ReflectionClass;

trait HasConvertable
{

    public static function fromArray(array $data, array $map): self
    {
        $reflectionClass = new ReflectionClass(static::class);
        $properties = $reflectionClass->getProperties();

        $mapedData = array_reduce($properties, function ($carry, $property) use ($data, $map) {

            // get type of property
            $propertyType = $property->getType();
            // override array key with $map functionality
            $mapedValue = isset($map[$property->name]) ? $map[$property->name] : $property->name;
            $fallbackValue = $property->getType()->getName() === "array" ? [] : null;
            if (gettype($mapedValue) === "array") {

                if (array_key_exists(1, $mapedValue) && is_callable($mapedValue[1])) {
                    $carry[$property->name] = !empty($data[$mapedValue[0]]) ? $mapedValue[1]($data) : $fallbackValue;
                } else {
                    $carry[$property->name] = !empty($data[$mapedValue[0]]) ? $data[$mapedValue[0]] : $fallbackValue;
                }

                return $carry;
            }
            if (gettype($mapedValue) === "string") {
                $value = !empty($data[$mapedValue]) ? $data[$mapedValue] : $fallbackValue;
                settype($value, $propertyType->getName());
                $carry[$property->name] = ($propertyType->isBuiltin()) ? $value : $data[$mapedValue];
                return $carry;
            }
            if (isset($data[$property->name])) {
                $value = !empty($data[$property->name]) ? $data[$property->name] : $fallbackValue;
                settype($value, $propertyType->getName());
                $carry[$property->name] = $value;
                return $carry;
            }
        }, []);
        return new self(...array_values($mapedData));
    }
    public static function toArray(): array
    {
        return (array) static::class;
    }
    public static function toParams(array $map): array
    {
        // implement
        return [];
    }
}
