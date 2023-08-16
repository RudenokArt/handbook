<?php 

namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $order_statuses = ['open', 'booked', 'in_work', 'completed'];
      for ($i=0; $i < 50; $i++) { 
        DB::table('orders')->insert([
          'created_at' => Carbon::now()->subDays($i)->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->subDays($i)->format('Y-m-d H:i:s'),
          'status' => $order_statuses[rand(0, 3)],
          'title' => 'Заказ №'.$i.'Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты',
          'customer' => 'ФИО заказчкика №'.$i,
          'customer_email' => 'mail'.$i.'@mail.ru',
          'customer_phone' => '+7 '.$i.'555-44-33',
          'customer_address' => 'Адрес заказчика №'.$i,
          'content' => 'Описание заказа №'.$i.'Далеко-далеко за словесными, горами в стране гласных и согласных живут рыбные тексты. Обеспечивает, коварный! Буквоград оксмокс ее дал имени встретил сих но, рыбного толку переулка о диких текст. Пустился, текстами единственное образ.',
          'contractor' => rand(4, 5),
          'manager' => rand(2, 3),
        ]);
      }
    }
  }



?>

// Полное перестроение БД с перезапуском всех сидеров
php artisan migrate:fresh --seed