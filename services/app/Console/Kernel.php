<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\JosPostpaid;
use App\Models\IkejaPostpaid;
use App\Models\Prepaid;
use DB;

use Illuminate\Support\Facades\Http;
use Auth;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {


        // $billerId = JosPostpaid::select('billerRequestId')->orderBy('requestId','desc')->first();
        //   $response = $schedule->command(Http::withHeaders([
        //              'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
        //              'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        //          ])->post('http://132.145.231.191/vasb2b/dev/Api/query',[
        //             'id' => $billerId,
        //            ]))->everyFiveMinutes();


                //    $billerId = Prepaid::select('billerRequestId')->orderBy('id','desc')->first();
               $billerId = DB::table('prepaid_payment_histories')->select('requestId')->where(['status' => 'PENDING'])->first();

              
                //    dd($billerId->billerRequestId,$billerId->phone);
                   $response = $schedule->command(Http::withHeaders([
                              'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                              'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
                          ])->post('http://132.145.231.191/vasb2b/dev/Api/query',[
                             'id' =>$billerId->requestId,
                            ]))->everyFiveMinutes()
                            ->sendOutPutTo('localhost/Ebill/services/file.txt');

                         
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
