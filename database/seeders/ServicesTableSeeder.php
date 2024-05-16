<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'title' => 'Standard Wash',
                'title_ar' => 'غسيل عادي',
                'description' => 'Several stages are involved:|
1- Interior Cleaning With Deep Vacuum and Shine.|
2- Exterior Wash with high Pressure with Shampoo Tyers Clean.',
                'description_ar' => 'تكون على عدة مراحل|
1-تنظيف داخلي  للسيارة مع شفط الأتربة والتلميع|
2-غسيل خارجي للسيارة بالضغط العالي بالشامبو وتنظيف الإطارات|
                ',
                'price' => 50.00,
                'category_id' => 1,
                'parent_id' => null,
                'rewards' => 5000,
                'photo_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Premium Wash',
                'title_ar' => 'غسيل ممتاز',
                'description' => 'Several stages are involved:|
1- High Pressure Washing With Shampoo.|
2- Engine Cleaning v Interior Deep Vacuum v Tyer and Rim Cleaning& Shining .|
3- Glass Cleaning v Dashboard Shine .|
4- AC duct steam Cleaning
    ',
                'description_ar' => 'تكون على عدة مراحل|غسيل السيارة بالضغط العالي بالشامبو|
تنظيف المحرك تنظيف داخلي عميق بالشفاط وتنظيف وتلميع الإطارات والعجلات|
 تنظيف الزجاج وتلميع لوحة القيادة|
 تنظيف منافذ وفتحات التكييف بالبخار|
                ', 'price' => 100.00,
                'category_id' => 2,
                'parent_id' => null,
                'rewards' => 10000,
                'photo_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Platinum',
                'title_ar' => 'غسيل بلاتينيوم',
                'description' => 'Several stages are involved:
1- Wax Shining.
2- External Plastic Cover
3- Interior Stain Remove
4- Interior Polishing
5- AC Cleaning
6- Tiers Polishing
7- Engine Wash and Polish
8- Exterior Shampoo
9- Washing & Interior Cleaning
    ',
                'description_ar' => 'تكون على عدة مراحل
                1-تلميع جميع زجاج السيارة
    2- تغطية السيارة بأغطية بلاستيكية خارجية
    3- إزالة البقع الداخلية الموجودة في السيارة
    4- تلميع السيارة داخلياً
    5- تنظيف مكيف الهواء من الأتربة والشوائب
    6- تلميع الإطارات
    7- غسيل وتلميع المحرك
    8- غسل السيارة خارجياً بالشامبو
     9- غسيل وتنظيف داخلي عميق لكل أجزاء السيارة
                ', 'price' => 150.00,
                'category_id' => 2,
                'parent_id' => null,
                'rewards' => 15000,
                'photo_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'title' => 'Car Detailing',
                'title_ar' => 'خدمات التنظيف الداخلي والخارجي للسيارات (تنفيض السيارات)',
                'description' => 'Several stages are involved:
1- Two Layer body wash(steam water)
2- Steps body polishing with high quality products
3- Full interior detailing with high pressure steam
4- Seat polishing shampooing engine compartment cleaning
5- AC duct cleaning with hot steam
6- Leather protection coating
7- Trunk vacuum
8- Truck mat cleaning and stain removal
9- Exterior Shampoo
10-Washing & Interior
    ',
                'description_ar' => 'تكون على عدة مراحل
    1-غسيل السيارة على مرحلتين باستخدام البخار
    2-تلميع هيكل السيارة بست خطوات باستخدام منتجات عالية الجودة
    3- تنظيف كامل للمقصورة الداخلية للسيارة باستخدام البخار عالي الضغط
    4-تنظيف وتلميع المقاعد وغسيل شامل للمحركً
    5-تنظيف مجاري ومنافذ التكييف بالبخار الساخن
    6- طلاء أغطية الكراسي الجلدية
    7- تنظيف صندوق الأمتعة باستخدام الشفاط
    8- تنظيف شامل لسجادات السيارة وإزالة أي بقع
     9- غسيل خارجي للسيارة بالشامبو
     10-غسيل وتنظيف داخلي للسيارة بعمق
                ', 'price' => 200.00,
                'category_id' => 2,
                'parent_id' => null,
                'rewards' => 20000,
                'photo_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
