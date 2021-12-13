<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = [
            [
                'title'     =>  'User 2 - Event 1', 
                'userId'    =>  2,
                'start'     =>  Carbon::now()->startOfDay()->toDateTimeString(),
                'end'       =>  Carbon::now()->addDays(1)->startOfDay()->toDateTimeString()
            ],
            [
                'title'     =>  'User 2 - Event 2', 
                'userId'    =>  2,
                'start'     =>  Carbon::now()->addDays(1)->startOfDay()->toDateTimeString(),
                'end'       =>  Carbon::now()->addDays(2)->startOfDay()->toDateTimeString()
            ],
            [
                'title'     =>  'User 3 - Event 1', 
                'userId'    =>  3,
                'start'     =>  Carbon::now()->startOfDay()->toDateTimeString(),
                'end'       =>  Carbon::now()->addDays(1)->startOfDay()->toDateTimeString()
            ],
            [
                'title'     =>  'User 3 - Event 2', 
                'userId'    =>  3,
                'start'     =>  Carbon::now()->addDays(1)->startOfDay()->toDateTimeString(),
                'end'       =>  Carbon::now()->addDays(2)->startOfDay()->toDateTimeString()
            ],
            [
                'title'     =>  'User 3 - Event 3', 
                'userId'    =>  3,
                'start'     =>  Carbon::now()->addDays(2)->startOfDay()->toDateTimeString(),
                'end'       =>  Carbon::now()->addDays(3)->startOfDay()->toDateTimeString()
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
