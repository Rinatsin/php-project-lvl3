<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DomainControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = \Faker\Factory::create();
    }

    public function testIndex()
    {
        $responce = $this->get(route('domains.index'));
        $responce->assertOk();
    }

    public function testShow()
    {
        $this->seed();
        $id = $this->faker->randomDigitNot(0);
        $responce = $this->get(route('domains.show', ['id' => $id]));
        $responce->assertOk();

        $this->assertDatabaseHas('domains', ['id' => $id]);
    }

    public function testStore()
    {
        $data = "https://www." . $this->faker->domainName;
        $response = $this->post(route('domains.store'), ['name' => $data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $urlNormalizer = new \URL\Normalizer($data);
        $normalizedData = $urlNormalizer->normalize();
        $this->assertDatabaseHas('domains', ['name' => $normalizedData]);
    }

    public function testCreateCheck()
    {
        Http::fake();

        $id = $this->faker->randomDigitNot(0);
        Http::withHeaders(
            ['name' => "description", 'content' => 'test description'],
            ['name' => "keywords", 'content' => 'test keywords']
        )->post(route('domains.create_check', ['id' => $id]));

        Http::assertSent(function ($request) use ($id) {
            return $request->hasHeader('name', 'description') &&
                    $request->url() == route('domains.create_check', ['id' => $id]);
        });
        //$this->assertDatabaseHas('domain_checks', ['keywords' => 'test keywords']);
    }
}
