<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloaderController extends Controller
{
    public function index()
    {
        return view("pages.index");
    }

    public function downloader()
    {
        return view("pages.downloader");
    }
}
