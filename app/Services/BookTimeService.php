<?php


namespace App\Services;


use App\DTOs\Result;
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
        $currentDate = isset($attributes["date"]) ? Carbon::parse($attributes["date"]) :  Carbon::today();

        // Check if the date is more than one week from today
        // Get the date one week from today

        if ($currentDate->gt(Carbon::today()->addWeek())) {
            throw new Exception("The date cannot be more than one week from today.", 400);
        }

        // Check if the date is less than now
        if ($currentDate->lt( Carbon::today())) {
            throw new Exception("The date cannot be less than today.", 400);
        }

        $startTime = $currentDate->copy()->startOfDay()->hour(10);
        $endTime = $currentDate->copy()->endOfDay()->hour(22);

        // Retrieve booked times directly from the database
        $bookedTimes = BookDetail::whereDate('service_time', $currentDate)->whereHas('book', function ($query) {$query->whereIn('status', ['waiting', 'schedule', 'inProgress']);})->pluck('service_time');
        $availability = [];
        $currentTime = $startTime->copy();

        while ($currentTime->lte($endTime)) {
            $availability[$currentTime->format("H:i")] = !$bookedTimes->contains($currentTime->toDateTimeString());
            $currentTime->addHour();
        }

        ksort($availability);

        $data = [];
        foreach ($availability as $time => $available) {
            $data[] = ["time" => $time, "available" => $available];
        }

        return $this->ok($data, "available time");
    }




}
