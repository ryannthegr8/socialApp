<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class exampleController extends Controller
{
    public function homePage(){
        //Imagine we loader data from database
        $ourName = 'Ryan';
        $Animals = ['Cat', 'Dog', 'Cow', 'Leopard'];

        return view('homepage', ['allAnimals' => $Animals, 'name' => $ourName, 'catName' => 'meows']);
    }

    public function aboutPage(){
        return view('about');
    }
}
