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
        // Characters
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

        $characterList->each(function($value, $key) {
            factory(Character::class, 1)->create(['name' => $key, 'image_url' => $value]);
        });

        // Spots
        $spotList = new Collection([
            'Carousel' => asset('images/spots/carousel.jpg'),
            'Ferris Wheel' => asset('images/spots/ferriswheel.jpg'),
            'Jungle Log Jam' => asset('images/spots/logjump.jpg'),
            'Roller Coaster' => asset('images/spots/rollercoaster.jpg'),
            'Roller Coaster Xtreme' => asset('images/spots/rollercoasterextreme.jpg'),
        ]);

        $spotList->each(function ($value, $key) {
            factory(Spot::class,1)->create(['name' => $key, 'image_url' => $value]);
        });

        // Spot Characters
        $characters = Character::all();
        $spots = Spot::all();
        $video_urls = new Collection([
            'https://youtu.be/EngW7tLk6R8',
            'https://youtu.be/xcJtL7QggTI',
            'https://youtu.be/WjoplqS1u18',
            'https://youtu.be/BdzZDs6PiJ4',
            'https://youtu.be/rFdonlDSY8E',
            'https://youtu.be/v3dclL2grbs',
            'https://youtu.be/zjixgch1fIE',
            'https://youtu.be/EUX6lXTX9zQ'
        ]);

        $spots->each(function ($spot) use ($characters, $video_urls){
            $characters->each(function ($character) use ($spot, $video_urls){
                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    'video_url' => $video_urls->random(),
                ]);
            });
        });
    }
}
