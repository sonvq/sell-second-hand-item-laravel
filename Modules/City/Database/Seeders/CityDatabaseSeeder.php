<?php

namespace Modules\City\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Modules\Country\Entities\Country;
use DB;

class CityDatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();


        // $this->call("OthersTableSeeder");
        /*
         * Insert cities for Myanmar
         */
        $listCityMyanmar = [
            'Myitkyina', 
            'Bhamo (Bamaw)',
            'Bharma',
            'Chipwi (Chibwe)',
            'Hpakant (Hpakan, Farkent)',
            'Hopin (Hobik)',
            'Hsinbo (Sinbo)',
            'Hsawlaw (Sawlaw)',
            'Injangyang',
            'Kamaing (Kamine)',
            'Kawnglanghpu (Kaunglanfu)',
            'Lweje (Loije, Lwalgyai)',
            'Machanbaw',
            'Mansi',
            'Momauk',
            'Moekaung',
            'Mohnyin',
            'Nogmung (Naungmoon)',
            'Pannandin',
            'Putao',
            'Shwegu',
            'Sumprabum',
            'Tanai (Tanain)',
            'Tsawlaw (Sawlaw)',
            'Waingmaw',
            'Ywathit',
            'Loikaw',
            'Demawso',
            'Pruhso',
            'Shadaw',
            'Bawlakhe',
            'Hpasawng',
            'Maisal',
            'Hpa-an',
            'Hlaingbwe (Hlinebwe)',
            'Papun (Phapun)',
            'Thandang',
            'Thandanggyi (Thantaunggyi)',
            'Myawaddy (Myawadi)',
            'Kawkareik (Kawkareit)',
            'Kyeikdon',
            'Kyain Seikgyi (Kyainseikkyi)',
            'Payathonsu (Hpayarthonesu)',
            'Tedim',
            'Tonzang',
            'Falam (Phalam)',
            'Hakha (Haka, Harkhar)',
            'Thantlang (Htantlang)',
            'Kanpetlet (Kanpatlat)',
            'Matupi (Matupe)',
            'Mindat (Minthet)',
            'Paletwa',
            'Cikha',
            'Rih Khawdar',
            'Razua (Yay Zwar)',
            'Sami (Samee)',
            'Mawlamyaing(Moulmein)',
            'Bilin',
            'Kyaikmaraw',
            'Chaungzon',
            'Thanbyuzayat',
            'Kyaikkami',
            'Mudon',
            'Ye',
            'Thaton',
            'Paung',
            'Kyaikto',
            'Mottama',
            'Sittwe (capital)',
            'Ann',
            'Buthidaung',
            'Dalet (Dalat)',
            'Gwa',
            'Kyaukpyu',
            'Kyauktaw',
            'Kyeintali',
            'Manaung',
            'Maungdaw',
            'Minbya',
            'Mrauk U',
            'Myebon',
            'Ngapali',
            'Pauktaw',
            'Ponnagyun',
            'Ramree',
            'Rathedaung',
            'Thandwe',
            'Toungup',
            'Aungban',
            'Ayetharyar',
            'Chinshwehaw',
            'Ho-pin',
            'Hopang',
            'Hopong',
            'Hseni',
            'Hsi Hseng',
            'Hsipaw',
            'Kalaw',
            'Kengtong',
            'Kunhing',
            'Kunlong',
            'Kutkai',
            'Kyaukme',
            'Kyethi',
            'Lai-Hka',
            'Langkho',
            'Lashio',
            'Lawksawk',
            'Loilen',
            'Laukkaing',
            'Mabein',
            'Mantong',
            'Mawkmai',
            'Mine Hpayak',
            'Mine Hsu',
            'Mine Khet',
            'Mine Kung',
            'Mine Nai',
            'Mine Pan',
            'Mine Ping',
            'Mine Tong',
            'Mine Yang',
            'Mine Yawng',
            'Mine Hsat',
            'Mineko',
            'Minemit',
            'Mineyai',
            'Mu Se',
            'Namhsan',
            'Namtu',
            'Nanhkan',
            'Nansang',
            'Nawnghkio',
            'Nyaungshwe',
            'Pang Long',
            'Pekon',
            'Pindaya',
            'Pinlaung',
            'Tant Yan',
            'Taunggyi',
            'Techilelk',
            'Ywangan',
            'Ayadaw',
            'Banmauk',
            'Budalin',
            'Chaung-U',
            'Dabayin',
            'Hkamti',
            'Homalin',
            'Htigyaing',
            'Indaw',
            'Kalaymyo',
            'Kalewa',
            'Kanbalu',
            'Kani',
            'Katha',
            'Kawlin',
            'Khin U',
            'Kyadet',
            'Kyunhla',
            'Mawlaik',
            'Mingun',
            'Monywa',
            'Myaung',
            'Myinmu',
            'Pale',
            'Paungbyin',
            'Pinlebu',
            'Sagaing',
            'Salingyi',
            'Shwebo',
            'Tamu',
            'Tantsal',
            'Wetlet',
            'Wuntho',
            'Ye-U',
            'Yinmabin',
            'Mungnii',
            'Dawei',
            'Launglon',
            'Thayetchaung',
            'Yebyu',
            'Myeik',
            'Kyunsu',
            'Palaw',
            'Taninthayi',
            'Kawthoung',
            'Bokpyin',
            'Bago',
            'Thanatpin',
            'Kawa',
            'Waw',
            'Nyaunglebin',
            'Madauk',
            'Pyuntaza',
            'Kyauktaga',
            'Pennwegone',
            'Daik-U',
            'Shwegyin',
            'Taungoo',
            'Kututmatyi',
            'Yaytarshay',
            'Kyaukkyi',
            'Phyu',
            'Oktwin',
            'Htantabin',
            'Pyay (formerly Prome)',
            'Paukkhaung',
            'Padaung',
            'Paungde',
            'Thegon',
            'Shwedaung',
            'Thayarwaddy',
            'Thonze',
            'Letpadan',
            'Minhla',
            'Okpo',
            'Zigon',
            'Nattalin',
            'Monyo',
            'Gyobingauk',
            'Magwe (capital)',
            'Allanmyo (Aunglan, Myaydo)',
            'Chauck',
            'Gangaw',
            'Kamma',
            'Minbu',
            'Mindon',
            'Minhla',
            'Myaing',
            'Myothit',
            'Natmauk',
            'Ngape',
            'Pakokku',
            'Pauk',
            'Pwintbyu',
            'Sagu',
            'Salin',
            'Swar',
            'Seikphyu',
            'Sidoktaya',
            'Sinbyugyun',
            'Taungdwingyi',
            'Thayet (Thayetmyo)',
            'Tilin',
            'Yenangyaung',
            'Yesagyo',
            'Htaukkyant',
            'Hmawbi',
            'Hlegu',
            'Taikgyi',
            'Okkan',
            'Apyauk',
            'Htantabin',
            'Shwepyaytha',
            'Hlaing Tharyar',
            'Dagon Myothit',
            'Dagon Myothit',
            'Thanlyin',
            'Kyauktan',
            'Thonegwa',
            'Kha yan',
            'Twante',
            'Kawthmu',
            'Kungyangon',
            'Coco Island',
            'Yangon (formerly Rangoon)',
            'Insein',
            'Thingangyun',
            'Tamwe',
            'Botahtaung',
            'Pathein(Basein)',
            'Kangyidaut',
            'Thabaung',
            'Ngapudaw',
            'Haigyi Island',
            'Kyonpyaw',
            'Yekyi',
            'Kyaunggon',
            'Hinthada',
            'Zalun',
            'Lemyethna',
            'Myan Aung',
            'Kanaung',
            'Kyangin',
            'Ingapu',
            'Myaungmya',
            'Einme',
            'Letputta',
            'Wakema',
            'Mawlamyinegyun',
            'Maubin',
            'Pantanaw',
            'Nyaungdon',
            'Danubyu',
            'Pyapon',
            'Bogale',
            'Kyaiklat',
            'Dedaye',
            'Patheingyi',
            'Kyautpandaung',
            'Thaungtha',
            'Mahlaing',
            'Meikhtila',
            'Wundwin',
            'Yemethin',
            'Thazi',
            'Myingyan',
            'Nwarhtoegyi',
            'Myittha',
            'Pyawbwe',
            'Pyinoolwin',
            'Mogok',
            'Chanmyaetharzan',
            'Mahaaungmyay',
            'Chanmyathazi',
            'Pyigyitakhun',
            'Amarapura',
            'Kyaukse',
            'Aungmyaythazan',
            'Madaya',
            'Singu',
            'Thabeikkyin',
            'Sintgaing',
            'Tada U',
            'Nganzun',
            'Pyinmana',
            'Tatkon',
            'Lewe',
            'Ottarathiri',
            'Dekkhinathiri',
            'Pobbathiri',
            'Zabuthiri',
            'Zeyathiri',
            'Leshi',
            'Lahe',
            'Nanyun'
        ];
        $arrayAllCitiesMyanmar = [];
        $myanmarCountry = Country::where('name', 'Myanmar')->first();
        if ($myanmarCountry) {
            foreach($listCityMyanmar as $singleCity) {
                $arraySingleCityMyanmar = [
                    'name' => $singleCity,
                    'country_id' => $myanmarCountry->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $arrayAllCitiesMyanmar[] = $arraySingleCityMyanmar;
            }
            DB::table('city__cities')->insert($arrayAllCitiesMyanmar);
        }
        
        /*
         * Insert cities for Singapore
         */
        $singaporeCountry = Country::where('name', 'Singapore')->first();
        if($singaporeCountry) {
            DB::table('city__cities')->insert([
                'name' => 'Singapore',
                'country_id' => $singaporeCountry->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        
        /*
         * Insert cities for China
         */
        $listCityChina = [
            'Shanghai',
            'Beijing',
            'Hongkong',
            'Kunming',
        ];
        $arrayAllCitiesChina = [];
        $chinaCountry = Country::where('name', 'China')->first();
        if ($chinaCountry) {
            foreach($listCityChina as $singleCity) {
                $arraySingleCityChina = [
                    'name' => $singleCity,
                    'country_id' => $chinaCountry->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $arrayAllCitiesChina[] = $arraySingleCityChina;
            }
            DB::table('city__cities')->insert($arrayAllCitiesChina);
        }
        
        /*
         * Insert cities for Vietnam
         */
        $listCityVietnam = [
            'Ho Chi Minh City',  
            'Hanoi',
            'Da Nang',
            'Nha Trang',
            'Bien Hoa',
            'Can Tho',
            'Hai Phong',
        ];
        $arrayAllCitiesVietnam = [];
        $vietnamCountry = Country::where('name', 'Vietnam')->first();
        if ($vietnamCountry) {
            foreach($listCityVietnam as $singleCity) {
                $arraySingleCityVietnam = [
                    'name' => $singleCity,
                    'country_id' => $vietnamCountry->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $arrayAllCitiesVietnam[] = $arraySingleCityVietnam;
            }
            DB::table('city__cities')->insert($arrayAllCitiesVietnam);
        }
        
        /*
         * Insert cities for Thailand
         */
        $listCityThailand = [
            'Bangkok',
            'Chiang Mai',
            'Chiang Rai',
            'Phuket',
            'Hat Yai'
        ];
        
        $arrayAllCitiesThailand = [];
        $thailandCountry = Country::where('name', 'Thailand')->first();
        if ($thailandCountry) {
            foreach($listCityThailand as $singleCity) {
                $arraySingleCityThailand = [
                    'name' => $singleCity,
                    'country_id' => $thailandCountry->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $arrayAllCitiesThailand[] = $arraySingleCityThailand;
            }
            DB::table('city__cities')->insert($arrayAllCitiesThailand);
        }
                
    }

}
