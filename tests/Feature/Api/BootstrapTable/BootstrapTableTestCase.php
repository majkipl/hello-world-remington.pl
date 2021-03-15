<?php

namespace Tests\Feature\Api\BootstrapTable;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BootstrapTableTestCase extends TestCase
{
    /**
     * @param $data
     * @param $requestClass
     * @return void
     */
    protected function runValidationTest($data, $requestClass)
    {
        $validator = Validator::make($data, (new $requestClass())->rules());
        $this->assertFalse($validator->fails());
    }

    /**
     * @param $data
     * @param $requestClass
     * @return void
     */
    protected function expectValidationException($data, $requestClass)
    {
        $this->expectException(ValidationException::class);
        Validator::make($data, (new $requestClass())->rules())->validate();
    }
}
