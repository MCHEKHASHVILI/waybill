<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\BarcodeDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetBarcodesRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::GET_BARCODES;
    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        return new ArrayDto(
            data: array_reduce(
                $response->xmlReader()->xpathValue("//bar_codes/BAR_CODES/BAR_CODE")->get(),
                function ($carry, $val) {
                    $carry[] = new BarcodeDto(
                        code: (string) $val["CODE"],
                        name: (string) $val["NAME"],
                        unit_id: (string) $val["UNIT_ID"],
                        unit_name: isset($val["UNIT_TXT"]) ? (string) $val["UNIT_TXT"] : null,
                    );
                    return $carry;
                },
                []
            )
        );
    }
}
