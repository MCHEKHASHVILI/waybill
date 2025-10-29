<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\ErrorCodeDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetErrorCodesRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::GET_ERROR_CODES;
    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        return new ArrayDto(
            data: array_reduce(
                $response->xmlReader()->xpathValue("//ERROR_CODES/ERROR_CODE")->get(),
                function ($carry, $val) {
                    $carry[] = new ErrorCodeDto(
                        id: (int) $val["ID"],
                        message: (string) $val["TEXT"],
                        type_id: (int) ($val["TYPE"] ?? null),
                    );
                    return $carry;
                },
                []
            )
        );
    }
}
