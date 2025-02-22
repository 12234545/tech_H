<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home/home');
    }

    public function history()
    {
        return view('home/history');
    }
    public function about()
    {
        return view('home/about');
    }

    public function dashboard()
    {
        return view('home/dashboard');
    }


    public function ourService()
    {
        return view('home/ourServices');
    }


    public function choix(){
        return view('home/choixlogin');
    }

    public function choixsingUp(){
        return view('home/choisSingUp');
    }



}
