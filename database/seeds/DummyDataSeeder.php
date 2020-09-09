<?php

use App\Models\Character;
use App\Models\Spot;
use Illuminate\Database\Seeder;
use App\Models\SpotCharacter;
use Illuminate\Database\Eloquent\Collection;
use Faker\Factory  as Faker;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $characterList = new Collection([
            'cat' => asset('images/characters/001-cat.png'),
            'horse' => asset('images/characters/002-horse.png'),
            'gorilla' => asset('images/characters/003-gorilla.png'),
            'snake' => asset('images/characters/004-snake.png'),
            'toucan' => asset('images/characters/005-toucan.png'),
            'jaguar' => asset('images/characters/006-jaguar.png'),
            'frog' => asset('images/characters/007-frog.png'),
            'lion' => asset('images/characters/008-lion.png'),
            'antilope' => asset('images/characters/antilope.png'),
            'elephant' => asset('images/characters/elephant.png')
        ]);

        $spotList = new Collection([
            'ferriswheel' => [
                'image_url' => asset('images/spots/ferriswheel.jpg'),
                'video_url' => 'https://www.youtube.com/watch?v=a6Zz0gBZMiE'
            ],
            'logjump' => [
                'image_url' => asset('images/spots/logjump.jpg'),
                'video_url' => 'https://www.youtube.com/watch?v=zDqdmidgQHo',
            ],
            'rollercoaster' => [
                'image_url' => asset('images/spots/rollercoaster.jpg'),
                'video_url' => 'https://www.youtube.com/watch?v=aE_wqPr78VU',
            ],
            'rollerskater' =>[
                'image_url' => asset('images/spots/rollerskater.jpg'),
                'video_url' => 'https://www.youtube.com/watch?v=BjWL3zErvv4',
            ],
            'rollerspiral' => [
                'image_url' => asset('images/spots/rollerspiral.jpg'),
                'video_url' => 'https://www.youtube.com/watch?v=8YiWzYsBf4g'
            ]
        ]);

        $characterList->each(function($value, $key) {
            factory(Character::class, 1)->create(['name' => $key, 'image_url' => $value]);
        });

        $spotList->each(function ($value, $key) {
            factory(Spot::class,1)->create(['name' => $key, 'image_url' => $value['image_url']]);
        });

        Spot::all()->each(function($spot) use ($spotList){
            Character::all()->each(function ($character) use ($spot, $spotList) {
                $spotList->each(function($value, $key) use ($character, $spot) {
                    SpotCharacter::create([
                        'spot_id' => $spot->id,
                        'character_id' => $character->id,
                        'video_url' => $value['video_url'],
                    ]);
                });
            });
        });
    }
}
