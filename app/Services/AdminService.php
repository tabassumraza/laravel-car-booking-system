<?php

namespace App\Services;

use App\Models\User;
use App\Models\Carlist;
use App\Models\Setting;

class AdminService
{
     protected $model;
    public function __construct()
    {
        $this->model = new Carlist(); 
        $this->model = new Setting(); 

    }
    public function updateUser(User $user, array $data): void
    {
        $user->update($data);
    }

    public function deleteUser(User $user): bool
    {
        if ($user->id === auth()->id()) {
            return false;
        }

        $carsToUpdate = Carlist::whereHas('booking', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        $user->delete();

        foreach ($carsToUpdate as $car) {
            if (!$car->booking()->exists()) {
                $car->update(['status' => 'available']);
            }
        }

        return true;
    }

    public function updateSettings(array $data): void
    {
        if (function_exists('setting')) {
            setting()->set($data);
            setting()->save();
        } else {
            Setting::updateOrCreate(['key' => 'site_name'], ['value' => $data['site_name']]);
            Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $data['maintenance_mode']]);
        }
    }

    public function deleteCar(int $carId): void
    {
        Carlist::destroy($carId);
    }
}
