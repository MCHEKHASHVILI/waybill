<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\ServiceUserDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetServiceUsersRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::GET_SERVICE_USERS;
    protected AuthMethod $authMethod = AuthMethod::TENANT;
    public function __construct(protected mixed $params = []) {}
    public function createDtoFromResponse(Response $response): ArrayDto
    {
        return new ArrayDto(
            data: array_reduce(
                $response->xmlReader()->xpathValue("//ServiceUsers/ServiceUser")->get(),
                function ($carry, $val) {
                    $carry[] =  new ServiceUserDto(
                        id: (int) $val['ID'],
                        username: (string) $val['USER_NAME'],
                        tenant_id: (int) $val['UN_ID'],
                        name: (string) $val['NAME'],
                    );
                    return $carry;
                },
                []
            )
        );
    }
}
