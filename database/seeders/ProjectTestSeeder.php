<?php

namespace Database\Seeders;

use App\Models\Dictionaries\ProjectCategory;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectTestSeeder extends Seeder
{
    private $categories = ['Музыка', 'Книга', 'Кино', 'Игры', 'Еда', 'Театр'];
    private $projects = ['Тест проект', 'Проект имени', 'Новый проект', 'Киностудия', "Создание игры"];
    private  $short = '9 лет работала продюсером в журнале GQ: мы взрывали машины,
     угоняли чужие караваны верблюдов и обнимались с Броуди. В книге много смешных и искренних историй о закулисьях глянца';
    private $desc ='Меня зовут Анастасия, и я хочу издать свою книгу.

Я 9 лет работала продюсером в журнале GQ: организовывала все съемки, обложки и интервью. Со мной случалось множество невероятных и комичных историй каждый день.

- Мы взрывали машины и перекрывали стадионы;

- Я угоняла чужие караваны верблюдов и звонила в «Империю разврата»;

- На полном серьезе высчитывала, сколько метров рыболовной сети мне нужно купить, чтобы обернуть женское тело модельной комплекции;

- Мы снимали БДСМ-историю под портретом Сталина в отеле «Советский» (это было в далекие-далекие дотолерантные времена, и нам приходилось привязывать веревкой к стулу мужчину с намазанным маслом торсом).

- Провожали американского посла в его резиденции и танцевали с ним Ганган стайл,

- Слушали, как Эдриан Броуди играет нам на белом рояле мелодии из «Пианиста» в президентском люксе гостиницы «Украина»;

- Я парковала старую «Ладу» без тормозов на эвакуатор;

- окунали Сашу Петрова лицом в торт;

- Мы чуть не утонули на лодке у берегов Санта-Моники, зато ели суши с Леонардо Ди Каприо на roof-top вечеринке в Нью-Йорке и многое многое другое.';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $id_arr = ProjectCategory::all()->pluck('id');
//        ProjectCategory::destroy($id_arr);
//        foreach ($this->categories as $item) {
//            ProjectCategory::create([
//                'name' => $item,
//            ]);
//        }

        foreach ($this->projects as $project) {
            Project::create([
                'title'=> $project,
                'short_desc' => $this->short,
                'description' =>$this->desc,
                'end_date' => '2022-09-08',
                'amount' => rand(1000, 500000),
                'user_id' => rand(1,2),
                'category_id' => 2,
                'region_id' => rand(0, 150),
                'is_public' => false,
                'status_id' => 2,
            ]);
        }
    }
}
