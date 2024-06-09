<?php

namespace Database\Seeders;

use App\Models\Dictionaries\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
//        /***  Russian  (taken from https://ru.wikipedia.org/wiki/ISO_3166-1_numeric)***/
    private $countries = array(
        'Афганистан',
        'Албания',
        'Антарктика',
        'Алжир',
        'Андора',
        'Ангола',
        'Азербайджан',
        'Аргентина',
        'Австралия',
        'Австрия',
        'Багамские Острова',
        'Бахрейн',
        'Бангладеш',
        'Армения',
        'Барбадос',
        'Бельгия',
        'Боливия',
        'Босния и Герцеговина',
        'Ботсвана',
        'Бразилия',
        'Болгария',
        'Белоруссия',
        'Камбоджа',
        'Камерун',
        'Канада',
        'Кабо-Верде',
        'Каймановы острова',
        'Центральноафриканская Республика',
        'Шри-Ланка',
        'Чад',
        'Чили',
        'Китайская Народная Республика',
        'Остров Рождества',
        'Кокосовые острова',
        'Колумбия',
        'Республика Конго',
        'Демократическая Республика Конго',
        'Коста-Рика',
        'Хорватия',
        'Куба',
        'Кипр',
        'Чехия',
        'Дания',
        'Доминика',
        'Доминиканская Республика',
        'Эквадор',
        'Сальвадор',
        'Эфиопия',
        'Эстония',
        'Финляндия',
        'Франция',
        'Грузия',
        'Палестина',
        'Германия',
        'Гана',
        'Гибралтар',
        'Греция',
        'Гренландия',
        'Гренада',
        'Гватемала',
        'Гвинея',
        'Гайана',
        'Республика Гаити',
        'Ватикан',
        'Гондурас',
        'Гонконг',
        'Венгрия',
        'Исландия',
        'Индия',
        'Индонезия',
        'Иран',
        'Ирак',
        'Ирландия',
        'Израиль',
        'Италия',
        'Кот-д’Ивуар',
        'Ямайка',
        'Япония',
        'Казахстан',
        'Иордания',
        'Кения',
        'КНДР',
        'Республика Корея',
        'Кувейт',
        'Киргизия',
        'Лаос',
        'Ливан',
        'Лесото',
        'Латвия',
        'Либерия',
        'Ливия',
        'Лихтенштейн',
        'Литва',
        'Люксембург',
        'Макао',
        'Мадагаскар',
        'Малави',
        'Малайзия',
        'Мальдивы',
        'Мали',
        'Мальта',
        'Мартиника',
        'Мавритания',
        'Маврикий',
        'Мексика',
        'Монако',
        'Монголия',
        'Молдавия',
        'Черногория',
        'Монтсеррат',
        'Марокко',
        'Мозамбик',
        'Оман',
        'Намибия',
        'Науру',
        'Непал',
        'Нидерланды',
        'Кюрасао',
        'Аруба',
        'Новая Каледония',
        'Новая Зеландия',
        'Никарагуа',
        'Нигер',
        'Нигерия',
        'Норвегия',
        'Палау',
        'Пакистан',
        'Панама',
        'Папуа — Новая Гвинея',
        'Парагвай',
        'Перу',
        'Филиппины',
        'Польша',
        'Португалия',
        'Гвинея-Бисау',
        'Пуэрто-Рико',
        'Катар',
        'Румыния',
        'Россия',
        'Руанда',
        'Сан-Марино',
        'Саудовская Аравия',
        'Сенегал',
        'Сербия',
        'Сейшельские Острова',
        'Сьерра-Леоне',
        'Сингапур',
        'Словакия',
        'Словения',
        'Сомали',
        'Южно-Африканская Республика',
        'Зимбабве',
        'Испания',
        'Южный Судан',
        'Судан',
        'Западная Сахара',
        'Швеция',
        'Швейцария',
        'Сирия',
        'Таджикистан',
        'Таиланд',
        'Тринидад и Тобаго',
        'Объединённые Арабские Эмираты',
        'Тунис',
        'Турция',
        'Туркмения',
        'Уганда',
        'Украина',
        'Республика Македония',
        'Египет',
        'Великобритания',
        'Танзания',
        'Соединённые Штаты Америки',
        'Виргинские Острова',
        'Буркина-Фасо',
        'Уругвай',
        'Узбекистан',
        'Венесуэла',
        'Уоллис и Футуна',
        'Самоа',
        'Йемен',
        'Замбия',
    );
    private $rus_regions = array(
        "Москва",
        "Челябинская область",
        "Орловская область",
        "Омская область",
        "Липецкая область",
        "Курская область",
        "Рязанская область",
        "Брянская область",
        "Кировская область",
        "Архангельская область",
        "Мурманская область",
        "Санкт-Петербург",
        "Ярославская область",
        "Ульяновская область",
        "Новосибирская область",
        "Тюменская область",
        "Свердловская область",
        "Новгородская область",
        "Курганская область",
        "Калининградская область",
        "Ивановская область",
        "Астраханская область",
        "Хабаровский край",
        "Чеченская республика",
        "Удмуртская республика",
        "Республика Северная Осетия",
        "Республика Мордовия",
        "Республика  Карелия",
        "Республика  Калмыкия",
        "Республика  Ингушетия",
        "Республика Алтай",
        "Республика Башкортостан",
        "Республика Адыгея",
        "Республика Крым",
        "Севастополь",
        "Республика Коми",
        "Пензенская область",
        "Тамбовская область",
        "Ленинградская область",
        "Вологодская область",
        "Костромская область",
        "Псковская область",
        "Ямало-Ненецкий АО",
        "Чукотский АО",
        "Еврейская автономская область",
        "Республика Тыва",
        "Сахалинская область",
        "Амурская область",
        "Республика Бурятия",
        "Республика Хакасия",
        "Кемеровская область",
        "Алтайский край",
        "Республика Дагестан",
        "Кабардино-Балкарская республика",
        "Карачаевая-Черкесская республика",
        "Краснодарский край",
        "Ростовская область",
        "Самарская область",
        "Республика Татарстан",
        "Республика Марий Эл",
        "Чувашская республика",
        "Нижегородская край",
        "Владимировская область",
        "Московская область",
        "Калужская область",
        "Белгородская область",
        "Забайкальский край",
        "Приморский край",
        "Камачатский край",
        "Магаданская область",
        "Республика Саха",
        "Красноярский край",
        "Оренбургская область",
        "Саратовская область",
        "Волгоградская область",
        "Ставропольский край",
        "Смоленская область",
        "Тверская область",
        "Пермская область",
        "Ханты-Мансийский АО",
        "Томская область",
        "Иркутская область",
        "Ненецскй АО",
        "Ставропольский край",
        "Тульская область"
    );

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Отключение проверки внешних ключей, лучше не делать так все значения обнулятся
//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//        DB::table('regions')->truncate();
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rus = collect($this->rus_regions);
        $rus = $rus->sort();
        foreach ($rus as $item) {
            Region::create([
               'name' => $item,
            ]);
        }

        $country = collect($this->countries);
        $country = $country->sort();
        foreach ($country as $item) {
            Region::create([
                'name' => $item,
            ]);
        }

    }
}
