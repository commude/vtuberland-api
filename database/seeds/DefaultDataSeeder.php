<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\StreamOutput;
use App\Console\Commands\GenerateAccessTokenCommand;
use App\Enums\OperatingSystem;
use App\Models\Admin;
use Faker\Factory  as Faker;
use App\Models\Character;
use Symfony\Component\Console\Output\BufferedOutput;

class DefaultDataSeeder extends Seeder
{
    protected $appName;

    // /**
    //  * Create a new seeder instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->appName = config('app.name');
    // }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->generateAppUser();
        $this->generateAdminUser();
        $this->generateSpots();
        $this->generateCharacters();
    }

    /**
     * Generate Application User.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateAppUser()
    {
        $faker = Faker::create();
        // $username = 'vtuberland-app-user';
        $email = 'user@vtuberland.co.jp';
        $password = 'Pg9NQdA8iw5YMFSL';// Str::random(16);
        $device_uuid = $faker->uuid();

        $user = User::create([
            'name' => 'vtuberland-app-user',
            'password' => $password,
            'email' => $email,
            'manufacturer' => 'Apple',
            'os' => OperatingSystem::IOS,
            'is_valid' => true,
            'password' => $password,
            'device_uuid' => $device_uuid
        ]);

        $userID = $user->id;

        // Print default user credentials.
        $this->command->alert("APPLICATION USER\n\tAPP USER ID: {$userID}\n\tAPP USER EMAIL: {$email}\n\tAPP USER PASSWORD: {$password}\n\tDEVICE TOKEN: {$device_uuid}");
        // $this->command->alert("APPLICATION USER\n\tAPP USER ID: {$userID}\n\tAPP USER EMAIL: {$email}\n\tDEVICE TOKEN: {$deviceToken}");

        // // Call the command to generate access client.
        // Artisan::call("passport:client --password --user_id={$userID} --name='{$appName} Password Grant Client' --provider=users", [], new BufferedOutput);

        // // Get Client ID and Secret from the command's output.
        // $result = str_replace('"', '', Artisan::output());
        // $result = explode(',', str_replace("\r\n", ',', $result));
        // $clientID = substr($result[1], strpos($result[1], ": ") + 2);
        // $clientSecret = substr($result[2], strpos($result[2], ": ") + 2);

        // // Update environment variables.
        // $this->putPermanentEnv('PASSPORT_PERSONAL_ACCESS_CLIENT_ID', config('passport.personal_access_client.id'), $clientID);
        // $this->putPermanentEnv('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET', config('passport.personal_access_client.secret'), $clientSecret);

        // // Refresh configuration cache.
        // Artisan::call('config:cache');

        // // Output the username and password of the created user.
        // $this->command->alert("APPLICATION USER\n\tAPP USER ID: {$userID}\n\tAPP USER USERNAME: {$username}\n\tAPP USER PASSWORD: {$password}\n\tAPP USER ACCESS ID: {$clientID}\n\tAPP USER ACCESS SECRET: {$clientSecret}");
    }

    /**
     * Generate Admin User.
     *
     * @return void
     */
    public function generateAdminUser()
    {
        $email = 'admin@vtuberland.co.jp';
        $password = 'PtUlMS7Q6u8jYHVs'; //Str::random(16);

        Admin::create([
            'name' => 'vtuberland-admin',
            'email' => $email,
            'password' => $password
        ]);

        // Print admin credentials.
        $this->command->alert("ADMINISTRATOR\n\tADMIN EMAIL: {$email}\n\tADMIN PASSWORD: {$password}");
    }

    /**
     * Generate Applications.
     *
     * @return void
     */
    public function generateSpots()
    {
    }

    /**
     * Generate Characters.
     *
     * @return void
     */
    public function generateCharacters()
    {
    }

    /**
     * Set Environment Variables in file.
     *
     * @param string $key
     * @param string $oldValue
     * @param string $value
     *
     * @return void
     */
    public function putPermanentEnv($key, $oldValue, $value)
    {
        // Get env file path.
        $path = app()->environmentFilePath();

        // Replace the old value to new value.
        $escaped = preg_quote('='.env($key), '/');
        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}{$oldValue}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}
