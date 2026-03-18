<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use DateTimeImmutable;
use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\DateTimeDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetServerTimeRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action     $action     = Action::GET_SERVER_TIME;
    protected AuthMethod $authMethod = AuthMethod::GUEST;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): DateTimeDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        $raw = (string) ($data["{$this->action->value}Result"] ?? '');

        $dt = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s', $raw)
            ?: new DateTimeImmutable($raw);

        return new DateTimeDto(value: $dt);
    }
}
