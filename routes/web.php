<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

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
   return view('menu/welcome');
})->name('inicio');
Route::get('/quienessomos', [MenuController::class, 'quienessomos'])->name('quienes-somos');
Route::get('/como-asociarse', [MenuController::class, 'ComoAsociarse'])->name('como-asociarse');
Route::get('/ahorro', [MenuController::class, 'ahorro'])->name('ahorro');
Route::get('/creditos', [MenuController::class, 'creditos'])->name('creditos');
Route::get('/eventos', [MenuController::class, 'eventos'])->name('eventos');
Route::get('/auxilios', [MenuController::class, 'auxilios'])->name('auxilios');
Route::get('/convenio', [MenuController::class, 'convenio'])->name('convenio');
Route::get('/contactos', [MenuController::class, 'contactos'])->name('contactos');
Route::get('/descarga-de-documentos', [MenuController::class, 'descargadocumentos'])->name('descargadocumentos');
Route::get('/vista-galeria', [MenuController::class, 'vistagaleria'])->name('vistagaleria');
Route::get('/normatividad', [MenuController::class, 'normatividad'])->name('normatividad');
Route::get('/clasificados', [MenuController::class, 'clasificados'])->name('clasificados');
Route::get('/organigramas', [MenuController::class, 'organigramas'])->name('organigramas');
Route::get('/estructura', [MenuController::class, 'estructura'])->name('estructura');

Route::get('/dashboard', function () {
    // Verificar si el usuario está autenticado antes de acceder a Auth::user()->id
    if (Auth::check()) {
        //$user_id = Auth::user()->id;
        return redirect()->route('galeria');
    } else {
        // Redirigir a la página de inicio de sesión si el usuario no está autenticado
        return redirect()->route('login');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route::get('/cycles',[MenuController::class,'cycles'])->name('cycles');
    //Route::get('/item/{caracterizacion_id}',[MenuController::class,'itemEstandar'])->name('itemEstandar');
    // Route::get('/caracterizacion',[MenuController::class,'caracterizacion'])->name('caracterizacion');
    // Route::get('/item_base',[MenuController::class,'item_base'])->name('item_base');
    // Route::get('/grupo_base',[MenuController::class,'grupo_base'])->name('grupo_base');
    // Route::get('/criterio_base/{item_id}',[MenuController::class,'criterio_base'])->name('criterio_base');
    // Route::get('/evidencia_base/{criterio_id}',[MenuController::class,'evidencia_base'])->name('evidencia_base');



    //Route::get('/sgsst',[MenuController::class,'sgsst'])->name('sgsst');

    //Route::get('/admon',[MenuController::class,'admon'])->name('admon');
    //Route::get('/admon/{ciclo_id}',[MenuController::class,'estandar'])->name('estandar');
    //Route::get('/admon/{ciclo_id}/{estandar_id}',[MenuController::class,'item'])->name('item');
    // Route::get('/admon/{ciclo_id}/{estandar_id}/{item_id}',[MenuController::class,'criterio'])->name('criterio');
    //Route::get('/admon/{ciclo_id}/{estandar_id}/{item_id}/{criterio_id}',[MenuController::class,'evidencia'])->name('evidencia');

    //Route::get('/sgsst/{estandar_id}',[MenuController::class,'itemsgsst'])->name('itemsgsst');

    //Route::get('/estandarizacion',[MenuController::class,'estandarizacion'])->name('estandarizacion');
    //Route::get('/cronograma',[MenuController::class,'cronograma'])->name('cronograma');
    Route::get('/subroles', [MenuController::class, 'subroles'])->name('subroles');
    Route::get('/subusers', [MenuController::class, 'subusers'])->name('subusers');
    Route::get('/cv/{user_id?}', [MenuController::class, 'cv'])->name('cv');
    Route::get('/ficha/{user_id?}', [MenuController::class, 'ficha'])->name('ficha');
    Route::get('/formatos', [MenuController::class, 'formato'])->name('formato');
    Route::get('/editarcv/{user_id?}', [MenuController::class, 'editarcv'])->name('editarcv');
    Route::get('/cargos', [MenuController::class, 'cargos'])->name('cargos');
    Route::get('/upload_formatos', [MenuController::class, 'upload_formatos'])->name('upload_formatos');
    Route::get('/solicitudes', [MenuController::class, 'solicitudes'])->name('solicitudes');
    Route::get('/gestionar_solicitudes', [MenuController::class, 'gestionar_solicitudes'])->name('gestionar_solicitudes');
    Route::get('/planes', [MenuController::class, 'planes'])->name('planes');
    Route::get('/portal', [MenuController::class, 'portal'])->name('portal');
    Route::get('/organigrama', [MenuController::class, 'organigrama'])->name('organigrama');
    Route::get('/importarusuarios', [MenuController::class, 'importarusuarios'])->name('importarusuarios');
    Route::get('/log', [MenuController::class, 'log'])->name('log');
    Route::get('/logtraslados', [MenuController::class, 'logtraslados'])->name('logtraslados');
    Route::get('/tratamientodatos', [MenuController::class, 'tratamientodatos'])->name('tratamientodatos');
    Route::get('/trasladarusuarios', [MenuController::class, 'trasladarusuarios'])->name('trasladarusuarios');

    Route::get('/perfilempresa', [MenuController::class, 'perfilempresa'])->name('perfilempresa');

Route::get('/grupos', [MenuController::class, 'grupos'])->name('grupos');

Route::get('/habitacion', [MenuController::class, 'habitacion'])->name('habitacion');
Route::get('/reserva', [MenuController::class, 'reserva'])->name('reserva');
Route::get('/salon_eventos', [MenuController::class, 'salon_eventos'])->name('salon_eventos');
Route::get('/reserva_salon', [MenuController::class, 'reserva_salon'])->name('reserva_salon');
Route::get('/cliente', [MenuController::class, 'cliente'])->name('cliente');
Route::get('/tipo_habitacion', [MenuController::class, 'tipo_habitacion'])->name('tipo_habitacion');
Route::get('/metodos_pago', [MenuController::class, 'metodos_pago'])->name('metodos_pago');
//Route::get('/imagenes', [MenuController::class, 'imagenes'])->name('imagenes');
Route::get('/slider', [MenuController::class, 'slider'])->name('slider');
Route::get('/tarjetas', [MenuController::class, 'tarjetas'])->name('tarjetas');
Route::get('/beneficios', [MenuController::class, 'beneficios'])->name('beneficios');
Route::get('/galeria', [MenuController::class, 'galeria'])->name('galeria');
Route::get('/convenios', [MenuController::class, 'convenios'])->name('convenios');
Route::get('/redessociales', [MenuController::class, 'redessociales'])->name('redessociales');
Route::get('/contacto', [MenuController::class, 'contacto'])->name('contacto');
Route::get('/header', [MenuController::class, 'header'])->name('header');
Route::get('/footer', [MenuController::class, 'footer'])->name('footer');
Route::get('/asociacion', [MenuController::class, 'asociacion'])->name('asociacion');
Route::get('/quienes_somos', [MenuController::class, 'quienes_somos'])->name('quienes_somos');
Route::get('/credito', [MenuController::class, 'credito'])->name('credito');
Route::get('/grupo_convenios', [MenuController::class, 'grupo_convenios'])->name('grupo_convenios');




    Route::group(['middleware' => 'admin'], function () {
        //ADMINISTRACION
        Route::get('/settings', [MenuController::class, 'settings'])->name('settings');
        Route::get('/modules', [MenuController::class, 'modules'])->name('modules');
        Route::get('/submodules', [MenuController::class, 'submodules'])->name('submodules');
        Route::get('/roles', [MenuController::class, 'roles'])->name('roles');
        Route::get('/users', [MenuController::class, 'users'])->name('users');
        Route::get('/enterprises', [MenuController::class, 'enterprises'])->name('enterprises');
        Route::get('/categories', [MenuController::class, 'categories'])->name('categories');
    });
});




require __DIR__ . '/auth.php';
Route::get('/gestionar_clasificados', [MenuController::class, 'gestionar_clasificados'])->name('gestionar_clasificados');
