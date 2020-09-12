<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Spot;
use App\Models\User;
use App\Models\Character;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpotTest extends TestCase
{
    /**
     * Validate access to spot list.
     *
     * @return void
     */
    public function testAccessSpotList()
    {
        $response = $this->get(config('app.api_url')."/spots");

        $response->assertStatus(200);
    }

    /**
     * Validate access to view single spot.
     *
     * @return void
     */
    public function testAccessViewSpot()
    {
        $spot = Spot::get()->first();
        $spot_id = $spot->id;

        $response = $this->get(config('app.api_url')."/spots/{$spot_id}");

        $response->assertStatus(200);
    }

    /**
     * Validate access to view single spot.
     *
     * @return void
     */
    public function testAccessViewSpotCharacter()
    {
        $spot = Spot::get()->first();
        $character = Character::get()->first();
        $spot_id = $spot->id;
        $character_id = $character->id;

        $response = $this->get(config('app.api_url')."/spots/{$spot_id}/characters/{$character_id}");

        $response->assertStatus(200);
    }

    /**
     * Validate access to view single spot with authenticated user.
     *
     * @return void
     */
    public function testUserAccessViewSpot()
    {
        $user = User::get()->first();
        $spot = Spot::get()->first();
        $spot_id = $spot->id;

        $response = $this->actingAs($user)->get(config('app.api_url')."/spots/{$spot_id}");

        $response->assertStatus(200);
    }

    /**
     * Validate access to view spot character list.
     *
     * @return void
     */
    public function testAccessCharacterList()
    {
        $spot = Spot::get()->first();
        $spot_id = $spot->id;

        $response = $this->get(config('app.api_url')."/spots/{$spot_id}/characters");

        $response->assertStatus(200);
    }

    /**
     * Validate access to view spot character list with authenticated user.
     *
     * @return void
     */
    public function testUserAccessCharacterList()
    {
        $user = User::get()->first();
        $spot = Spot::get()->first();
        $spot_id = $spot->id;

        $response = $this->actingAs($user)->get(config('app.api_url')."/spots/{$spot_id}/characters");

        $response->assertStatus(200);
    }

    /**
     * Validate access to view single spot with authenticated user.
     *
     * @return void
     */
    public function testUserAccessViewSpotCharacter()
    {
        $user = User::get()->first();
        $spot = Spot::get()->first();
        $character = Character::get()->first();
        $spot_id = $spot->id;
        $character_id = $character->id;

        $response = $this->actingAs($user)->get(config('app.api_url')."/spots/{$spot_id}/characters/{$character_id}");

        $response->assertStatus(200);
    }
}
