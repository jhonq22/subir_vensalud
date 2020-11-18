<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Users
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::get('profile', 'UserController@getAuthenticatedUser');
Route::put('usuarios_subir_foto/{$user_id}', 'UserController@ActualizarFoto');




//CRUD USERS
Route::resource('usuarios', 'UserController');


// Equipos 
Route::resource('equipos', 'EquipoController');


//CRUD Multimedia Inventario
Route::resource('multimedia_inventario', 'MultimediaInventarioController');

Route::get('multimedia_inventario/galeria/{inventario_id}', 
	'MultimediaInventarioController@InventarioGaleriaFotos');



Route::resource('historico_estatus', 'HistoricoEstatuController');
Route::get('historico_estatu_equipo/{historico_id}', 'HistoricoEstatuController@VerHistoricoEstatus');


// COMBO LIST
Route::resource('estados','EstadoController');
Route::resource('municipios','MunicipioController');
Route::resource('entes',      'EnteController');
//  CENTRO SALUD
Route::resource('centro_salud', 'CentroSaludController');
Route::get('centro_salud_list', 'CentroSaludController@centrosaludList');
//  CENTRO SALUD



Route::resource('estatus_equipos', 'EstatuEquipoController');

Route::resource('marcas', 'MarcaController');

Route::resource('equipos_respuestos', 'EquiposRespuestoController');

// DETALLES REPUESTO //
Route::resource('detalle_respuesto', 'DetalleRespuestoController');
Route::get('detalle_respuesto_inventario/{inventario_id}','DetalleRespuestoController@detallesMisRespuestosInventarios');
Route::get('respuesto/solicitados', 'DetalleRespuestoController@ListadoRespuestosSolicitados');




//  INVENTARIO
Route::resource('inventarios', 'InventarioController');
Route::get('inventarios/detallado/{inventario_id}','InventarioController@InventarioDetallada');


Route::get('inventario/no','InventarioController@equiposno');

//INVENTARIO LISTADO POR CENTRO DE SALUD
Route::get('inventarios/centrosalud/{inventario_id}','InventarioController@InventarioPorCentroSalud');

// VERIFICAR SI EXISTE LA MARCA
Route::get('inventarios/marca/{marca_id}/{serial}','InventarioController@inventarioMarcaDuplicado');

// TABLAS EQUIPOS
Route::get('inventario/tabla','InventarioController@TablaEquipos');



//ESTADISTICA //
Route::get('inventario/contar_equipos', 'InventarioController@EstatusEquiposInventariosContar');




Route::get('inventario/contar_equipos/estados/{inventario_id}', 'InventarioController@EstatusEquiposInventariosContarEstados');



Route::get('inventario/contar_equipos/centrosalud/{inventario_id}', 'InventarioController@EstatusEquiposInventariosContarCentroSalud');


Route::get('inventario/total/estados/{inventario_id}', 'InventarioController@totalInventarioPorEstados');

Route::get('inventario/total/centrosalud/{inventario_id}', 'InventarioController@totalInventarioPorCentroSalud');
Route::get('inventario/total', 'InventarioController@totalInventario');

Route::get('users/total_usuarios', 'UserController@totalUsuarios');






// REPORTES INVENTARIOS POR ESTADOS //
Route::get('inventario/reportes/estadal/{estado_id}', 'InventarioController@ReporteInventarioEstadal');

Route::get('inventario/reportes/municipal/{municipio_id}', 'InventarioController@ReporteInventarioMunicipal');

Route::get('inventario/reportes/centro_salud/{centro_salud_id}', 'InventarioController@ReporteInventarioCentroSalud');


// REPORTES INVENTARIOS POR ESTADOS Y ESTATUS //
Route::get('inventario/reportes/estadal/estatus/{estado_id}/{estatu_equipo_id}', 'InventarioController@ReporteInventarioEstadalPorEstatus');

Route::get('inventario/reportes/municipal/estatus/{municipio_id}/{estatu_equipo_id}', 'InventarioController@ReporteInventarioMunicipalPorEstatus');

Route::get('inventario/reportes/centro_salud/estatus/{centro_salud_id}/{estatu_equipo_id}', 'InventarioController@ReporteInventarioCentroSaludPorEstatus');





// REPORTES INVENTARIOS POR ESTADOS Y REPARADOS //
Route::get('inventario/reportes/estadal/reparado/{estado_id}/{reparado}', 'InventarioController@ReporteInventarioEstadalPorReparados');

Route::get('inventario/reportes/municipal/reparado/{municipio_id}/{reparado}', 'InventarioController@ReporteInventarioMunicipalPorReparados');

Route::get('inventario/reportes/centro_salud/reparado/{centro_salud_id}/{reparado}', 'InventarioController@ReporteInventarioCentroSaludPorReparados');








Route::get('inventario/reportes/buscar_equipo/{equipo}', 'InventarioController@ReporteInventarioBuscarEquipo');





Route::resource('historico_inventario', 'HistoricoInventarioController');
// INVENTARIO












// importar excel
Route::post('import', 'InventarioController@import')->name('import');