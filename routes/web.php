<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home/index');
});

Route::get("/alttextviewer", [App\Http\Controllers\AltTextViewerController::class, "index"])->name("alttextviewer.index");
Route::get("/alttextviewer/enwiki/{page}", [App\Http\Controllers\AltTextViewerController::class, "view"])->where('page', '[\w\s\-_\/]+')->name("alttextviewer.result");
Route::post("/alttextviewer/submit", [App\Http\Controllers\AltTextViewerController::class, "submit"])->name("alttextviewer.submit");
