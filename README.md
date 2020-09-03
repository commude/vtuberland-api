## About VTuberland

### System Specifications

| Requirements | Versions |
| :----------: | :------: |
|   LARAVEL    |   7.x    |
|     PHP      |  ^7.3.21 |
|    MYSQL     |   ^5.7   |

## Configuration

1.  Clone this repository.

    ```bash
        $   git clone https://github.com/commude/vtuberland-api.git
    ```

2.  Recreate environment variable file.

    ```bash
        $   cp .env.example .env
    ```

    -   To create the environment variable file for testing **_(optional)_**

    ```bash
        $   cp .env .env.testing
    ```

3.  Install composer

    ```bash
        $   composer install
    ```

4.  Generate Application Key

    ```bash
        $   php artisan key:generate
    ```

5.  Execute Database Migration and Seeders

    ```bash
        $   php artisan migrate --seed
    ```

7.  Create a symlink for Storage in Public Directory

    ```bash
        $   php artisan storage:link
    ```

8.  Initiate laravel passport (Execute 1 time only)

    ```bash
        $   php artisan passport:install
    ```

9.  Use the Default Key of `Password Grant Client` from the database and store the key in the variables inside the `.env` file (Perform this if database is empty or has been cleared)

    ```env
        PASSPORT_CLIENT_ID=2
        PASSPORT_CLIENT_SECRET=iI4U5s19mpZZ00S2gODLtBKxSWO7j3D4xpqsEzQV
    ```

## Development

### Backend Development

1.  Observe Model-View-Controller (MVC) Design Pattern.

2.  Models should store to this path `app\models`.

3.  DB Migration names should starts with [Action]. Make it readable at all times.

    ```
    2014_10_12_000000_create_users_table
    2014_10_12_000000_alter_users_table_add_hobbies_column
    2014_10_12_000000_alter_users_table_remove_motto_column
    2014_10_12_000000_alter_users_table_update_motto_column_to_longText
    2014_10_12_000000_alter_users_table_update_age_column_to_integer
    2014_10_12_000000_alter_users_table_add_sex_default_male
    2014_10_12_000000_alter_users_table_add_index_keys
    2014_10_12_000000_alter_users_table_add_foreign_key_to_tasks_table
    ```

4.  Add comment headers on every functions.

    ```php
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @param  string|null  $guard
         * @return mixed
         */
        public function handle($request, Closure $next, $guard = null)
        {
            ...
                code goes here ...
            ...

            retrun $next($request);
        }
    ```

## Deployment

|              Develop               | Staging | Production |
| :--------------------------------: | :-----: | :--------: |
| [dev](http://vtuberland.commude.biz/) | -soon-  |   -soon-   |

### Post Deployment

1.  Execute this for Composer can quickly find the proper file to load for a given class.

    ```php
            $   composer install --optimize-autoloader --no-dev
    ```

2.  Execute this command generates the encryption keys Passport needs in order to generate access token.

    ```php
            $   php artisan passport:keys
    ```

3.  You you may publish Passport's configuration file to provide the option to load the encryption keys from your environment variables.

    ```php
            $   php artisan vendor:publish --tag=passport-config
    ```

4.  Execute this command reduces all of your route registrations into a single method call within a cached file, improving the performance of route registration when registering hundreds of routes.

    ```php
            $   php artisan config:cache
    ```

5.  Execute this command to clear the cache views.

    ```php
            $   php artisan view:cache
    ```

## Branching and Versioning

1.  Snake Case is the naming convention for branching.

    > Make sure the changes are relevant with the codes.

    | Issue Number |          Phrase          |    Expected Branch Name     |
    | :----------: | :----------------------: | :-------------------------: |
    |      1       |    create login page     |    #1_create_login_page     |
    |      2       | create user landing page | #2_create_user_landing_page |

2)  Commit Messages Convention.

    > Make the first sentence is the summary of your commit.

    > Make sure the changes are relevant with the codes.

    ```
    Slight modifications on the users table.
    [add] Condition to fetch user by email
    [delete] Condition to fetch user by name
    [update] Add [hobbies - longText] field in user table
    [enhance] Add Logic that can accept dynamic fields
    ```
