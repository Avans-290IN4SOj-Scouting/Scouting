<?php

namespace App\Services;

use Illuminate\Http\Request;
use Exception;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Google_Client;
use Illuminate\Support\Facades\Storage;

class GmailService
{
    protected $client;
    private $accessToken;
    private $refreshToken;
    private $email;

    public function __construct()
    {
        // Working with files
        try
        {
            // // Create Client
            $this->client = new Google_Client();
            $this->email = env('GMAIL_FROM_ADDRESS');

            // // Authentication URI
            // $this->client->setRedirectUri(route('gmail.auth-callback'));

            // // Credentials
            // $this->client->setAuthConfig(storage_path('app/sensitive/gmail/scoutingazg-gmail-api-oauth-credentials.json'));
            // // // // // $this->client->setAuthConfig(Storage::disk('local')->get('sensitive/gmail/scoutingazg-gmail-api-oauth-credentials.json'));
            // $this->client->setSubject($this->email);

            // // Offline access means the gmail api will only have to authenticate once / refresh token
            // $this->client->setAccessType('offline');
            // $this->client->setPrompt('select_account consent');
            // $this->client->setApprovalPrompt('force');

            // // https://developers.google.com/gmail/api/auth/scopes
            // $this->client->setScopes([
            //     'https://www.googleapis.com/auth/gmail.send',
            // ]);

            // Get stored Tokens
            // $this->accessToken = $this->getAccessToken();
            // $this->refreshToken = $this->getRefreshToken();
            $this->accessToken = storage_path('app/sensitive/gmail/access_token.txt');
            $this->refreshToken = storage_path('app/sensitive/gmail/refresh_token.txt');
            // if (empty($this->accessToken) || empty($this->refreshToken))
            // {
            //     return redirect()->back()->with([
            //         'error', 'gmail auth error',
            //         'toast-type' => 'error',
            //         'toast-message' => __('gmail.auth-not-set'),
            //     ]);
            // }

            // // Ensure access token is set
            // $this->client->setAccessToken($this->accessToken);
            // if ($this->client->isAccessTokenExpired())
            // {
            //     $this->client->refreshToken($this->refreshToken);
            //     $this->client->setAccessToken($this->client->getAccessToken());
            // }
        }
        catch (Exception $exception)
        {
            dd($exception);
            return redirect()->route('test.index')->with([
                'error', 'gmail auth error',
                'toast-type' => 'error',
                'toast-message' => __('gmail.general-auth-error'),
            ]);
        }
    }

    public function sendMail($receiver, $subject, $message)
    {
        // base64_encode can cause issues if mail is invalid
        try
        {
            $service = new Gmail($this->client);
            $email = new Message();
            $email->setRaw(base64_encode(
                "From: $this->email\r\n" .
                "To: $receiver\r\n" .
                "Subject: =?utf-8?B?" . $subject . "?=\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-Type: text/html; charset=utf-8\r\n" .
                "Content-Transfer-Encoding: quoted-printable" . "\r\n\r\n" .
                "$message\r\n"
            ));

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
        // If AuthURL does not match the one in the google cloud console, it will not work and throw an error
        try
        {
            session(['code_verifier' => $this->client->getOAuth2Service()->generateCodeVerifier()]);
            $authUrl = $this->client->createAuthUrl();
            return $authUrl;
        }
        catch (Exception $exception)
        {
            return null;
        }
    }

    public function authenticate_callback(Request $request)
    {
        // If callback url is called directly by a user without calling the
        // breeze authenticated route first, the process will throw an error
        //
        // It's impossible to authorize this route as Gmail has to view it as
        // an unauthorized user
        try
        {
            $code = $request->input('code');
            $codeVerifier = session('code_verifier');
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($code, $codeVerifier);

            if (!isset($accessToken['error']))
            {
                $this->setAccessToken($accessToken['access_token']);
                $this->setRefreshToken($accessToken['refresh_token']);
                return ['type' => 'success', 'message' => __('gmail.auth-success')];
            }
            else
            {
                return ['type' => 'error', 'message' => __('gmail.general-auth-error')];
            }
        }
        catch (Exception $exception)
        {
            return ['type' => 'error', 'message' => __('gmail.user-not-allowed')];
        }
    }

    // Safer handling for accessing tokens
    // Tokens are stored in files
    // a database is suitable, but with each re-seed, the proces has to be done again.
    // Preferably don't call these methods unless its in the constructor of this Service
    private function setAccessToken($accessToken)
    {
        // Working with files
        try
        {
            Storage::disk('local')->put('sensitive/gmail/access_token.txt', $accessToken);
            $this->client->setAccessToken($accessToken);
        }
        catch (Exception $exception)
        { }
    }
    private function getAccessToken()
    {
        // Working with files
        try
        {
            // if (Storage::disk('local')->exists('sensitive/gmail/access_token.txt'))
            // {
            //     return Storage::disk('local')->get('sensitive/gmail/access_token.txt');
            // }
            // else
            // {
            //     return null;
            // }
            return storage_path('app/sensitive/gmail/access_token.txt');
        }
        catch (Exception $exception)
        {
            return null;
        }
    }

    private function setRefreshToken($refreshToken)
    {
        // Working with files
        try
        {
            Storage::disk('local')->put('sensitive/gmail/refresh_token.txt', $refreshToken);
            $this->client->refreshToken($refreshToken);
        }
        catch (Exception $exception)
        { }
    }
    private function getRefreshToken()
    {

        // Working with files
        try
        {
            // if (Storage::disk('local')->exists('sensitive/gmail/refresh_token.txt'))
            // {
            //     return Storage::disk('local')->get('sensitive/gmail/refresh_token.txt');
            // }
            // else
            // {
            //     return null;
            // }
            return storage_path('app/sensitive/gmail/refresh_token.txt');
        }
        catch (Exception $exception)
        {
            return null;
        }
    }
}
