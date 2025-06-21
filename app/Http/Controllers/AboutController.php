<?php

namespace App\Http\Controllers;

class AboutController{
    public function showAboutPage(){
        return view('pages.aboutUs');
    }
}
