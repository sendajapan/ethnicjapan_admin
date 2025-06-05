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



        DB::table('countries')->insert([
            ['country_name'=>'United States of America'],
            ['country_name'=>'Canada'],
            ['country_name'=>'Afghanistan'],
            ['country_name'=>'Albania'],
            ['country_name'=>'Algeria'],
            ['country_name'=>'American Samoa'],
            ['country_name'=>'Andorra'],
            ['country_name'=>'Angola'],
            ['country_name'=>'Anguilla'],
            ['country_name'=>'Antarctica'],
            ['country_name'=>'Antigua And Barbuda'],
            ['country_name'=>'Argentina'],
            ['country_name'=>'Armenia'],
            ['country_name'=>'Aruba'],
            ['country_name'=>'Australia'],
            ['country_name'=>'Austria'],
            ['country_name'=>'Azerbaijan'],
            ['country_name'=>'Bahamas'],
            ['country_name'=>'Bahrain'],
            ['country_name'=>'Bangladesh'],
            ['country_name'=>'Barbados'],
            ['country_name'=>'Belarus'],
            ['country_name'=>'Belgium'],
            ['country_name'=>'Belize'],
            ['country_name'=>'Benin'],
            ['country_name'=>'Bermuda'],
            ['country_name'=>'Bhutan'],
            ['country_name'=>'Bolivia'],
            ['country_name'=>'Bosnia and Herzegovina'],
            ['country_name'=>'Botswana'],
            ['country_name'=>'Brazil'],
            ['country_name'=>'Brunei'],
            ['country_name'=>'Bulgaria'],
            ['country_name'=>'Burkina Faso'],
            ['country_name'=>'Myanmar'],
            ['country_name'=>'Burundi'],
            ['country_name'=>'Cambodia'],
            ['country_name'=>'Cameroon'],
            ['country_name'=>'Cape Verde'],
            ['country_name'=>'Cayman Islands'],
            ['country_name'=>'Central African Republic'],
            ['country_name'=>'Chad'],
            ['country_name'=>'Chile'],
            ['country_name'=>'China'],
            ['country_name'=>'Christmas Island'],
            ['country_name'=>'Cocos [Keeling] Islands'],
            ['country_name'=>'Colombia'],
            ['country_name'=>'Comoros'],
            ['country_name'=>'Congo'],
            ['country_name'=>'Cook Islands'],
            ['country_name'=>'Costa Rica'],
            ['country_name'=>'Cote dIvoire'],
            ['country_name'=>'Croatia'],
            ['country_name'=>'Cyprus'],
            ['country_name'=>'Czech Republic'],
            ['country_name'=>'Denmark'],
            ['country_name'=>'Djibouti'],
            ['country_name'=>'Dominica'],
            ['country_name'=>'Dominican Republic'],
            ['country_name'=>'Timor-Leste'],
            ['country_name'=>'Ecuador'],
            ['country_name'=>'Egypt'],
            ['country_name'=>'El Salvador'],
            ['country_name'=>'Equatorial Guinea'],
            ['country_name'=>'Eritrea'],
            ['country_name'=>'Estonia'],
            ['country_name'=>'Ethiopia'],
            ['country_name'=>'Falkland Islands'],
            ['country_name'=>'Faroe Islands'],
            ['country_name'=>'Fiji'],
            ['country_name'=>'Finland'],
            ['country_name'=>'France'],
            ['country_name'=>'French Guiana'],
            ['country_name'=>'French Polynesia'],
            ['country_name'=>'Gabon'],
            ['country_name'=>'Gambia'],
            ['country_name'=>'Palestine'],
            ['country_name'=>'Georgia'],
            ['country_name'=>'Germany'],
            ['country_name'=>'Ghana'],
            ['country_name'=>'Gibraltar'],
            ['country_name'=>'Greece'],
            ['country_name'=>'Greenland'],
            ['country_name'=>'Grenada'],
            ['country_name'=>'Guadeloupe'],
            ['country_name'=>'Guam'],
            ['country_name'=>'Guatemala'],
            ['country_name'=>'Guernsey'],
            ['country_name'=>'Guinea'],
            ['country_name'=>'Guinea-Bissau'],
            ['country_name'=>'Guyana'],
            ['country_name'=>'Haiti'],
            ['country_name'=>'Honduras'],
            ['country_name'=>'Hong Kong'],
            ['country_name'=>'Hungary'],
            ['country_name'=>'Iceland'],
            ['country_name'=>'India'],
            ['country_name'=>'Indonesia'],
            ['country_name'=>'Iraq'],
            ['country_name'=>'Ireland'],
            ['country_name'=>'Israel'],
            ['country_name'=>'Italy'],
            ['country_name'=>'Jamaica'],
            ['country_name'=>'Japan'],
            ['country_name'=>'Jordan'],
            ['country_name'=>'Kazakhstan'],
            ['country_name'=>'Kenya'],
            ['country_name'=>'Kiribati'],
            ['country_name'=>'Korea, South'],
            ['country_name'=>'Kuwait'],
            ['country_name'=>'Kyrgyzstan'],
            ['country_name'=>'Laos'],
            ['country_name'=>'Latvia'],
            ['country_name'=>'Lebanon'],
            ['country_name'=>'Lesotho'],
            ['country_name'=>'Liberia'],
            ['country_name'=>'Libya'],
            ['country_name'=>'Liechtenstein'],
            ['country_name'=>'Lithuania'],
            ['country_name'=>'Luxembourg'],
            ['country_name'=>'Macao'],
            ['country_name'=>'Macedonia'],
            ['country_name'=>'Madagascar'],
            ['country_name'=>'Malawi'],
            ['country_name'=>'Malaysia'],
            ['country_name'=>'Maldives'],
            ['country_name'=>'Mali'],
            ['country_name'=>'Malta'],
            ['country_name'=>'Marshall Islands'],
            ['country_name'=>'Martinique'],
            ['country_name'=>'Mauritania'],
            ['country_name'=>'Mauritius'],
            ['country_name'=>'Mayotte'],
            ['country_name'=>'Mexico'],
            ['country_name'=>'Moldova'],
            ['country_name'=>'Monaco'],
            ['country_name'=>'Mongolia'],
            ['country_name'=>'Montserrat'],
            ['country_name'=>'Morocco'],
            ['country_name'=>'Mozambique'],
            ['country_name'=>'Namibia'],
            ['country_name'=>'Nauru'],
            ['country_name'=>'Nepal'],
            ['country_name'=>'Netherlands'],
            ['country_name'=>'Netherlands Antilles'],
            ['country_name'=>'New Caledonia'],
            ['country_name'=>'New Zealand'],
            ['country_name'=>'Nicaragua'],
            ['country_name'=>'Niger'],
            ['country_name'=>'Nigeria'],
            ['country_name'=>'Niue'],
            ['country_name'=>'Norfolk Island'],
            ['country_name'=>'Norway'],
            ['country_name'=>'Oman'],
            ['country_name'=>'Pakistan'],
            ['country_name'=>'Palau'],
            ['country_name'=>'Panama'],
            ['country_name'=>'Papua New Guinea'],
            ['country_name'=>'Paraguay'],
            ['country_name'=>'Peru'],
            ['country_name'=>'Philippines'],
            ['country_name'=>'Pitcairn'],
            ['country_name'=>'Poland'],
            ['country_name'=>'Portugal'],
            ['country_name'=>'Puerto Rico'],
            ['country_name'=>'Qatar'],
            ['country_name'=>'Reunion'],
            ['country_name'=>'Romania'],
            ['country_name'=>'Russian Federation'],
            ['country_name'=>'Rwanda'],
            ['country_name'=>'Saint Kitts and Nevis'],
            ['country_name'=>'Saint Lucia'],
            ['country_name'=>'Samoa'],
            ['country_name'=>'San Marino'],
            ['country_name'=>'Sao \r\n\r\nTome and Principe'],
            ['country_name'=>'Saudi Arabia'],
            ['country_name'=>'Senegal'],
            ['country_name'=>'Seychelles'],
            ['country_name'=>'Sierra Leone'],
            ['country_name'=>'Singapore'],
            ['country_name'=>'Slovakia'],
            ['country_name'=>'Slovenia'],
            ['country_name'=>'Solomon Islands'],
            ['country_name'=>'Somalia'],
            ['country_name'=>'South Africa'],
            ['country_name'=>'Spain'],
            ['country_name'=>'Sri Lanka'],
            ['country_name'=>'St. Helena'],
            ['country_name'=>'St. Pierre and Miquelon'],
            ['country_name'=>'Sudan'],
            ['country_name'=>'Suriname'],
            ['country_name'=>'Swaziland'],
            ['country_name'=>'Sweden'],
            ['country_name'=>'Switzerland'],
            ['country_name'=>'Taiwan'],
            ['country_name'=>'Tajikistan'],
            ['country_name'=>'Tanzania'],
            ['country_name'=>'Thailand'],
            ['country_name'=>'Togo'],
            ['country_name'=>'Tokelau'],
            ['country_name'=>'Tonga'],
            ['country_name'=>'Trinidad and Tobago'],
            ['country_name'=>'Tunisia'],
            ['country_name'=>'Turkey'],
            ['country_name'=>'Turkmenistan'],
            ['country_name'=>'Turks and Caicos Islands'],
            ['country_name'=>'Tuvalu'],
            ['country_name'=>'Uganda'],
            ['country_name'=>'Ukraine'],
            ['country_name'=>'United Arab Emirates'],
            ['country_name'=>'United Kingdom'],
            ['country_name'=>'Uruguay'],
            ['country_name'=>'Uzbekistan'],
            ['country_name'=>'Vanuatu'],
            ['country_name'=>'Holy See [Vatican City State]'],
            ['country_name'=>'Venezuela'],
            ['country_name'=>'VietNam'],
            ['country_name'=>'Virgin Islands [British]'],
            ['country_name'=>'Virgin Islands [U.S.]'],
            ['country_name'=>'Wallis and Futuna Islands'],
            ['country_name'=>'Western Sahara'],
            ['country_name'=>'Yemen'],
            ['country_name'=>'Zambia'],
            ['country_name'=>'Zimbabwe']
        ]);








        DB::table('providers')->insert([
            [
                'provider_name' => 'John',
                'provider_company_name' => 'FLO TRADING',
                'provider_physical_address' => '',
                'provider_country_name' => 'Chile',
            ],
            [
                'provider_name' => 'Wick',
                'provider_company_name' => 'NATURAL FOOD IMPORTERS',
                'provider_physical_address' => 'test',
                'provider_country_name' => 'Colombia',
            ],
            [
                'provider_name' => 'Nick',
                'provider_company_name' => 'RIKI CO., LTD',
                'provider_physical_address' => 'test',
                'provider_country_name' => 'Japan',
            ],
            [
                'provider_name' => 'Will',
                'provider_company_name' => 'GANSO SHOKUHIN',
                'provider_physical_address' => 'test',
                'provider_country_name' => 'Peru',
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
            $purchase['provider_id'] = rand(1,4);
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
