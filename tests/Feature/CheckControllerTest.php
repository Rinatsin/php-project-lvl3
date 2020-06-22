<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckControllerTest extends TestCase
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = \Faker\Factory::create();
        $this->seed();
    }

    public function testStore()
    {
        $data = file_get_contents(__DIR__ . "/fixtures/test.html");
        $name = "https://www.google.ru/";

        Http::fake([
            $name => Http::response($data, 203)
        ]);
        $this->post(route('domains.store'), ['name' => $name]);

        $urlNormalizer = new \URL\Normalizer($name);
        $normalizedData = $urlNormalizer->normalize();
        $domain = DB::table('domains')
                    ->where('name', $normalizedData)
                    ->first();

        $id = $domain->id;
        $response = $this->post(route('checks.store', ['id' => $id]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('domain_checks', ['status_code' => 203]);
    }
}
