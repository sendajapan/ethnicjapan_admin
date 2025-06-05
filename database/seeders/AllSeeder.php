<?php
// All Seeder
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('providers')->insert([
            [
                'provider_name' => 'FLO TRADING',
                'provider_description' => '',
                'provider_address' => '',
            ],
            [
                'provider_name' => 'NATURAL FOOD IMPORTERS',
                'provider_description' => 'Test',
                'provider_address' => 'test',
            ],
            [
                'provider_name' => 'RIKI CO., LTD.',
                'provider_description' => 'Test',
                'provider_address' => 'test',
            ],
            [
                'provider_name' => 'GANSO SHOKUHIN',
                'provider_description' => 'Test',
                'provider_address' => 'test',
            ],
            [
                'provider_name' => 'THE FAKE FOOD WORKSHOP',
                'provider_description' => 'Test',
                'provider_address' => 'test',
            ],
            [
                'provider_name' => 'JUST DOUGH IT!',
                'provider_description' => 'Test',
                'provider_address' => 'test',
            ],
        ]);


    $customerData = array(
        array('Elias Thorne', 'A quiet, thoughtful architect often seen sketching in his notebook.', 'Prague, Czech Republic'),
        array('Seraphina Bellweather', 'A vibrant street artist known for her colorful murals and spontaneous performances.', 'Valparaíso, Chile'),
        array('Jasper Finch', 'A meticulous antique book restorer with a fondness for forgotten stories.', 'Hay-on-Wye, Wales'),
        array('Aurora Vance', 'A passionate marine biologist dedicated to coral reef conservation.', 'Cairns, Australia'),
        array('Silas Blackwood', 'A reclusive composer who creates hauntingly beautiful melodies in his secluded studio.', 'Reykjavik, Iceland'),
        array('Genevieve Hawthorne', 'A charismatic food blogger who explores the diverse culinary scene of her city.', 'New Orleans, USA'),
        array('Finnigan Grey', 'An adventurous travel photographer always seeking the perfect shot in remote locations.', 'Kathmandu, Nepal'),
        array('Isabelle Sterling', 'A talented ceramic artist whose delicate creations are inspired by nature.', 'Kyoto, Japan'),
        array('Caspian Rivers', 'A lively bookstore owner who always has a recommendation for the curious reader.', 'Buenos Aires, Argentina'),
        array('Willow Briar', 'A skilled herbalist who cultivates rare and medicinal plants in her rooftop garden.', 'Marrakech, Morocco')
    );
        foreach($customerData as $c){
            $customer['customer_name'] = $c[0];
            $customer['customer_description'] = $c[1];
            $customer['customer_address'] = $c[2];
            $customers[] = $customer;
        }
        DB::table('customers')->insert($customers);


        DB::table('categories')->insert([
            [
                'category_name' => 'SUPERFOODS',
                'category_description' => 'SUPERFOODS',
            ],
            [
                'category_name' => 'SPICES',
                'category_description' => 'SPICES',
            ],
            [
                'category_name' => 'NUTS',
                'category_description' => 'NUTS',
            ]
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Boss',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin1234'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'mnoman55@gmail.com',
                'password' => bcrypt('123'),
                'role' => 'admin',
                'status' => 'active',
            ]
        ]);










        $itemsData = array(
            '0' => array(
                'item_name' => 'CHIA',
                'item_description' => '',
                'category_id' => '1',
                'item_origin' => 'Peru',
                'item_photo' => 'uploads/item_photos/chia.webp',
                'hts_code' => 'HTS 1801.00.00.00',
                'default_price' => '9.98'
            ),
            '1' => array(
                'item_name' => 'QUINOA',
                'item_description' => '',
                'category_id' => '1',
                'item_origin' => 'Peru',
                'item_photo' => 'uploads/item_photos/quinoa.webp',
                'hts_code' => 'HTS 1805.00.00.00',
                'default_price' => '9.50'
            ),
            '2' => array(
                'item_name' => 'AMARANTH',
                'item_description' => '',
                'category_id' => '1',
                'item_origin' => 'Peru',
                'item_photo' => 'uploads/item_photos/amaranth2.webp',
                'hts_code' => 'HTS 1801.00.20.00',
                'default_price' => '15.90'
            ),
            '3' => array(
                'item_name' => 'CACAO',
                'item_description' => '20kg bag',
                'category_id' => '1',
                'item_origin' => 'Peru',
                'item_photo' => 'uploads/item_photos/cocoa.webp',
                'hts_code' => 'HTS 1008.50.90.00',
                'default_price' => '3.35'
            ),
            '4' => array(
                'item_name' => 'CHIA OIL',
                'item_description' => '20kg bag',
                'category_id' => '1',
                'item_origin' => 'Peru',
                'item_photo' => 'uploads/item_photos/chia-oil.webp',
                'hts_code' => 'HTS 1008.90.90.90',
                'default_price' => '3.22'
            ),
            '5' => array(
                'item_name' => 'SACHA OIL',
                'item_description' => '20kg bag',
                'category_id' => '1',
                'item_origin' => 'Peru',
                'item_photo' => 'uploads/item_photos/sacha-oil.webp',
                'hts_code' => 'HTS 0000.00.00.00',
                'default_price' => '5.49'
            ),
            '6' => array(
                'item_name' => 'HEMP HEARTS',
                'item_description' => '40kg bag',
                'category_id' => '1',
                'item_origin' => 'Peru',
                'item_photo' => 'uploads/item_photos/hemp.webp',
                'hts_code' => 'HTS 0000.00.00.00',
                'default_price' => '7.71'
            )
        );
        DB::table('items')->insert($itemsData);


        for($i=1; $i<=24; $i++){
            $purchase['purchase_amount']=0;
            $item_count = rand(3,10);
            for($j=1; $j<=$item_count; $j++){
                $item_index = rand(0,6);
                $item_selected = $itemsData[$item_index];
                $item_qty = round(rand(100,1000)/10)*10;

                $item['purchase_id'] = $i;
                $item['item_id'] = ($item_index+1);
                $item['item_qty'] = $item_qty;
                $item['item_description'] = $item_selected['item_description'];
                $item['item_hts_code'] = $item_selected['hts_code'];
                $item['item_unit_price'] = $item_selected['default_price'];
                $item['item_line_price'] = $item_selected['default_price']*$item_qty;
                $items[] = $item;
                $purchase['purchase_amount'] += $item['item_line_price'];
            }
            $purchase['purchase_no'] = 'AJ0'.rand(10001,99999).'-I';
            $random_date = date("Y-m-d", rand(strtotime(date('2023-01-01')), strtotime(date('Y-m-d'))));
            $purchase['purchase_date'] = $random_date;
            $purchase['purchase_invoice'] = 'uploads/purchase/4012Wz89aKMaFds1kzaTvXTj7imWpBNG5NoDSXo4.pdf';
            $purchase['provider_id'] = rand(1,6);
            $purchases[] = $purchase;
        }
        DB::table('purchases')->insert($purchases);
        DB::table('purchase_items')->insert($items);






        for($i=1; $i<=60; $i++){
            $sale['sale_amount']=0;
            $item_count = rand(4,7);
            for($j=1; $j<=$item_count; $j++){
                $item_index = rand(0,6);
                $item_selected = $itemsData[$item_index];
                $item_qty = round(rand(20,100)/5)*5;

                $item2['sale_id'] = $i;
                $item2['item_id'] = ($item_index+1);
                $item2['item_qty'] = $item_qty;
                $item2['item_description'] = $item_selected['item_description'];
                $item2['item_hts_code'] = $item_selected['hts_code'];
                $item2['item_unit_price'] = $item_selected['default_price'];
                $item2['item_line_price'] = $item_selected['default_price']*$item_qty;
                $items2[] = $item2;
                $sale['sale_amount'] += $item2['item_line_price'];
            }




            $sale['sale_no'] = 'INV-'.rand(10001,99999);
            $random_date = date("Y-m-d", rand(strtotime(date('2023-01-01')), strtotime(date('Y-m-d'))));
            $sale['sale_date'] = $random_date;
            $sale['sale_invoice'] = 'uploads/sale/4012Wz89aKMaFds1kzaTvXTj7imWpBNG5NoDSXo4.pdf';
            $sale['customer_id'] = rand(1,10);
            $sales[] = $sale;
        }
        DB::table('sales')->insert($sales);
        DB::table('sale_items')->insert($items2);






    }
}
