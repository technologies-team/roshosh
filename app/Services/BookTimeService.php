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
    public function bookTime($attributes): void
    {
        $date=$attributes["date"];
        $startTime = Carbon::parse($date)->startOfDay()->hour(10)->minute(0)->second(0);

        $endTime = $date->copy()->endOfDay()->hour(22)->minute(0)->second(0);
dd($startTime->toDateTime());
        // Fetch records from BookDetail where service_time falls within the specified time range
        $bookDetails = BookDetail::where('service_time', '>=', $startTime)
            ->where('service_time', '<=', $endTime)
            ->get();
            $date = Carbon::parse($attributes["date"])->startOfDay();
            $bookDetails = BookDetail::whereDate('service_time', $date)->get();

            foreach($bookDetails as $bookDetail ){

            }
    }


}
