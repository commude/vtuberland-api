<?php

use App\Models\Spot;
use App\Models\User;
use App\Enums\Status;
use App\Models\Purchase;
use App\Models\Character;
use Faker\Factory  as Faker;
use App\Models\SpotCharacter;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\UserSpotCharacter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->generateCharacters();

        $this->generateSpots();

        $this->generateSpotCharacters();

        $this->generateDefaultUserPurchases();

        $this->generateUserPurchases();
    }

    /**
     * Generate characters.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateCharacters()
    {
        $characterList = new Collection([
            'cat' => Storage::url('characters/001-cat.png'),
            'horse' => Storage::url('characters/002-horse.png'),
            'gorilla' => Storage::url('characters/003-gorilla.png'),
            'snake' => Storage::url('characters/004-snake.png'),
            'toucan' => Storage::url('characters/005-toucan.png'),
            'jaguar' => Storage::url('characters/006-jaguar.png'),
            'frog' => Storage::url('characters/007-frog.png'),
            'lion' => Storage::url('characters/008-lion.png'),
            'antilope' => Storage::url('characters/009-antilope.png'),
            'elephant' => Storage::url('characters/010-elephant.png')
        ]);

        $characterList->each(function($value, $key) {
            factory(Character::class, 1)->create(['name' => $key, 'image_url' => $value]);
        });
    }

    /**
     * Generate spots.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateSpots()
    {
        $spotList = new Collection([
            'Carousel' => Storage::url('spots/carousel.jpg'),
            'Ferris Wheel' => Storage::url('spots/ferriswheel.jpg'),
            'Jungle Log Jam' => Storage::url('spots/logjam.jpg'),
            'Roller Coaster' => Storage::url('spots/rollercoaster.jpg'),
            'Roller Coaster Xtreme' => Storage::url('spots/rollercoasterextreme.jpg'),
        ]);

        $spotList->each(function ($value, $key) {
            factory(Spot::class,1)->create(['name' => $key, 'image_url' => $value]);
        });
    }

    /**
     * Generate characters in each spots.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateSpotCharacters()
    {
        $characters = Character::all();
        $spots = Spot::all();

        // randomizede video urls.
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

    /**
     * Generate spots.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateUserPurchases()
    {
        factory(User::class, 5)->create()->each(function($user) {
            $faker = Faker::create();
            $spotCharacters = SpotCharacter::all()->random($faker->numberBetween(10,15));

            $transactions = $spotCharacters->map(function($spotCharacter) use ($user) {
                return [
                    'user_id' => $user->id,
                    'status' => Status::OK,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            });

            Purchase::insert($transactions->toArray());

            // Insert to User Spot Characters
            $spotCharacters->each(function($spotCharacter) use ($user) {
                UserSpotCharacter::create(                [
                    'user_id' => $user->id,
                    'spot_id' => $spotCharacter->spot_id,
                    'character_id' => $spotCharacter->character_id
                ]);
            });
        });
    }

    /**
     * Generate spots.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateDefaultUserPurchases()
    {
        $faker = Faker::create();
        $user = User::first();
        $spotCharacters = SpotCharacter::all()->random($faker->numberBetween(10,15));

        $transactions = $spotCharacters->map(function($spotCharacter) use ($user, $faker) {
            $date = Carbon::now()->subDays($faker->numberBetween(1,30));
            return [
                'user_id' => $user->id,
                'status' => Status::OK,
                'created_at' => $date,
                'updated_at' => $date
            ];
        });

        Purchase::insert($transactions->toArray());

        // Insert to User Spot Characters
        $spotCharacters->each(function($spotCharacter) use ($user, $faker) {
            $date = Carbon::now()->subDays($faker->numberBetween(1,30));
            UserSpotCharacter::create(                [
                'user_id' => $user->id,
                'spot_id' => $spotCharacter->spot_id,
                'character_id' => $spotCharacter->character_id,
                'expired_at' => Carbon::now()->addMonth(),
                'created_at' => $date,
                'updated_at' => $date
            ]);
        });
    }
}
