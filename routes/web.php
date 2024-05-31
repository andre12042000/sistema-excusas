<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\DownloadController;
use App\Http\Livewire\Excusas\ExcusasComponent;
use App\Http\Livewire\Estudiantes\CreateComponent;
use App\Http\Livewire\Perfil\UpdatePerfilComponent;
use App\Http\Livewire\Estudiantes\EstudiantesComponent;
use App\Http\Livewire\Seguridad\EstudiantesAllComponent;
use App\Http\Livewire\Seguridad\ProfesorExcusaComponent;
use App\Http\Livewire\Notification\NotificationComponent;
use App\Http\Livewire\Seguridad\ExcusasGeneralesComponent;
use App\Http\Livewire\Seguridad\AutorizacionExcusaComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes([
    'register' => false
]);
Route::get('/envio/correo/{comprobante}', [ExportController::class, 'enviarcorreo'])->name('envio.correo');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth', 'change.password')->name('home');

Route::middleware(['auth', 'change.password'])->group(function () {
Route::get('estudiantes/listar', EstudiantesComponent::class)->name('list.estudiantes');
Route::get('excusas/listar', ExcusasComponent::class)->name('list.excusas');
Route::get('actualizar/perfil', UpdatePerfilComponent::class)->name('actualizar.perfil');
Route::get('administracion/autorizacion', AutorizacionExcusaComponent::class)->name('autorizacion.excusa');
Route::get('excusas/aprovadas', ProfesorExcusaComponent::class)->name('excusa.aprovadas');
Route::get('excusas/aprovadas/generales', ExcusasGeneralesComponent::class)->name('excusa.generales');

Route::get('seguridad/estudiantes', EstudiantesAllComponent::class)->name('estudiantes.seguridad');


Route::get('/import-usuarios', [App\Http\Controllers\ImportController:: class, 'index'])->name('import.index');
Route::get('/import-estudiantes', [App\Http\Controllers\ImportController:: class, 'indexestudiantes'])->name('import.index.estudiantes');

Route::post('/import/excel', [App\Http\Controllers\ImportController:: class, 'importExcel'])->name('import.excel');
Route::post('/import/excel/estudiantes', [App\Http\Controllers\ImportController:: class, 'importExcelEstudiantes'])->name('import.excel.estudiantes');


Route::get('notificaciones/', NotificationComponent::class)->name('notificaciones.index');
Route::get('notifications/get', [App\Http\Controllers\NotificationsController::class, 'getNotificationsData'])->name('notifications.get');

Route::post('/mark-as-read', [App\Http\Controllers\NotificationsController::class, 'markNotification'])->name('markNotification');

Route::get('markAsRead', function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markAsRead');
});


Route::get('perfil', [PerfilController::class, 'index'])->middleware('auth')->name('perfil');
Route::get('/download/{documento}', [DownloadController::class, 'download'])->name('file.download')->middleware('change.password', 'auth');


