<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DefaultDataSeeder::class,
            // DummyDataSeeder::class,
        ]);

        $this->generateApiPassport();

    }

    /**
     * Generate Api Passport.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateApiPassport()
    {
        Artisan::call('passport:install');
        $this->command->alert('PASSPORT HAS BEEN SUCCESSFULLY INSTALLED');
    }
}
