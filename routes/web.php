<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'home')->name('home');

Route::get('scan/{id}', function (string $id) {
    if (auth()->user()?->isEmployee()) {
        return redirect()->route('filament.dashboard.resources.scans.create', ['id' => $id]);
    }
    return redirect()->route('home', ['data' => $id]);
})->name('scan');