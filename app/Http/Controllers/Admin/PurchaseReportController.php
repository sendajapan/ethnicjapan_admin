<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Provider;
use App\Models\PurchaseItem;
use Maantje\Charts\Bar\Bar;
use Maantje\Charts\Bar\BarGroup;
use Maantje\Charts\Bar\Bars;
use Maantje\Charts\Chart;
use Maantje\Charts\Grid;
use Maantje\Charts\YAxis;

class PurchaseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $purchases = PurchaseItem::leftJoin('purchases', 'purchase_items.purchase_id', 'purchases.id')
            ->leftJoin('items', 'items.id', 'purchase_items.item_id')
            ->leftJoin('providers', 'providers.id', 'purchases.provider_id')
            ->get();

        $items = Item::all()->sortBy('item_name');

        $providers = Provider::all()->sortBy('provider_name');


        //$purchasedItems = $purchases->purchasedItems;
        //echo $purchases->purchasedItems->count();
        $year_starting = 2023;
        for($year = date("Y"); $year>=$year_starting;  $year--){
            for($month = 1; $month<=12; $month++){
                $month = sprintf('%02d', $month);
                $purchase_info_all[$year]['by_month'][$month] = 0;
            }
        }

        foreach($purchases as $p){
            $year = date('Y', strtotime($p->purchase_date));
            $month = date('m', strtotime($p->purchase_date));
            $purchase_info_all[$year]['by_month'][$month]  += $p->item_line_price;
        }







        for($year = date("Y"); $year>=$year_starting;  $year--){
            foreach ($items as $p) {
                $purchase_info_all[$year]['by_item'][$p->item_name] = 0;
            }
        }
        foreach($purchases as $p){
            $year = date('Y', strtotime($p->purchase_date));
            $purchase_info_all[$year]['by_item'][$p->item_name]  += $p->item_line_price;
        }





        for($year = date("Y"); $year>=$year_starting;  $year--){
            foreach ($providers as $p) {
                $purchase_info_all[$year]['by_provider'][$p->provider_name] = 0;
            }
        }
        foreach($purchases as $p){
            $year = date('Y', strtotime($p->purchase_date));
            $purchase_info_all[$year]['by_provider'][$p->provider_name]  += $p->item_line_price;
        }


        foreach($purchase_info_all as $year => $item){


            $year_max = 0;
            foreach($item['by_month'] as $month => $line){
                $chart_amount[$month] = $line;
                if($year_max <= $line){$year_max = $line;}
            }
            $year_max = (ceil($year_max/5000)*5000);

            $chart = new Chart(
                width :450,
                height :200,
                leftMargin:0,
                rightMargin:30,
                bottomMargin:50,
                topMargin:25,
                fontSize:10,
                grid: new Grid(
                    thickness:1,
                    lines:4,
                ),
                yAxis: [
                    new YAxis(
                        maxValue:$year_max
                    )
                ],
                series: [
                    new Bars(
                        bars: [
                            new BarGroup(
                                name: date("M", strtotime("2025-01-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['01']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-02-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['02']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-03-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['03']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-04-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['04']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-05-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['05']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-06-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['06']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-07-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['07']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-08-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['08']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-09-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['09']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-10-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['10']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-11-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['11']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 10,
                            ),
                            new BarGroup(
                                name: date("M", strtotime("2025-12-01")),
                                bars: [
                                    new Bar( color:'#1E90FF', value: $chart_amount['12']),
                                    new Bar( color:'#1E90FF', value: 0),
                                ],
                                radius: 5,
                            ),

                        ],
                    ),
                ],
            );


            $purchase_info_all[$year]['chart'] = $chart->render();

        }







        $data = $purchase_info_all;
        return view('admin.purchase_report.index', compact('data'));
    }

}
