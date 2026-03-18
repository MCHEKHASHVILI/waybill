<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Mappers\WaybillTypeMapper;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetWaybillTypesRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::GET_WAYBILL_TYPES;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        return new ArrayDto(
            data: array_map(
                fn(array $item) => WaybillTypeMapper::fromXmlArray($item),
                $response->xmlReader()->xpathValue('//WAYBILL_TYPES/WAYBILL_TYPE')->get()
            )
        );
    }
}
