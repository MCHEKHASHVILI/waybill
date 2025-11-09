<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WoodTypeDto;
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
            data: array_reduce(
                $response->xmlReader()->xpathValue("//WOOD_TYPES/WOOD_TYPE")->get(),
                function ($carry, $val) {
                    $carry[] = new WoodTypeDto(
                        id: (int) $val["ID"],
                        name: (string) $val["NAME"],
                        description: isset($val["DESCRIPTION"]) ? (string) $val["DESCRIPTION"] : null
                    );
                    return $carry;
                },
                []
            )
        );
    }
}
