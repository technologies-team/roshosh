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
                'description' => 'Several stages are involved:|Interior Cleaning With Deep Vacuum and Shine.|Exterior Wash with high Pressure with Shampoo Tyers Clean.',
                'description_ar' => 'تكون على عدة مراحل|تنظيف داخلي  للسيارة مع شفط الأتربة والتلميع|غسيل خارجي للسيارة بالضغط العالي بالشامبو وتنظيف الإطارات|',
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
                'description' => 'Several stages are involved:|High Pressure Washing With Shampoo.|Engine Cleaning v Interior Deep Vacuum v Tyer and Rim Cleaning& Shining .|Glass Cleaning v Dashboard Shine .|AC duct steam Cleaning',
                'description_ar' => 'تكون على عدة مراحل|غسيل السيارة بالضغط العالي بالشامبو|تنظيف المحرك تنظيف داخلي عميق بالشفاط وتنظيف وتلميع الإطارات والعجلات| تنظيف الزجاج وتلميع لوحة القيادة| تنظيف منافذ وفتحات التكييف بالبخار|', 'price' => 100.00,
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
                'description' => 'Several stages are involved:|Wax Shining.|External Plastic Cover|Interior Stain Remove|Interior Polishing|AC Cleaning|Tiers Polishing|Engine Wash and Polish|Exterior Shampoo|Washing & Interior Cleaning',
                'description_ar' => 'تكون على عدة مراحل|تلميع جميع زجاج السيارة|تغطية السيارة بأغطية بلاستيكية خارجية|إزالة البقع الداخلية الموجودة في السيارة|تلميع السيارة داخلياً|تنظيف مكيف الهواء من الأتربة والشوائب| تلميع الإطارات| غسيل وتلميع المحرك|غسل السيارة خارجياً بالشامبو|غسيل وتنظيف داخلي عميق لكل أجزاء السيارة', 'price' => 150.00,
                'category_id' => 2,
                'parent_id' => null,
                'rewards' => 15000,
                'photo_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'title' => 'Car Detailing',
                'title_ar' => 'خدمات التنظيف الداخلي والخارجي للسيارات',
                'description' => 'Several stages are involved:|Two Layer body wash(steam water)|Steps body polishing with high quality products|Full interior detailing with high pressure steam|Seat polishing shampooing engine compartment cleaning|AC duct cleaning with hot steam|Leather protection coating|Trunk vacuum|Truck mat cleaning and stain removal|Exterior Shampoo|Washing & Interior',
                'description_ar' => 'تكون على عدة مراحل:|غسيل السيارة على مرحلتين باستخدام البخار|تلميع هيكل السيارة بست خطوات باستخدام منتجات عالية الجودة|تنظيف كامل للمقصورة الداخلية للسيارة باستخدام البخار عالي الضغط|تنظيف وتلميع المقاعد وغسيل شامل للمحركً|تنظيف مجاري ومنافذ التكييف بالبخار الساخن|طلاء أغطية الكراسي الجلدية| تنظيف صندوق الأمتعة باستخدام الشفاط|تنظيف شامل لسجادات السيارة وإزالة أي بقع|غسيل خارجي للسيارة بالشامبو|غسيل وتنظيف داخلي للسيارة بعمق', 'price' => 200.00,
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
