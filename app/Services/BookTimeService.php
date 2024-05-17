<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Book;
use App\Models\BookDetail;
use App\Models\Cart;
use App\Models\CartService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BookTimeService extends Service
{
    protected BookDetailsService $bookDetailsService;
    protected UserService $userService;

    public function __construct(BookDetailsService $bookDetailsService)
    {
        $this->bookDetailsService = $bookDetailsService;
    }
    public function bookTime($attributes): Result
    {
        $date=$attributes["date"];
        $startTime = Carbon::parse($date)->startOfDay()->hour(10)->minute(0)->second(0);

        $endTime = Carbon::parse($date)->endOfDay()->hour(22)->minute(0)->second(0);
        // Fetch records from BookDetail where service_time falls within the specified time range
        $bookDetails = BookDetail::where('service_time', '>=', $startTime)
            ->where('service_time', '<=', $endTime)
            ->get();
            $date = Carbon::parse($attributes["date"])->startOfDay();
            $bookDetails = BookDetail::whereDate('service_time', $date)->get();
$date= array($startTime->toDateTime()->format("H:i")=>false);
        $currentTime = Carbon::parse($startTime);

        while ($currentTime->lt($endTime)) {
            $date[$currentTime->format("H:i")] =true;
            $currentTime->addHour(); // Add one hour to current time
        }

        $date[$endTime->toDateTime()->format("H:i")]=false;

            foreach($bookDetails as $bookDetail ){
                $bookTime=$bookDetail->service_time;
              $date[Carbon::parse($bookTime)->toDateTime()->format("H:i")]= false ;

            }

       ;
        ksort($date);
        $data=array();
        foreach ($date as $time=>$available) {
            $data[]=["time"=>$time,"available"=>$available];
        }
        return $this->ok($data,"available time ");

    }


}
