<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\BookDetail;
use Carbon\Carbon;
use PHPUnit\Logging\Exception;

class BookTimeService extends Service
{
    protected BookDetailsService $bookDetailsService;

    public function __construct(BookDetailsService $bookDetailsService)
    {
        $this->bookDetailsService = $bookDetailsService;
    }

    public function bookTime($attributes): Result
    {
        $currentDate = $attributes["date"] ?Carbon::parse($attributes["date"]): now();

        if ($currentDate->gt(now()->addWeek())) {
            throw new Exception("The date cannot be more than one week from today.", 400);
        }   if ($currentDate->lt(now()->format('d-m-y'))) {
            throw new Exception("The date cannot be  less than now", 400);
        }
        $startTime = Carbon::parse($currentDate)->startOfDay()->hour(10)->minute(0)->second(0);
        $endTime = Carbon::parse($currentDate)->endOfDay()->hour(22)->minute(0)->second(0);

        $bookDetails = BookDetail::whereDate('service_time', $currentDate)->get();

        $availability = [];
        $currentTime = clone $startTime;

        while ($currentTime->lte($endTime)) {
            $availability[$currentTime->format("H:i")] = true;
            $currentTime->addHour();
        }

        foreach ($bookDetails as $bookDetail) {
            $bookTime = Carbon::parse($bookDetail->service_time)->format("H:i");
            $availability[$bookTime] = false;
        }

        ksort($availability);

        $data = [];
        foreach ($availability as $time => $available) {
            $data[] = ["time" => $time, "available" => $available];
        }

        return $this->ok($data, "available time");
    }



}
