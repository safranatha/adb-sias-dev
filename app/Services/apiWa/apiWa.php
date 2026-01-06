<?php
namespace App\Services\apiWa;

// include 'koneksi.php';
class ApiWa
{
    protected $token;

    public function __construct()
    {
        $this->token=config('services.fonnte.token');
    }

    //fungsi kirim pesan
    public function Kirimfonnte($no_telp, $pesan)
    {
        $curl = curl_init();

        // token ada di env
        $token = $this->token;

        $data = [
            "target" => $no_telp,
            "message" => $pesan,
        ];

        $delay = '60';

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $data["target"],
                'message' => $data["message"],
                'delay'=> $delay,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

}