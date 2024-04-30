<?php

use App\Http\Controllers\crudController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/proxy-es-ES-json', function () {
    $response = Http::get('http://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json');
    return $response->body();
});

Route::get('/', [crudController::class, "index"])->name("crud.index");

Route::post("/registrar-persona", [crudController::class, "create"])->name("crud.create");

Route::post("/modificar-persona", [crudController::class, "update"])->name("crud.update");

Route::get("/eliminar-persona-{id}", [crudController::class, "delete"])->name("crud.delete");

Route::get('/generar-pdf', [crudController::class, 'generatePDF'])->name('crud.pdf');

Route::get('/generar-excel', [crudController::class, 'generateExcel'])->name('crud.excel');