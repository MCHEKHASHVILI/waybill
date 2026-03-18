<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Mappers\WaybillMapper;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetWaybillRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::GET_WAYBILL;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): WaybillDto
    {
        return WaybillMapper::fromXmlArray(
            $response->xmlReader()->xpathValue('//WAYBILL')->sole()
        );
    }
}
