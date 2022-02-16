<?php

use App\Helpers\AppNotification;


function send_sms($mobileNo, $message)
{
    $url = 'https://24smsbd.com/api/bulkSmsApi';
    $data = array(
        'sender_id' => 808,
        'apiKey' => 'a2hhbnNtczpLaGFuODI2',
        'mobileNo' => $mobileNo,
        'message' => $message
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $output = curl_exec($curl);
    curl_close($curl);
    echo $output;
}





function paymentNotification($trip)
{
    // dd($trip);
    $push  = new AppNotification;
    $object = new stdClass;
    $object->type = 'paymentNotification';
    $push->push([
        'to' => $trip->driver->pushToken,
        'title' => "Payment Info",
        'body' => "Your Payment Complete for TOKEN DMBK#" . $trip->booking_id,
        'data' => $object
    ]);
    return 0;
}

function userProcessedNotification($trip)
{
    $push  = new AppNotification;
    $object = new stdClass;
    $object->type = 'accepted';
    $push->push([
        'to' => $trip->getUser->pushToken,
        'title' => "You trip confirmed !!",
        'body' => "Your booking Request has been Completed. TOKEN DMBK#" . $trip->booking_id,
        'data' => $object
    ]);
    return 0;
}

function userTripStartnotificaiton($trip)
{
    $push  = new AppNotification;
    $object = new stdClass;
    $object->type = 'tripstarted';
    $object->trip_id = $trip->id;
    $push->push([
        'to' => $trip->getUser->pushToken,
        'title' => "You trip Stared !!",
        'body' => "Yourtrip has been Stared. TOKEN DMBK#" . $trip->booking_id,
        'data' => $object
    ]);
    return 0;
}
function driverTripStartnotificaiton($trip)
{
    $push  = new AppNotification;
    $object = new stdClass;
    $object->type = 'tripstarted';
    $push->push([
        'to' => $trip->driver->pushToken,
        'title' => "You Just Start Your Trip !!",
        'body' => "You Just Start Your Trip . TOKEN DMBK#" . $trip->booking_id,
        'data' => $object
    ]);
    return 0;
}
