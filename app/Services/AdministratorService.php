<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Container\Container;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AdministratorService extends UserService
{
    /**
     * builder
     */
    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query()->where('role_id', '=', Role::administrator);
    }

    /**
     * prepare
     */
    protected function prepare(string $operation, array $attributes): array
    {
        if ($operation === 'store') {
            $attributes['role_id'] = Role::administrator;
            $attributes['status'] = User::status_active;
        }
        return parent::prepare($operation, $attributes);
    }

    /**
     * find administrator
     * @throws \Exception
     */
    public function find( $id): Model
    {
        $user = parent::find($id);
        if ($user->role_id !== Role::administrator) {
            throw new \Exception('records:find:errors:not_found');
        }
        return $user;
    }
    public function create(array $attributes): \App\DTOs\Result
    {
        $file = $attributes['file'];
        $user = auth()->user();
        $fileSaveAsName = time() . rand(1000,9999) . "-attach." . $file->getClientOriginalExtension();
        $upload_path = public_path() . '/attachments/'.$user->id.'/';

        $file_url = $upload_path . $fileSaveAsName;
        $success = $file->move($upload_path, $fileSaveAsName);
        $user_file = URL::to('/').'/attachments/'.$user->id.'/'.$fileSaveAsName;

        $attachment = ['post_title'=> $attributes['post_title'],
            'post_content' => $user_file,
            'guid' => $user_file,
          ];


        return $this->ok($this->store($attachment));
    }
    public function statistic(): \App\DTOs\Result
    {
        $managers_count = Container::getInstance()->get(UserService::class)->builder()->where('role_id', Role::manager)->count();
        $clients_count = Container::getInstance()->get(UserService::class)->builder()->where('role_id', Role::customer)->count();
        $coupons_count = Container::getInstance()->get(CouponService::class)->builder()->count();
        $from = Carbon::now()->startOfYear()->format('Y-m-d');
        $to = Carbon::now()->endOfYear()->format('Y-m-d');
        for ($inc = 1; $inc <= 12; $inc++) {
            $clinics_per_month[$inc] = 0;
        }

        $clients_per_month_data = Container::getInstance()->get(UserService::class)->builder()->where('role_id', Role::customer)
        ->select(
            DB::raw('COUNT(users.id) as count'),
            DB::raw('YEAR(created_at) year, MONTH(created_at) month')
        )->whereBetween('created_at', [$from, $to])->groupby('year', 'month')->get()->toArray();

        for ($inc = 1; $inc <= 12; $inc++) {
            $clients_per_month[$inc] = 0;
            foreach ($clients_per_month_data as $match) {
                if ($match['month'] == $inc) {
                    $clients_per_month[$inc] = $match['count'];
                }
            }
        }

        $from_week = Carbon::now()->subWeek(1)->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');
        for ($inc = 1; $inc <= 7; $inc++) {
            $clinics_per_week[$inc] = $clinics_per_week_data[$inc-1]['count'] ?? 0;
        }

        $data = [
            "managers_count"    =>  $managers_count,
            "clients_count"     =>  $clients_count,
            "coupons_count"     =>  $coupons_count,
            "clinics_per_month" =>  $clinics_per_month,
            "clients_per_month" =>  $clients_per_month,
            "clinics_per_week" =>  $clinics_per_week,
        ];
        return $this->ok($data, 'Statistics fetch successfully!');
    }
}
