<?php

use Mchekhashvili\RsWaybill\Dtos\Static\WhatIsMyIp;
use Mchekhashvili\RsWaybill\Requests\WhatIsMyIpRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("Returns " . WhatIsMyIp::class . " with property (string) {ip}", function () {
    $dto = (new WaybillServiceConnector())->send(new WhatIsMyIpRequest())->dto();
    expect($dto)->toBeInstanceOf(WhatIsMyIp::class);
    expect($dto)->toHaveProperty("ip");
    expect($dto->ip)->toBeString("getting unexpected type of value for ip");
});
