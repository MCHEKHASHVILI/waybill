<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use DateTimeImmutable;
use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\ExciseCodeDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetExciseCodesRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::GET_EXCISE_CODES;
    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        return new ArrayDto(
            data: array_reduce(
                $response->xmlReader()->xpathValue("//AKCIZ_CODES/AKCIZ_CODE")->get(),
                function ($carry, $val) {
                    $carry[] = new ExciseCodeDto(
                        id: (int) $val["ID"],
                        name: (string) $val["TITLE"],
                        unit_name: isset($val["MEASUREMENT"]) ? (string) $val["MEASUREMENT"] : null,
                        code: (int) $val["SAKON_KODI"],
                        rate: (float) $val["AKCIS_GANAKV"],
                        started_at: isset($val["START_DATE"]) ? DateTimeImmutable::createFromFormat("Y-m-d", $val["START_DATE"]) : null,
                        ended_at: isset($val["END_DATE"]) ? DateTimeImmutable::createFromFormat("Y-m-d", $val["END_DATE"]) : null,
                    );
                    return $carry;
                },
                []
            )
        );
    }
}
