<?php

namespace Tests\Feature;

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
        $this->faker = \Faker\Factory::create();
        $this->seed();
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
        $response = $this->post(route('domains.store'), ['name' => $data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $urlNormalizer = new \URL\Normalizer($data);
        $normalizedData = $urlNormalizer->normalize();
        $this->assertDatabaseHas('domains', ['name' => $normalizedData]);
    }
}
