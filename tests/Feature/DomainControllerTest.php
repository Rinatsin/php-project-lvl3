<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DomainControllerTest extends TestCase
{
    public function testIndex()
    {
        $responce = $this->get(route('domains.index'));
        $responce->assertOk();
    }

    public function testShow()
    {
        $faker = \Faker\Factory::create();
        $id = $faker->randomDigitNot(0);
        $responce = $this->get(route('domains.show', ['id' => $id]));
        $responce->assertOk();
    }

    public function testStore()
    {
        $faker = \Faker\Factory::create();
        $data = $faker->url;
        $response = $this->post(route('store'), [$data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', [$data]);
    }
}
