<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillCreatedDto;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Enums\WaybillErrorCode;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillRequestException;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Saloon\Http\Response;
use Saloon\XmlWrangler\Exceptions\MissingNodeException;

class CreateWaybillRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::SAVE_WAYBILL;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): WaybillCreatedDto
    {
        // The RS API returns the save_waybill result inside <RESULT>:
        //   <save_waybillResult><RESULT><STATUS>0</STATUS><ID>...</ID>...</RESULT></save_waybillResult>
        // STATUS = 0 means saved; any negative value is an RS error code.
        try {
            $result = $response->xmlReader()->xpathValue('//RESULT')->sole();
        } catch (MissingNodeException $e) {
            dd($response->body());
            throw new WaybillRequestException(
                message: 'RS save_waybill response is missing <RESULT> node',
                responseBody: $response->body(),
                previous: $e,
            );
        }

        $status = (int) ($result['STATUS'] ?? 0);

        if ($status !== 0) {
            $errorCode = WaybillErrorCode::tryFrom($status);
            $message   = $errorCode?->message()
                ?? sprintf('RS save_waybill failed with status %d', $status);

            throw new WaybillRequestException(
                message: $message,
                responseBody: $response->body(),
                code: $status,
            );
        }

        // Collect per-item goods errors (STATUS=0 but individual lines may have errors)
        $goodsErrors = [];
        $goodsList   = $result['GOODS_LIST']['GOODS'] ?? [];

        // Normalise: single goods entry is an assoc array, multiple entries is a list
        if (isset($goodsList['ERROR'])) {
            $goodsList = [$goodsList];
        }

        foreach ($goodsList as $index => $goods) {
            $error = (int) ($goods['ERROR'] ?? 0);
            if ($error !== 0) {
                $goodsErrors[$index] = $error;
            }
        }

        return new WaybillCreatedDto(
            id: (int)    ($result['ID']             ?? 0),
            number: (string) ($result['WAYBILL_NUMBER'] ?? ''),
            goodsErrors: $goodsErrors,
        );
    }
}
