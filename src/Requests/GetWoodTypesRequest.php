<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Mappers\WoodTypeMapper;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetWoodTypesRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::GET_WOOD_TYPES;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        return new ArrayDto(
            data: array_map(
                fn(array $item) => WoodTypeMapper::fromXmlArray($item),
                $response->xmlReader()->xpathValue('//WOOD_TYPES/WOOD_TYPE')->get()
            )
        );
    }
}
