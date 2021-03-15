<?php

namespace Tests\Feature\Api\Validation;

use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ValidationTestCase extends TestCase
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
     * @param array $params
     * @return void
     */
    protected function expectValidationException($data, $requestClass, array $params = [])
    {
        $this->expectException(ValidationException::class);
        $class = (new $requestClass());
        $class->initialize($params,[]);

        Validator::make($data, $class->rules())->validate();
    }

    protected function createTestFile($filename, $size): File
    {
        Storage::fake('public');

        return UploadedFile::fake()->create($filename, $size);
    }
}
