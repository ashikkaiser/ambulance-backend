<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;


class AppNotification
{
    private function executeCurl($ch)
    {
        $response = [
            'body' => curl_exec($ch),
            'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
        ];

        $responseData = json_decode($response['body'], true)['data'] ?? null;

        // if (! is_array($responseData)) {
        //     throw new UnexpectedResponseException();
        // }

        return $responseData;
    }
    public function getCurl()
    {
        // Create or reuse existing cURL handle
        $this->ch = $this->ch ?? curl_init();

        // Throw exception if the cURL handle failed
        if (!$this->ch) {
            throw new ExpoException('Could not initialise cURL!');
        }

        return $this->ch;
    }

    private function prepareCurl()
    {
        $ch = $this->getCurl();

        // Set cURL opts
        curl_setopt($ch, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'content-type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $ch;
    }

    public function push($data)
    {
        if (isset($data['data'])) {
            $message = array(
                'to' => $data['to'],
                'sound' => 'default',
                'title' => $data['title'],
                'body' => $data['body'],
                'data' => $data['data'],
            );
        } else {
            $message = array(
                'to' => $data['to'],
                'sound' => 'default',
                'title' => $data['title'],
                'body' => $data['body'],
            );
        }

        $ch = $this->prepareCurl();
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        $response = $this->executeCurl($ch);
    }
}
