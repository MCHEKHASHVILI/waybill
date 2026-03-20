<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Interfaces\Requests;

interface HasParamsInterface
{
    public function createXmlBodyFromParams(): string;
    public function getParams(): ?array;
    public function setParams(array $params): void;
    public function getParam(string $param): mixed;
    public function setParam(string $param, mixed $value): void;
}
