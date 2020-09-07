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
            DefaultDataSeeder::class // Should execute last.
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
        $result = str_replace('"', '', Artisan::output());
        $result = explode(',', str_replace("\r\n", ',', $result));
        $personalClientID = substr($result[2], strpos($result[2], ": ") + 2);
        $personalClientSecret = substr($result[3], strpos($result[3], ": ") + 2);
        $passwordClientID = substr($result[5], strpos($result[5], ": ") + 2);
        $passwordClientSecret = substr($result[6], strpos($result[6], ": ") + 2);

        // Print Access Keys
        $this->command->alert("PERSONAL ACCESS CLIENT\n\tCLIENT ID: {$personalClientID}\n\tCLIENT SECRET: {$personalClientSecret}");
        $this->command->alert("PASSWORD GRANT CLIENT\n\tCLIENT ID: {$passwordClientID}\n\tCLIENT SECRET: {$passwordClientSecret}");
    }
}
