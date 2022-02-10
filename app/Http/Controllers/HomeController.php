<?php

namespace App\Http\Controllers;

use App\invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    $count_all = invoices::count();
    $count_unPaid = invoices::where('status','غير مدفوعة')->count();
    $count_paid = invoices::where('status','مدفوعة')->count();
    $count_partPaid = invoices::where('status','مدفوعة جزئيا')->count();

    $pr_all = round( $count_all / $count_all * 100,2);
    $pr_unPaid = round($count_unPaid / $count_all * 100,2);
    $pr_paid = round($count_paid / $count_all * 100,2);
    $pr_partPaid = round($count_partPaid / $count_all * 100,2);

    $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 350, 'height' => 200])
        ->datasets([
            [
                "label" => "الفواتير الغير مدفوعة",
                'backgroundColor' => ['#FC4F4F'],
                'data' => [$pr_unPaid]
            ],
            [
                "label" => "الفواتير المدفوعة",
                'backgroundColor' => ['#2EB086'],
                'data' => [$pr_paid]
            ],
            [
                "label" => "الفواتير المدفوة جزئيا",
                'backgroundColor' => ['#FFBC80','#FFBC80'],
                'data' => [$pr_partPaid,$pr_partPaid]
            ],
            [
                "label" => "الفواتير الكلية",
                'backgroundColor' => ['#2666CF','#2666CF'],
                'data' => [$pr_all,$pr_all]
            ]
        ])
        ->options([]);

        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير الغير مدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#FC4F4F', '#2EB086', '#FFBC80'],
                    'hoverBackgroundColor' => ['#FC4F4F', '#2EB086', '#FFBC80'],
                    'data' => [$pr_unPaid, $pr_paid, $pr_partPaid]
                ]
            ])
            ->options([]);

            return view('home',compact('chartjs','chartjs2'));
        }



}
