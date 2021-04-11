<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use SpotifyWebAPI;

class SpotifyApiController extends BaseController
{
    public function index()
    {
        require __DIR__.'/../../../vendor/autoload.php';

        $session = new SpotifyWebAPI\Session(
            env('SPOTIFY_API_CLIENT_ID'),
            env('SPOTIFY_API_CLIENT_SECRET'),
            'http://0.0.0.0:80/spotify'
        );

        $api = new SpotifyWebAPI\SpotifyWebAPI();

        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());

        } else {
            header('Location: ' . $session->getAuthorizeUrl(array(
                'scope' => array(
                  'playlist-read-private',
                  'playlist-modify-private',
                  'user-read-private',
                  'playlist-modify'
                )
            )));
            die();
        }

        echo '<pre>';
            print_r($api->me()); //認証を受けたアカウントのプロフィールが表示される
        echo '</pre>';
    }
}
