<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::get('/api/programs', [ProgramController::class, 'index']);

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);
