<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\VehicleDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetVehicleStateNumbersRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::GET_CAR_NUMBERS;
    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        return new ArrayDto(
            data: array_reduce(
                $response->xmlReader()->xpathValue("//car_numbers/CAR_NUMBERS/CAR_NUMBER")->get(),
                function ($carry, $val) {
                    $carry[] = new VehicleDto(
                        state_number: (string) $val,
                    );
                    return $carry;
                },
                []
            )
        );
    }
}
