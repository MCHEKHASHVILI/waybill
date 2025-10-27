<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Traits\Requests;

use Exception;
use Saloon\XmlWrangler\XmlWriter;
use Saloon\XmlWrangler\Data\Element;
use Saloon\XmlWrangler\Data\RootElement;
use Mchekhashvili\RsWaybill\Enums\EnvelopeNamespace;


trait HasParams
{
    /**
     * Generating string body using params
     * @return string
     */
    public function createXmlBodyFromParams(): string
    {
        return XmlWriter::make()->write(
            $this->getRootElement(),
            $this->getBodyElement()
        );
    }

    protected function getRootElement(): RootElement
    {
        return (new RootElement("soap:Envelope"))->setNamespaces(EnvelopeNamespace::toArray());
    }

    protected function getBodyElement(): array
    {
        return [
            "soap:Body" => [
                $this->getAction()->value => Element::make(
                    $this->getPassableParams($this->params)
                )->addAttribute("xmlns", "http://tempuri.org/"),
            ]
        ];
    }

    /**
     * Simply validating that array is returned
     */
    public function getPassableParams(mixed $params): array
    {
        $passableParams = $params;

        if (is_object($passableParams) && method_exists($passableParams, "convertToParams")) {
            $passableParams = $passableParams->convertToParams();
        }

        if (!is_array($passableParams)) {
            throw new Exception("Unknow parameters passed to the constructor of: " . static::class);
        }

        return $passableParams;
    }

    public function getParams(): ?array
    {
        return $this->params;
    }
    public function setAuthParams(mixed $params): void
    {
        $this->params = array_merge(
            $this->getPassableParams($params),
            $this->getPassableParams($this->params)
        );
    }
    public function setParams(mixed $params): void
    {
        $this->params = array_merge(
            $this->getPassableParams($this->params),
            $this->getPassableParams($params)
        );
    }
    public function getParam(string $param): mixed
    {
        return $this->params[$param] ?? null;
    }
    public function setParam(string $param, mixed $value): void
    {
        $this->params[$param] = $value;
    }
}
