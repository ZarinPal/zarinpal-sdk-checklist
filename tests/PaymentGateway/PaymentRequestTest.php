<?php

namespace PaymentGateway;

use Http\Message\RequestMatcher\RequestMatcher;
use Http\Mock\Client;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;
use ZarinPal\Sdk\ClientBuilder;
use ZarinPal\Sdk\Endpoint\PaymentGateway\RequestTypes\RequestRequest;
use ZarinPal\Sdk\Options;
use ZarinPal\Sdk\ZarinPal;

class PaymentRequestTest extends TestCase
{
    protected Client $mockClient;

    final public function setUp(): void
    {

        parent::setUp();

        $this->mockClient = new Client();

    }

    final public function testCanRequest200Response(): void
    {
        $request = new RequestRequest();
        $request->amount = 2000;
        $request->merchantId = 'a738fc08-1e83-4928-bf90-08936ea6e1ed2';
        $request->description = 'test';
        $request->callback_url = 'https://tehran.ir';
        $request->mobile = '09375065007';
        $request->email = 'a@b.c';

        $httpClient = $this->givenSdk()->getHttpClient();
        $response = $this->givenSdk()->paymentGateway()->request($request);

        die(print_r($response));
        $this->assertEquals(200, $response->getStatusCode());
    }

    private function givenSdk(): ZarinPal
    {
        $options = new Options([
            'client_builder' => new ClientBuilder($this->mockClient),
            'merchant_id' => 'a738fc08-1e83-4928-bf90-08936ea6e1ed',
        ]);
        return new ZarinPal($options);
    }

    public function testCanRequest201Response(): void
    {
        $this->mockClient->addResponse((new Response())->withStatus(201));

        $httpClient = $this->givenSdk()->getHttpClient();
        $response = $httpClient->post('/todos');

        $this->assertEquals(201, $response->getStatusCode());
    }

    final public function testCanRequestMultiple201Responses(): void
    {
        $this->mockClient->addResponse((new Response())->withStatus(201));
        $this->mockClient->addResponse((new Response())->withStatus(201));

        $httpClient = $this->givenSdk()->getHttpClient();

        $this->assertEquals(201, $httpClient->post('/todos')->getStatusCode());
        $this->assertEquals(201, $httpClient->post('/todos')->getStatusCode());
    }

    final public function testCanHandle404s(): void
    {
        $this->mockClient->on(new RequestMatcher('404'), (new Response())->withStatus(404));

        $httpClient = $this->givenSdk()->getHttpClient();

        $this->assertEquals(200, $httpClient->get('/todos')->getStatusCode());
        $this->assertEquals(404, $httpClient->get('/404')->getStatusCode());
        $this->assertEquals(404, $httpClient->get('/404')->getStatusCode());
        $this->assertEquals(404, $httpClient->get('/404')->getStatusCode());
    }

}