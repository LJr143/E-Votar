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


    public function UserFeedback()
    {
        return view('evotar.comelec-website.user-feedback');
    }


}
