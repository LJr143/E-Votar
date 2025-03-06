<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{

    public function Home()
    {
        return view('evotar.comelec-website.home');
    }

    public function Tutorial()
    {
        return view('evotar.comelec-website.tutorial');
    }

    public function List0fElections()
    {
        return view('evotar.comelec-website.list-of-elections');
    }


    public function ContactUs()
    {
        return view('evotar.comelec-website.contact-us');
    }

    public function UserFeedback()
    {
        return view('evotar.comelec-website.user-feedback');
    }

    public function FAQs()
    {
        return view('evotar.comelec-website.faqs');
    }


    public function SelectedAnnouncement()
    {
        return view('evotar.comelec-website.selected-announcement');
    }

    public function SelectedElection()
    {
        return view('evotar.comelec-website.selected-election');
    }

    public function SelectedPartylist()
    {
        return view('evotar.comelec-website.selected-partylist');
    }


}
