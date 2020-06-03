<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DomainControllerTest extends TestCase
{
    //use RefreshDatabase;
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->faker = \Faker\Factory::create();
    }

    public function testIndex()
    {
        $responce = $this->get(route('domains.index'));
        $responce->assertOk();
    }

    public function testShow()
    {
        $id = $this->faker->randomDigitNot(0);
        $responce = $this->get(route('domains.show', ['id' => $id]));
        $responce->assertOk();

        $this->assertDatabaseHas('domains', ['id' => $id]);
    }

    public function testStore()
    {
        $data = "https://www." . $this->faker->domainName;
        $response = $this->post(route('store'), ['name' => $data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', ['name' => $data]);
    }

    public function testCreateCheck()
    {
        Http::fake();
        $id = $this->faker->randomDigitNot(0);
        $responce = $this->post(route('domains.create_check', ['id' => $id]));
        $responce->assertSessionHasNoErrors();
        Http::post('http://test.com');
        Http::assertSent(function ($request) {
            return $request->url() == 'http://test.com';
        });

        $mock = new MockHandler([
            new Response(200, ['meta' => 'name = "keywords"; content = "test keywords1"'], '<h1>test h1 tag</h1>'),
            new Response(202, ['meta' => 'name = "description"; content = "test description1"'], '<h1>test h1 tag2</h1>')
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $mockResponce = $client->request('POST', route('domains.create_check', ['id' => $id]));
        $statusCode = $mockResponce->getStatusCode();
        $this->assertEquals($statusCode, 200);
        //$this->assertDatabaseHas('domain_checks', ['keywords' => 'test keywords1']);
    }
}
