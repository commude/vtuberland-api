<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\StreamOutput;
use App\Console\Commands\GenerateAccessTokenCommand;
use App\Models\Admin;
use Symfony\Component\Console\Output\BufferedOutput;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appName = config('app.name');
        $this->generateAppUser($appName);
        $this->generateAdminUser();
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

    /**
     * Generate Application User.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateAppUser($appName)
    {
        $username = 'vtuberland-app-user';
        $password = Str::random(16);

        $user = User::create([
            'name' => 'vtuberland-app-user',
            'username' => $username,
            'is_valid' => true,
            'password' => bcrypt($password)
        ]);

        $userID = $user->id;

        // Call the command to generate access client.
        Artisan::call("passport:client --password --user_id={$userID} --name='{$appName} Password Grant Client' --provider=users;", [], new BufferedOutput);

        // Get Client ID and Secret from the command's output.
        $result = str_replace('"', '', Artisan::output());
        $result = explode(',', str_replace("\r\n", ',', $result));
        $clientID = substr($result[1], strpos($result[1], ": ") + 2);
        $clientSecret = substr($result[2], strpos($result[2], ": ") + 2);

        // Update environment variables.
        $this->putPermanentEnv('PASSPORT_PERSONAL_ACCESS_CLIENT_ID', config('passport.personal_access_client.id'), $clientID);
        $this->putPermanentEnv('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET', config('passport.personal_access_client.secret'), $clientSecret);

        // Refresh configuration cache.
        Artisan::call('config:cache');

        // Output the username and password of the created user.
        $this->command->alert("APPLICATION USER\n\tAPP USER ID: {$userID}\n\tAPP USER USERNAME: {$username}\n\tAPP USER PASSWORD: {$password}\n\tAPP USER ACCESS ID: {$clientID}\n\tAPP USER ACCESS SECRET: {$clientSecret}");
    }

    /**
     * Generate Admin User.
     *
     * @param string $appName
     *
     * @return void
     */
    public function generateAdminUser()
    {
        $username = 'vtuberland-admin-user';
        $password = Str::random(16);

        Admin::create([
            'name' => 'vtuberland-admin',
            'username' => $username,
            'password' => bcrypt($password)
        ]);

        // Output the username and password of the created user.
        $this->command->alert("ADMINISTRATOR \n\tADMIN USERNAME: {$username}\n\tADMIN PASSWORD: {$password}");
    }
}
