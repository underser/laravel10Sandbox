<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JeroenG\Explorer\Infrastructure\Elastic\ElasticClientFactory;
use JeroenG\Explorer\Infrastructure\Elastic\FakeResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        /** @see https://github.com/Jeroen-G/Explorer/blob/master/docs/testing.md */
        $fakeResponseFile = fopen(base_path("tests/Support/Elastic/Responses/fakeresponse.json"), 'rb');
        $fakeResponse = new FakeResponse(200, $fakeResponseFile);
        $this->instance(ElasticClientFactory::class, ElasticClientFactory::fake($fakeResponse));
    }
}
