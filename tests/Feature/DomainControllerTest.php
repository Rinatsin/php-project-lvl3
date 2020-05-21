<?php

namespace Tests\Feature;

use Tests\TestCase;

class DomainControllerTest extends TestCase
{
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
        $id = $this->faker->randomDigitNot(0);
        var_dump($id);
        $responce = $this->get(route('domains.show', ['id' => $id]));
        $responce->assertOk();
    }

    public function testStore()
    {
        $data = $this->faker->url;
        $response = $this->post(route('store'), ['name' => $data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', ['name' => $data]);
    }
}
