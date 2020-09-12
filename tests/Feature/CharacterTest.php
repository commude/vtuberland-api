<?php

namespace Tests\Feature;

use App\Models\Character;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CharacterTest extends TestCase
{
    /**
     * Validate access to spot list.
     *
     * @return void
     */
    public function testAccessCharacterList()
    {
        $response = $this->get(config('app.api_url')."/characters");

        $response->assertStatus(200);
    }

    /**
     * Validate access to view the list of characters with authenticated user.
     *
     * @return void
     */
    public function testUserAccessCharacterList()
    {
        $user = User::get()->first();

        $response = $this
            ->actingAs($user)
            ->get(config('app.api_url')."/characters");

        $response->assertStatus(200);
    }

    /**
     * Validate access to view character.
     *
     * @return void
     */
    public function testViewCharacter()
    {
        $user = User::get()->first();
        $character = Character::get()->first();
        $character_id = $character->id;

        $response = $this
            ->actingAs($user)
            ->get(config('app.api_url')."/characters/{$character_id}");

        $response->assertStatus(200);
    }
}
