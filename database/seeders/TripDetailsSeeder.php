<?php

namespace Database\Seeders;

use App\Models\TripDetails;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class TripDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'booking_id' => 'BK#1001',
                'booking_date' => Carbon::now(),
                'ambulance_type' => 'Freezer',
                'vehicle_id' => 'VH#1003',
                'driver_id' => 'DR#1102',
                'user_id' => 'US#1098',
                'booking_status' => 'booked',
                'booking_otp' => 'another_otp',
                'cancelled_by' => 'none',
                'start_point' => 'Nikunja-2' ,
                'end_point' => 'Gulshan-2',
                'distance' => '7.2 Km',
                'fair' => 720,
                'discount_amount' => null,
                'payment_method' => 'cash',
                'accident_history' => null,
                'trip_Feedback' => 'good',
            ],

            [
                'booking_id' => 'BK#1002',
                'booking_date' => Carbon::now(),
                'ambulance_type' => 'General',
                'vehicle_id' => 'VH#1008',
                'driver_id' => 'DR#1002',
                'user_id' => 'US#1058',
                'booking_status' => 'booked',
                'booking_otp' => 'another_otp2',
                'cancelled_by' => 'none',
                'start_point' => 'uttara' ,
                'end_point' => 'Mirpur',
                'distance' => '15.9 Km',
                'fair' => 1277,
                'discount_amount' => 100,
                'payment_method' => 'bikash',
                'accident_history' => '1',
                'trip_Feedback' => 'bad',
            ],

            [
                'booking_id' => 'BK#1003',
                'booking_date' => Carbon::now(),
                'ambulance_type' => 'Ambulance',
                'vehicle_id' => 'VH#1033',
                'driver_id' => 'DR#1242',
                'user_id' => 'US#1342',
                'booking_status' => 'booked',
                'booking_otp' => 'another_ot3',
                'cancelled_by' => 'none',
                'start_point' => 'Amuk' ,
                'end_point' => 'Tamuk',
                'distance' => '7.2 Km',
                'fair' => 2333,
                'discount_amount' => null,
                'payment_method' => 'cash',
                'accident_history' => null,
                'trip_Feedback' => 'good',
            ],

        ];

        foreach($data as $d) {
            TripDetails::create($d);
        }
    }
}
