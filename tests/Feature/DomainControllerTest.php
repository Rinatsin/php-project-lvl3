<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DomainControllerTest extends TestCase
{
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
        //$responce->assertRedirect();
        //$this->assertDatabaseHas('domain_checks', ['domain_id' => $id]);
        Http::post('http://test.com');
        Http::assertSent(function ($request) {
            return $request->url() == 'http://test.com';
        });
    }
}
