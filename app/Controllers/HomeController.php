<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home.index');
    }

    public function show(int $id)
    {
        return $this->view('home.show', compact('id'));
    }
}