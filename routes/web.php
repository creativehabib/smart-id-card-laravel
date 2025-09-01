<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdSheetController;

Route::get('/', fn() => view('welcome'));

// Portrait (fronts -> backs)
Route::get('/idcards/preview',   [IdSheetController::class, 'preview'])->name('idcards.preview');
Route::get('/idcards/legal-pdf', [IdSheetController::class, 'pdf'])->name('idcards.legal.pdf');

// Landscape side-by-side (Front | Back)
Route::get('/idcards/preview-side',   [IdSheetController::class, 'previewSide'])->name('idcards.preview.side');
Route::get('/idcards/legal-pdf-side', [IdSheetController::class, 'pdfSide'])->name('idcards.legal.pdf.side');

// **Portrait side-by-side (Front | Back) – FIXED**
Route::get('/idcards/preview-side-portrait', [IdSheetController::class, 'previewSidePortrait'])
     ->name('idcards.preview.side.portrait');

Route::get('/idcards/legal-pdf-side-portrait', [IdSheetController::class, 'pdfSidePortrait'])
     ->name('idcards.legal.pdf.side.portrait');
