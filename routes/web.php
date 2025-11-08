<?php

use App\Http\Controllers\DownloaderController;
use Illuminate\Support\Facades\Route;

if (file_exists(__DIR__.'/Shipyard/shipyard.php')) require __DIR__.'/Shipyard/shipyard.php';

Route::controller(DownloaderController::class)->group(function () {
    Route::get("/", "index")->name("home");
    Route::get("downloader", "downloader")->name("downloader");
});
