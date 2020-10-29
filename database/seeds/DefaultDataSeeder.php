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
        $this->password = '$2y$10$PKbL3XcGzZQlPKUp4sC3e.R56wHLVMZxe.jmd3N/aR3OVysoHBZoi'; // Str::random(16);
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
                'content' => $this->getCharacterDescription($character),
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
        $spotList = collect(SpotEnum::getValues())->map(function ($spot, $key) {
            return [
                'id' => mb_convert_encoding(Uuid::generate(4), 'UTF-8', 'UTF-8'),
                'name' => $spot,
                'beacon_id' => $this->getBeaconID($spot),
                'content' => $this->getSpotContent($spot),
                'image_path' => "spots/{$spot}.jpg",
                'order' => $key + 1,
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
                $price = 370;

                if($character->name == CharacterEnum::TAKAMIYA){
                    $video_url = 'spots/clips/1_1-aerodactyl_cycle-takamiya.mp4';
                }

                if($character->name == CharacterEnum::RUSTARIO){
                    $video_url = 'spots/clips/3_1-aerodactyl_cycle-rustario.mp4';
                }

                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    'price' => $price,
                    'video_url' => $video_url,
                ]);
            });
        } else if ($spot->name == SpotEnum::ANIMAL_RESCUE){
            $characters = Character::searchIn('name', [
                CharacterEnum::TAKAMIYA,
                CharacterEnum::HAKASE
            ])->get();

            $characters->each(function ($character) use ($spot) {
                $price = 370;

                if($character->name == CharacterEnum::TAKAMIYA){
                    $video_url = 'spots/clips/1_2-animal_rescue-takamiya.mp4';
                }

                if($character->name == CharacterEnum::HAKASE){
                    $video_url = 'spots/clips/4_1-animal_rescue-hakase.mp4';
                }

                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    'price' => $price,
                    'video_url' => $video_url,
                ]);
            });
        } else if ($spot->name == SpotEnum::GO_KART){
            $characters = Character::searchIn('name', [
                CharacterEnum::RUSTARIO,
                CharacterEnum::SUZUKA
            ])->get();

            $characters->each(function ($character) use ($spot) {
                $price = 370;

                if($character->name == CharacterEnum::RUSTARIO){
                    $video_url = 'spots/clips/3_2-go_kart-rustario.mp4';
                }

                if($character->name == CharacterEnum::SUZUKA){
                    $video_url = 'spots/clips/5_1-go_kart-suzuka.mp4';
                }

                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    'price' => $price,
                    'video_url' => $video_url,
                ]);
            });
        } else if ($spot->name == SpotEnum::CRAZY_HOUSTON){
            $characters = Character::searchIn('name', [
                CharacterEnum::SUZUKA,
                CharacterEnum::ARMAL
            ])->get();

            $characters->each(function ($character) use ($spot) {
                $price = 370;

                if($character->name == CharacterEnum::SUZUKA){
                    $video_url = 'spots/clips/5_2-crazy_houston-suzuka.mp4';
                }

                if($character->name == CharacterEnum::ARMAL){
                    $video_url = 'spots/clips/2_1-crazy_houston-armal.mp4';
                }

                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    'price' => $price,
                    'video_url' => $video_url,
                ]);
            });
        } else if ($spot->name == SpotEnum::ROOF_COASTER_MOMONGA){
            $characters = Character::searchIn('name', [
                CharacterEnum::ARMAL,
                CharacterEnum::YUMETSUKI
            ])->get();

            $characters->each(function ($character) use ($spot) {
                $price = 370;

                if($character->name == CharacterEnum::ARMAL){
                    $video_url = 'spots/clips/2_2-roof_coaster_MOMOnGA-armal.mp4';
                }

                if($character->name == CharacterEnum::YUMETSUKI){
                    $video_url = 'spots/clips/6_1-roof_coaster_MOMOnGA-yumetsuki.mp4';
                }

                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    'price' => $price,
                    'video_url' => $video_url,
                ]);
            });
        } else if ($spot->name == SpotEnum::HASHIBORO_GO){
            $characters = Character::searchIn('name', [
                CharacterEnum::YUMETSUKI,
                CharacterEnum::HAKASE
            ])->get();

            $characters->each(function ($character) use ($spot) {
                $price = 370;

                if($character->name == CharacterEnum::YUMETSUKI){
                    $video_url = 'spots/clips/6_2-hashiboro_go-yumetsuki.mp4';
                }

                if($character->name == CharacterEnum::HAKASE){
                    $video_url = 'spots/clips/4_2-hashiboro_go-hakase.mp4';
                }

                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    'price' => $price,
                    'video_url' => $video_url,
                ]);
            });
        } else if ($spot->name == SpotEnum::FERRIS_WHEEL){
            $characters = Character::searchIn('name', [
                CharacterEnum::HAKASE,
                CharacterEnum::RUSTARIO,
                CharacterEnum::SUZUKA,
                CharacterEnum::TAKAMIYA,
                CharacterEnum::ARMAL,
                CharacterEnum::YUMETSUKI
            ])->get();

            $characters->each(function ($character) use ($spot) {
                $price = 610;

                if($character->name == CharacterEnum::HAKASE){
                    $video_url = 'spots/clips/4_1-ferris_wheel-hakase.mp4';
                }

                if($character->name == CharacterEnum::RUSTARIO){
                    $video_url = 'spots/clips/3_3-ferris_wheel-rustario.mp4';
                }

                if($character->name == CharacterEnum::SUZUKA){
                    $video_url = 'spots/clips/5_3-ferris_wheel-suzuka.mp4';
                }

                if($character->name == CharacterEnum::TAKAMIYA){
                    $video_url = 'spots/clips/1_3-ferris_wheel-takamiya.mp4';
                }

                if($character->name == CharacterEnum::ARMAL){
                    $video_url = 'spots/clips/2_3-ferris_wheel-armal.mp4';
                }

                if($character->name == CharacterEnum::YUMETSUKI){
                    $video_url = 'spots/clips/6_3-ferris_wheel-yumetsuki.mp4';
                }

                SpotCharacter::create([
                    'spot_id' => $spot->id,
                    'character_id' => $character->id,
                    'price' => $price,
                    'video_url' => $video_url,
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
                return 'ジープ型のライドに乗りこみ、悪いハンターたちから動物を守るシューティングライド。ハイスコアを目指して何度でもチャレンジしてみてください。';
            break;
            case SpotEnum::GO_KART:
                return 'フラッグストリートの周りを走る地上部分とハイウェイ部分をあわせてコースは全長約1,000m！起状にも富んでいて、運転しがいがあります。';
            break;
            case SpotEnum::HASHIBORO_GO:
                return '巨大な円盤が回転しながら右へ左へスイングする人気アトラクション「ディスク・オー」の超大型サイズが日本で初登場！アトラクションのモチーフは愛嬌ある姿と怖い顔のギャップで人気急上昇中の希少な鳥、ハシビロコウ。最高到達地点は15.5m、40人乗りのディスクは目が回るほどの大回転をし、風を切る絶叫爽快感をお楽しみいただけます。';
            break;
            case SpotEnum::CRAZY_HOUSTON:
                return '風を切って4Gの重力で打ち上げるクレイジーヒューと日本初のマイナス2Gの重力で一気に落下するクレージーストン。高さ60mのスリルとともに爽快感と浮遊感を体験してください。';
            break;
            case SpotEnum::AERODACTYL_CYCLE:
                return '空飛ぶ自転車の新人パイロットになりきって、地上約2mのレールの上を自転車型のライドで進みます。ライドに搭載されたスピーカーからは、先輩パイロットが下に見える「ジェラシックカー」の恐竜たちについて語りかけてくれます。';
            break;
            case SpotEnum::ROOF_COASTER_MOMONGA:
                return '高さ25mから一気に落下して宙返り！日本では初めて導入された立ったまま回転するジェットコースターです。立ち乗りを楽しめるのは関東ではよみうりランドだけです。';
            break;
            case SpotEnum::FERRIS_WHEEL:
                return '多摩約160mの高さから、遊園地全体はもちろん、天気のいい日には富士山や都心の高層ビル群まで一望できます。遊園地と言えば観覧車。お子さまからおとなの方までご乗車いただけます。';
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
                return '11111111-1111-1111-1111-111111111111';
            break;
            case SpotEnum::HASHIBORO_GO:
                return '22222222-2222-2222-2222-222222222222';
            break;
            case SpotEnum::CRAZY_HOUSTON:
                return '11111111-1111-1111-1111-111111111111';
            break;
            case SpotEnum::AERODACTYL_CYCLE:
                return '11111111-1111-1111-1111-111111111111';
            break;
            case SpotEnum::ROOF_COASTER_MOMONGA:
                return '22222222-2222-2222-2222-222222222222';
            break;
            case SpotEnum::FERRIS_WHEEL:
                return '22222222-2222-2222-2222-222222222222';
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
    public static function getCharacterDescription($character)
    {
        switch ($character) {
            case CharacterEnum::ARMAL:
                return '駆け出しの魔法使い。魔法使いの世界は色々と大変らしく、その息抜きとして配信活動を行っている。';
            break;
            case CharacterEnum::RUSTARIO:
                return 'コーヴァス帝国の女騎士。目的のためなら手段を選ばない。因縁の相手を探し続けている。';
            break;
            case CharacterEnum::TAKAMIYA:
                return '魔法学校、私立帝華高校2年生17歳。政治家の娘で高飛車なツンデレタイプだが、学校では風紀委員で気さくな優等生を演じている。';
            break;
            case CharacterEnum::YUMETSUKI:
                return '人間にイタズラをするために魔界からやってきた13歳の悪魔。性格の良さゆえ結果的に人助けをして、いつも空回りしている。';
            break;
            case CharacterEnum::HAKASE:
                return '実験大好き系女子高生。常に怪しい薬品を持ち歩いている。本人曰く、どの薬にもすごい効果が込められているらしいが……。';
            break;
            case CharacterEnum::SUZUKA:
                return '画面の向こう側の世界のチビっ子たちに人気絶大のカリスマ的「うたのおねえさん」。子供向け番組で歌やことば遊びを披露。';
            break;
            default:
                return null;
        }
    }
}
