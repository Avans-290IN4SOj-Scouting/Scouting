<?php

namespace App\Services;

use Exception;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();

        // JSON credentials
        $this->client->setAuthConfig(storage_path('sensitive\\gmail\\scoutingazg-gmail-api-oauth-credentials.json'));
        $this->client->setRedirectUri(route('test.gmail-auth-callback'));

        // Offline access means the gmail api will only have to authenticate once
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        // https://developers.google.com/gmail/api/auth/scopes
        $this->client->setScopes([
            'https://www.googleapis.com/auth/gmail.send',
        ]);

        $accessToken = $this->client->getAccessToken();
        $accessTokenExpired = $this->client->isAccessTokenExpired();

        return redirect()->route('test.index')->with([
            'error', 'gmail auth error',
            'toast-type' => 'error',
            'toast-message' => 'Gmail API auth error',
        ]);

        dd($this->client->getRefreshToken());
        if ($accessTokenExpired)
        {
            // Als dit gebeurt kunnen er geen emails meer verstuurd worden
            // Moeten ff kijken hoe we dit snel en duidelijk kunnen communiceren
            // met een admin gezien er dan veel mis kan gaan.
            dd("Gmail Access token is expired!");
        }
        $authUrl = $this->client->createAuthUrl();

        dd($accessToken, $authUrl);
    }

    public function sendMail($receiver, $subject, $message)
    {
        $sender = "jrnjdeveloper@gmail.com";

        $service = new Gmail($this->client);
        $email = new Message();
        $email->setRaw(
            "From: $sender\r\n" .
            "To: $receiver\r\n" .
            "Subject: =?utf-8?B?" . base64_encode($subject) . "?=\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=utf-8\r\n" .
            "Content-Transfer-Encoding: quoted-printable" . "\r\n\r\n" .
            "$message\r\n"
        );

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
        $_SESSION['code_verifier'] = $this->client->getOAuth2Service()->generateCodeVerifier();
        $authUrl = $this->client->createAuthUrl();
        return $authUrl;
    }
}
