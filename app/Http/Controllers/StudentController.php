<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller {

    public function index() {
        $name = "Robin Hood Pandey";
        $age = "34";
//        return view('home',compact('name', 'age'));
//                return view('home')
//                        ->with('names',$name)
//                        ->with('ages',$age);

        return view('home', [
            'names' => $name,
            'ages' => $age
        ]);
    }

    public function add() {
        return 'Hello About';
    }

}
