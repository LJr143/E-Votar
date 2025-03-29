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

    public function WebsiteLogin()
    {
        return view('evotar.comelec-website.website-login');
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


    public function AddAnnouncement()
    {
        return view('evotar.comelec-website.add-announcement');
    }
    public function AboutUs()
    {
        return view('evotar.comelec-website.about-us');
    }
    public function DataPrivacy()
    {
        return view('evotar.comelec-website.data-privacy');
    }
    public function Policies()
    {
    return view('evotar.comelec-website.policies');
    }

}
