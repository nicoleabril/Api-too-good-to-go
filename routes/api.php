<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ClientesController;
use App\Http\Controllers\Api\RegistroController;
use App\Http\Controllers\Api\CategoriaNegocioController;
use App\Http\Controllers\Api\ComentarioController;
use App\Http\Controllers\Api\NegociosController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProductosController;
use App\Http\Controllers\Api\OfertaController;
use App\Http\Controllers\Api\ReservaController;
use App\Http\Controllers\Api\VentaController;
use App\Http\Controllers\Api\Productos_ReservadosController;


//RUTAS PARA INICIO Y CIERRE DE SESIÓN
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

//RUTAS PARA CRUD DE USUARIOS
Route::get('/usuarios', [UsersController::class, 'index']); // GET /api/v1/usuarios
Route::post('/usuarios', [UsersController::class, 'store']); // POST /api/v1/usuarios
Route::get('/usuarios_id/{id}', [UsersController::class, 'show']); // GET /api/v1/usuarios/{id}
Route::get('/usuarios_email/{email}', [UsersController::class, 'show_email']); // GET /api/v1/usuarios/{id}
Route::put('/usuarios/{id}', [UsersController::class, 'update']); // PUT /api/v1/usuarios/{id}
Route::delete('/usuarios/{id}', [UsersController::class, 'destroy']); // DELETE /api/v1/usuarios/{id}


//RUTAS PARA CRUD DE CLIENTES
Route::get('/clientes', [ClientesController::class, 'index']);
Route::post('/clientes', [ClientesController::class, 'store']);
Route::get('/clientes/{id}', [ClientesController::class, 'show']);
Route::post('/clientes/{id}', [ClientesController::class, 'update']);
Route::delete('/clientes/{id}', [ClientesController::class, 'destroy']);

//RUTAS PARA CRUD DE NEGOCIOS
Route::get('/negocios', [NegociosController::class, 'index']);
Route::post('/negocios', [NegociosController::class, 'store']);
Route::get('/negocios/{id}', [NegociosController::class, 'show']);
Route::post('/negocios/{id}', [NegociosController::class, 'update']);
Route::delete('/negocios/{id}', [NegociosController::class, 'destroy']);

//RUTAS PARA CRUD DE COMENTARIOS DEL CLIENTE A LOS NEGOCIOS
Route::get('/comentarios', [ComentarioController::class, 'index']);
Route::post('/comentarios', [ComentarioController::class, 'store']); //Crear un comentario
Route::post('/updateComentario/{id}', [ComentarioController::class, 'update']); //Actualizar un comentario
Route::get('/comentariosCliente/{id}', [ComentarioController::class, 'showComentarioxCliente']);
Route::get('/comentariosNegocios/{id}', [ComentarioController::class, 'showComentarioxNegocio']);
Route::delete('/comentarios/{id}', [ComentarioController::class, 'destroy']);


// Rutas para Categorías de Negocio
Route::get('/categorias-negocio', [CategoriaNegocioController::class, 'index']);
Route::post('/categorias-negocio', [CategoriaNegocioController::class, 'store']);
Route::get('/categorias-negocio/{id}', [CategoriaNegocioController::class, 'show']);
Route::put('/categorias-negocio/{id}', [CategoriaNegocioController::class, 'update']);
Route::delete('/categorias-negocio/{id}', [CategoriaNegocioController::class, 'destroy']);


// Rutas para Categorías de Cada Negocio
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::post('/categorias', [CategoriaController::class, 'store']);
Route::get('/categorias/{id}', [CategoriaController::class, 'show']);
Route::get('/categoria/{id}', [CategoriaController::class, 'showCategoria']);
Route::post('/categorias/{id}', [CategoriaController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);

// Rutas para Ofertas de Cada Negocio
Route::get('/ofertas', [OfertaController::class, 'index']);
Route::post('/ofertas', [OfertaController::class, 'store']);
Route::get('/ofertas/{id}', [OfertaController::class, 'show']);
Route::get('/oferta/{id}', [OfertaController::class, 'showOferta']);
Route::post('/ofertas/{id}', [OfertaController::class, 'update']);
Route::delete('/ofertas/{id}', [OfertaController::class, 'destroy']);

// Rutas para Categorías de Cada Negocio
Route::get('/productos', [ProductosController::class, 'index']);
Route::post('/productos', [ProductosController::class, 'store']);
Route::get('/producto/{id}', [ProductosController::class, 'showProducto']);
Route::get('/productos/{id}', [ProductosController::class, 'show']);
Route::post('/productos/{id}', [ProductosController::class, 'update']);
Route::delete('/productos/{id}', [ProductosController::class, 'destroy']);

//Ruta parael manejo de Ventas
Route::get('/ventas', [VentaController::class, 'index']);//Obtener todas las ventas
Route::post('/ventas', [VentaController::class, 'store']);//Crear una venta
Route::get('/ventas/{id}', [VentaController::class, 'showVentaxNegocio']);//Obtener una venta

//Ruta para el manejo de Reservas
Route::get('/reservas', [ReservaController::class, 'index']);//Obtener todas las reservas
Route::post('/reservas', [ReservaController::class, 'store']);//Crear una reserva
Route::get('/reservas/{id}', [ReservaController::class, 'showReservaxCliente']);//Obtener una reserva x cliente
Route::get('/reservasNegocio/{id}', [ReservaController::class, 'showReservaxNegocio']);//Obtener una reserva x negocio
Route::post('/reservas/{id}', [ReservaController::class, 'updateCancel']);//Actualizar a cancelado una reserva
Route::get('/reservasPendientes/{id}', [ReservaController::class, 'showReservaxNegocioPendiente']);//Obtener las reservas pendientes de un negocio
//----------------------------------------------------------
Route::get('/reservasEnProceso/{id}', [ReservaController::class, 'showReservaxNegocioEnProgreso']);//Obtener una reserva
Route::get('/reservasListas/{id}', [ReservaController::class, 'showReservaxNegocioListas']);//Obtener una reserva
Route::post('/confirmarReservaEnProceso/{id}', [ReservaController::class, 'updateEnProceso']);// cambiar el estado de una reserva a En Progreso
Route::post('/confirmarReservaFinalizadoSinEntrega/{id}', [ReservaController::class, 'updateFinalizaSinEntrega']);// cambiar el estado de una reserva a Finalizado sin Entrega
Route::post('/confirmarReservaEntregado/{id}', [ReservaController::class, 'updateEntregado']);// cambiar el estado de una reserva a Entregado
Route::post('/cancelarReserva/{id}', [ReservaController::class, 'updateCancelado']);//cambiar el estado de una reserva a Cancelado

//Rutas para el manejo de Productos Reservados-----------
Route::get('/productos_reservados', [Productos_ReservadosController::class, 'index']);//Obtener todos los productos reservados
Route::post('/productos_reservados', [Productos_ReservadosController::class, 'store']);//Crear un producto reservado
Route::get('/productos_reservados/{id}', [Productos_ReservadosController::class, 'showProductoReservadoxNegocio']);//Obtener un producto reservado x negocio 
Route::get('/productos_reservados_reserva/{id}', [Productos_ReservadosController::class, 'showProductoReservadoxReserva']);

//RUTAS DE ESTADISTICAS
Route::get('/producto-normal-mas-vendido/{id_negocio}', [VentaController::class, 'productoNormalMasVendido']);
Route::get('/producto-oferta-mas-vendida/{id_negocio}', [VentaController::class, 'productoOfertaMasVendida']);
Route::get('/total-clientes/{id_negocio}', [VentaController::class, 'totalClientes']);
Route::get('/compras-ordenadas/{id_negocio}', [VentaController::class, 'totalCompras']);
Route::get('/total-ganado/{id_negocio}', [VentaController::class, 'totalGanado']);
Route::get('/cantidad-clientes-mes-anio/{id_negocio}', [VentaController::class, 'cantidadClientesPorMesAnio']);
Route::get('/total-ordenado-mes-anio/{id_negocio}', [VentaController::class, 'totalOrdenadoPorMesAnio']);
Route::get('/total-ingreso-mes-anio/{id_negocio}', [VentaController::class, 'totalIngresoPorMesAnio']);

// Rutas para Clientes
Route::post('/registrar-cliente', [RegistroController::class, 'registrarCliente']);

// Rutas para Negocios
Route::post('/registrar-negocio', [RegistroController::class, 'registrarNegocio']);
// Rutas para modificar la contraseña
Route::post('/usuarios-cambio/{id}', [RegistroController::class, 'updateCliente']);

Route::get('/ventasCliente/{id}', [VentaController::class, 'showVentaxCliente']);//Obtener una venta