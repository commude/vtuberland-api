<?php

use App\Models\Spot;
use App\Models\Admin;
use Webpatser\Uuid\Uuid;
use App\Enums\MediaGroup;
use App\Models\Character;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Enums\Spot as SpotEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Enums\Character as CharacterEnum;
use App\Models\SpotCharacter;

class DefaultDataSeeder extends Seeder
{
    protected $email;
    protected $password;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->email = 'admin@vtuberland.co.jp';
        $this->password = 'PtUlMS7Q6u8jYHVs'; // Str::random(16);
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->generateAdminUser();

        $this->generateCharacters();

        $this->generateSpots();
    }

    /**
     * Generate Admin User.
     *
     * @return void
     */
    public function generateAdminUser()
    {
        $email = $this->email;
        $password = $this->password; //Str::random(16);

        Admin::create([
            'name' => 'vtuberland-admin',
            'email' => $email,
            'password' => $password
        ]);

        // Print admin credentials.
        $this->command->alert("ADMINISTRATOR\n\tADMIN EMAIL: {$email}\n\tADMIN PASSWORD: {$password}");
    }

    /**
     * Generate Characters.
     *
     * @return void
     */
    public function generateCharacters()
    {
        $characterList = collect(CharacterEnum::getValues())->map(function ($character) {
            return [
                'id' => mb_convert_encoding(Uuid::generate(4), 'UTF-8', 'UTF-8'),
                'name' => $character,
                'image_path' => "characters/{$character}.png",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        });

        DB::table('characters')->insert($characterList->toArray());
    }

    /**
     * Generate Spots and Associated Characters.
     *
     * @return void
     */
    public function generateSpots()
    {
        $spotList = collect(SpotEnum::getValues())->map(function ($spot) {
            return [
                'id' => mb_convert_encoding(Uuid::generate(4), 'UTF-8', 'UTF-8'),
                'name' => $spot,
                'beacon_id' => $this->getBeaconID($spot),
                'content' => $this->getSpotContent($spot),
                'image_path' => "spots/{$spot}.jpg"
            ];
        });

        $spotList->each(function ($spotDetails) {
            $spot = Spot::create($spotDetails);

            // Generate spot characters.
            $this->generateSpotCharacters($spot);
        });
    }

    /**
     * Generate Spots and Associated Characters.
     *
     * @return void
     */
    public function generateSpotCharacters($spot)
    {
        if ($spot->name == SpotEnum::AERODACTYL_CYCLE){
            $characters = Character::searchIn('name', [
                CharacterEnum::TAKAMIYA,
                CharacterEnum::RUSTARIO
            ])->get();

            $characters->each(function ($character) use ($spot) {
                // $price = '';
                // $video_url = '';
                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    // 'price' => $price,
                    // 'video_url' => $video_url,
                ]);
            });
        }

        if ($spot->name == SpotEnum::ANIMAL_RESCUE){
            $characters = Character::searchIn('name', [
                CharacterEnum::TAKAMIYA,
                CharacterEnum::HAKASE
            ])->get();

            $characters->each(function ($character) use ($spot) {
                // $price = '';
                // $video_url = '';
                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    // 'price' => $price,
                    // 'video_url' => $video_url,
                ]);
            });
        }

        if ($spot->name == SpotEnum::GO_KART){
            $characters = Character::searchIn('name', [
                CharacterEnum::RUSTARIO,
                CharacterEnum::SUZUKA
            ])->get();

            $characters->each(function ($character) use ($spot) {
                // $price = '';
                // $video_url = '';
                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    // 'price' => $price,
                    // 'video_url' => $video_url,
                ]);
            });
        }

        if ($spot->name == SpotEnum::CRAZY_HOUSTON){
            $characters = Character::searchIn('name', [
                CharacterEnum::SUZUKA,
                CharacterEnum::ARMAL
            ])->get();

            $characters->each(function ($character) use ($spot) {
                // $price = '';
                // $video_url = '';
                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    // 'price' => $price,
                    // 'video_url' => $video_url,
                ]);
            });
        }

        if ($spot->name == SpotEnum::ROOF_COASTER_MOMONGA){
            $characters = Character::searchIn('name', [
                CharacterEnum::ARMAL,
                CharacterEnum::YUMETSUKI
            ])->get();

            $characters->each(function ($character) use ($spot) {
                // $price = '';
                // $video_url = '';
                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    // 'price' => $price,
                    // 'video_url' => $video_url,
                ]);
            });
        }

        if ($spot->name == SpotEnum::HASHIBORO_GO){
            $characters = Character::searchIn('name', [
                CharacterEnum::YUMETSUKI,
                CharacterEnum::HAKASE
            ])->get();

            $characters->each(function ($character) use ($spot) {
                // $price = '';
                // $video_url = '';
                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    // 'price' => $price,
                    // 'video_url' => $video_url,
                ]);
            });
        }

        if ($spot->name == SpotEnum::FERRIS_WHEEL){
            $characters = Character::searchIn('name', [
                CharacterEnum::HAKASE,
                CharacterEnum::RUSTARIO,
                CharacterEnum::SUZUKA,
                CharacterEnum::TAKAMIYA,
                CharacterEnum::ARMAL,
                CharacterEnum::YUMETSUKI
            ])->get();

            $characters->each(function ($character) use ($spot) {
                // $price = '';
                // $video_url = '';
                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    // 'price' => $price,
                    // 'video_url' => $video_url,
                ]);
            });
        }
    }


    /**
     * Get spot image url from storage.
     *
     *@param string $character
    * @return string
    */
    public static function getSpotContent($spot)
    {
        switch ($spot) {
            case SpotEnum::ANIMAL_RESCUE:
                return 'ジープ型のライドに乗りこみ、悪いハンターたちから動物を守るシューティングライド。
                ハイスコアを目指して何度でもチャレンジしてみてください。';
            break;
            case SpotEnum::GO_KART:
                return 'フラッグストリートの周りを走る地上部分とハイウェイ部分をあわせてコースは全長約1,000m！
                起状にも富んでいて、運転しがいがあります。';
            break;
            case SpotEnum::HASHIBORO_GO:
                return '巨大な円盤が回転しながら右へ左へスイングする人気アトラクション「ディスク・オー」の超大型サイズが日本で初登場！
                アトラクションのモチーフは愛嬌ある姿と怖い顔のギャップで人気急上昇中の希少な鳥、ハシビロコウ。
                最高到達地点は15.5m、40人乗りのディスクは目が回るほどの大回転をし、風を切る絶叫爽快感をお楽しみいただけます。';
            break;
            case SpotEnum::CRAZY_HOUSTON:
                return '風を切って4Gの重力で打ち上げるクレイジーヒューと日本初のマイナス2Gの重力で一気に落下するクレージーストン。
                高さ60mのスリルとともに爽快感と浮遊感を体験してください。';
            break;
            case SpotEnum::AERODACTYL_CYCLE:
                return '空飛ぶ自転車の新人パイロットになりきって、地上約2mのレールの上を自転車型のライドで進みます。
                ライドに搭載されたスピーカーからは、先輩パイロットが下に見える「ジェラシックカー」の恐竜たちについて語りかけてくれます。';
            break;
            case SpotEnum::ROOF_COASTER_MOMONGA:
                return '高さ25mから一気に落下して宙返り！日本では初めて導入された立ったまま回転するジェットコースターです。
                立ち乗りを楽しめるのは関東ではよみうりランドだけです。';
            break;
            case SpotEnum::FERRIS_WHEEL:
                return '多摩約160mの高さから、遊園地全体はもちろん、天気のいい日には富士山や都心の高層ビル群まで一望できます。
                遊園地と言えば観覧車。お子さまからおとなの方までご乗車いただけます。';
            break;
            default:
                return null;
        }
    }

    /**
     * Get spot image url from storage.
     *
     *@param string $character
    * @return string
    */
    public static function getBeaconID($spot)
    {
        switch ($spot) {
            case SpotEnum::ANIMAL_RESCUE:
                return '11111111-1111-1111-1111-111111111111';
            break;
            case SpotEnum::GO_KART:
                return '11111111-1111-1111-1111-111111111111-1';
            break;
            case SpotEnum::HASHIBORO_GO:
                return '22222222-2222-2222-2222-222222222222';
            break;
            case SpotEnum::CRAZY_HOUSTON:
                return '11111111-1111-1111-1111-111111111111-11';
            break;
            case SpotEnum::AERODACTYL_CYCLE:
                return '11111111-1111-1111-1111-111111111111-111';
            break;
            case SpotEnum::ROOF_COASTER_MOMONGA:
                return '22222222-2222-2222-2222-222222222222-2';
            break;
            case SpotEnum::FERRIS_WHEEL:
                return '22222222-2222-2222-2222-222222222222-22';
            break;
            default:
                return null;
        }
    }
}
