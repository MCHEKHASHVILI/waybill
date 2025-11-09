<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Dtos\Static\TransportationTypeDto;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetTransportationTypesRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::GET_TRANS_TYPES;
    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        return new ArrayDto(
            data: array_reduce(
                $response->xmlReader()->xpathValue("//TRANSPORT_TYPES/TRANSPORT_TYPE")->get(),
                function ($carry, $val) {
                    $carry[] = new TransportationTypeDto(
                        id: (int) $val["ID"],
                        name: (string) $val["NAME"]
                    );
                    return $carry;
                },
                []
            )
        );
    }
}
