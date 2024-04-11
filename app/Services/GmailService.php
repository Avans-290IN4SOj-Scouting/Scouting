<?php

namespace App\Services;

use Illuminate\Http\Request;
use Exception;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    protected $client;
    private $email = 'jrnjdeveloper@gmail.com';
    private $accessToken = 'ya29.a0Ad52N39W8E966xwe2Yc3dZxahpvqmjikxWeyX5LkTqpfgl8ikNGfBAFOPXnmmGmSJH8QwpFi19snTC13X3yh_9qQm3NJ8TnetKjhiNHo50gMIpHljzfPCQOHNRdg_suajrv4bYrlFBbeE7fKfpHmT3YXraBGFMMREjjdaCgYKAe4SARMSFQHGX2MiNlIeJnxdr2BZu-ZhLhd5Fg0171';
    private $refreshToken = '1//09otmqi4NF5lMCgYIARAAGAkSNwF-L9Ir6bzZFY-SvfdfHMnvofC4rJVe6oL6VGgLvf6lLbtlCX16HcQwC5AgiPVrKrIRPFy1cJs';

    public function __construct()
    {
        $this->client = new Client();

        // Credentials
        $this->client->setAuthConfig(storage_path('sensitive/gmail/scoutingazg-gmail-api-oauth-credentials.json'));
        $this->client->setSubject($this->email);

        // Authentication URI
        $this->client->setRedirectUri(route('test.gmail-auth-callback'));

        // Offline access means the gmail api will only have to authenticate once / refresh token
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->client->setApprovalPrompt('force');

        // https://developers.google.com/gmail/api/auth/scopes
        $this->client->setScopes([
            'https://www.googleapis.com/auth/gmail.send',
        ]);

        //
        $this->client->setAccessToken($this->accessToken);
        if ($this->client->isAccessTokenExpired())
        {
            $this->client->refreshToken($this->refreshToken);
            $this->client->setAccessToken($this->client->getAccessToken());
            // $this->client->fetchAccessTokenWithRefreshToken($this->refreshToken);
        }
    }

    public function sendMail($receiver, $subject, $message)
    {
        $service = new Gmail($this->client);
        $email = new Message();
        // $email->setRaw(
        //     "From: $this->email\r\n" .
        //     "To: $receiver\r\n" .
        //     "Subject: =?utf-8?B?" . base64_encode($subject) . "?=\r\n" .
        //     "MIME-Version: 1.0\r\n" .
        //     "Content-Type: text/html; charset=utf-8\r\n" .
        //     "Content-Transfer-Encoding: quoted-printable" . "\r\n\r\n" .
        //     "$message\r\n"
        // );
        $email->setRaw(base64_encode(
            "From: $this->email\r\n" .
            "To: $receiver\r\n" .
            "Subject: =?utf-8?B?" . $subject . "?=\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=utf-8\r\n" .
            "Content-Transfer-Encoding: quoted-printable" . "\r\n\r\n" .
            "$message\r\n"
        ));

        try
        {
            $service->users_messages->send("me", $email);
        }
        catch (Exception $exception)
        {
            return $exception;
        }

        return null;
    }

    public function authenticate()
    {
        session(['code_verifier' => $this->client->getOAuth2Service()->generateCodeVerifier()]);
        $authUrl = $this->client->createAuthUrl();
        return $authUrl;
    }

    public function authenticate_callback(Request $request)
    {
        $code = $request->input('code');
        $codeVerifier = session('code_verifier');
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code, $codeVerifier);

        if (!isset($accessToken['error']))
        {
            $this->client->setAccessToken($accessToken);
            dd($accessToken);
            return null;
        }
        else
        {
            return $accessToken;
        }
    }
}
