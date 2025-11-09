<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class CreateVehicleStateNumberRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::SAVE_CAR_NUMBERS;
    protected array $keyMap;

    public function __construct(protected mixed $params = [])
    {
        $this->keyMap = [
            "vehicle_state_number" => "car_number",
        ];
    }

    public function createDtoFromResponse(Response $response): BooleanDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        return new BooleanDto(
            result: (int) $data["{$this->action->value}Result"] === 1
        );
    }
}
