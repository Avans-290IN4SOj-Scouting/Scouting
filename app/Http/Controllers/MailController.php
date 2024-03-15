<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index()
    {
        $mails = $this->getTestMails();
        return view('admin.mail', ["mails" => $mails]);
    }

    /**
     * This method is used to get test mails
     *
     * @return Mail[]
     */
    private function getTestMails() : array
    {
        return [
            new Mail([
                "date" => "2021-01-01",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-02",
                "receiver" => "janedoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-03",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-04",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-05",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-06",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-07",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
            new Mail([
                "date" => "2021-01-08",
                "receiver" => "johndoe@scouting.nl",
                "subject" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            ]),
        ];
    }
}
