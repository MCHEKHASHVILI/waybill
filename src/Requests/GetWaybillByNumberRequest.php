<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillDto;
use Mchekhashvili\Rs\Waybill\Mappers\WaybillMapper;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;

class GetWaybillByNumberRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::GET_WAYBILL_BY_NUMBER;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): WaybillDto
    {
        return WaybillMapper::fromXmlArray(
            $response->xmlReader()->xpathValue('//WAYBILL')->sole()
        );
    }
}
