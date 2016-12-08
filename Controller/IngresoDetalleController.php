<?php

namespace Controller;
use Model\Entity\IngresoDetalle;
use Model\Resource\IngresoDetalleResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\Pedido;
use Model\Resource\PedidoResource;
use Model\Entity\PedidoDetalle;
use Model\Resource\PedidoDetalleResource;
use Model\Entity\TipoIngreso;
use Model\Resource\TipoIngresoResource;

class IngresoDetalleController {


   public function showAltaVenta($app,$token){
    echo $app->view->render( "altaventa.twig", array('productos' => (ProductoResource::getInstance()->get()), 'tiposingreso' => (TipoIngresoResource::getInstance()->get()),'token' =>$token));
  }

  public function showEditVenta($app,$id,$token){
   $ingreso_detalle = IngresoDetalleResource::getInstance()->get($id);
   echo $app->view->render( "editingreso.twig", array('ingreso_detalle' => ($ingreso_detalle),'productos' => (ProductoResource::getInstance()->get()), 'tiposingreso' => (TipoIngresoResource::getInstance()->get()),'token' =>$token));
 }



    public function showBusquedaIngresos($app, $desde, $hasta){
    $ingresosentre = IngresoDetalleResource::getInstance()-> buscar($desde, $hasta);
    $sumaingresos = IngresoDetalleResource::getInstance()-> sumaingresos($ingresosentre);
    $pedidos = IngresoDetalleResource::getInstance()-> buscarpedidos($desde, $hasta);
    $sumapedidos = IngresoDetalleResource::getInstance()-> sumaPedidos($pedidos);

    echo $app->view->render( "busquedaIngresos.twig", array('ingresos' => (IngresoDetalleResource::getInstance()->get()),'ingresosentre' => ($ingresosentre),'pedidos' => ($pedidos),'productos' => (ProductoResource::getInstance()->get()),'pedidosdetalle' => (PedidoDetalleResource::getInstance()->get()),'sumapedidos' => ($sumapedidos),'sumaingresos' => ($sumaingresos), 'desde' => ($desde), 'hasta' => ($hasta), 'tiposingreso' => (TipoIngresoResource::getInstance()->get())));
  }

  public function cargaTiposIngreso($app){
      $app->applyHook('must.be.administrador');
      echo $app->view->render( "altaventa.twig", array('tiposingreso' => (TipoIngresoResource::getInstance()->get())));

    }


    public function newIngresoDetalle($app,$ingreso_tipo_id,$producto_id,$cantidad,$precio_unitario, $descripcion,$token) {
      CSRF::getInstance()->control($app,$token);

        $app->applyHook('must.be.administrador.or.gestion');


        	if (IngresoDetalleResource::getInstance()->insert($ingreso_tipo_id,$producto_id,$cantidad,$precio_unitario,$descripcion)){
        			ProductoResource::getInstance()->descontarStock($producto_id,$cantidad);
           			$app->flash('success', 'Venta dada de alta correctamente');
        	} else {
          			$app->flash('error', 'No se pudo dar de alta la venta');
        			}
        	echo $app->redirect('/ingresos/page?id=1');

      }

    public function deleteIngreso($app, $id,$token) {
      CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.administrador');
    if (IngresoDetalleResource::getInstance()->delete($id)) {
      $app->flash('success', 'Venta eliminada exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar venta');
    }
    $app->redirect('/ingresos/page?id=1');
  }

  public function edit($app,$producto,$cantidad,$precio_unitario,$ingreso_tipo_id,$descripcion,$id,$token) {
    CSRF::getInstance()->control($app,$token);

    $app->applyHook('must.be.administrador');


      $data = IngresoDetalleResource::getInstance()->get($id);
      if ($data != null){
      $cantvieja = $data->getCantidad();
      ProductoResource::getInstance()->sumarStock($producto,$cantvieja);
      }


    if (IngresoDetalleResource::getInstance()->editVenta($producto,$cantidad,$precio_unitario,$ingreso_tipo_id,$descripcion,$id)){
        ProductoResource::getInstance()->descontarStock($producto,$cantidad);
       $app->flash('success', 'La venta ha sido modificada exitosamente');

    } else {
      $app->flash('error', 'No se pudo modificar la venta');
    }
    echo $app->redirect('/ingresos/page?id=1');

   }

   public function buscarIngresos ($app, $fechadesde, $fechahasta){
         $app->applyHook('must.be.administrador');
          if (IngresoDetalleResource::getInstance()->buscarIngresos($id)) {
                $app->flash('success', 'Busqueda finalizada');
          }
          else {
               $app->flash('error', 'No se encontraron resultados');
          }
          $app->redirect('/busquedaingresos');
   }

  }



?>
