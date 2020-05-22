<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->assertDatabaseHas('domains', ['id' => $id]);
        $responce = $this->get(route('domains.show', ['id' => $id]));
        $responce->assertOk();
    }

    public function testStore()
    {
        $data = "https://www.". $this->faker->domainName;
        $response = $this->post(route('store'), ['name' => $data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', ['name' => $data]);
    }
}
