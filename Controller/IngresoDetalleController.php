<?php

namespace Controller;
use Model\Entity\IngresoDetalle;
use Model\Resource\IngresoDetalleResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\TipoIngreso;
use Model\Resource\TipoIngresoResource;

class IngresoDetalleController {

  public function listIngresos($app){
  	$app->applyHook('must.be.administrador.or.gestion');
    echo $app->view->render( "ingresos.twig", array('ingresos' => (IngresoDetalleResource::getInstance()->getIngresosDeCompra()), 'productos' => (ProductoResource::getInstance()->get())));
  }

   public function showAltaVenta($app){
    echo $app->view->render( "altaventa.twig", array('productos' => (ProductoResource::getInstance()->get()), 'tiposingreso' => (TipoIngresoResource::getInstance()->get())));
  }

  public function cargaTiposIngreso($app){
      $app->applyHook('must.be.administrador');
      echo $app->view->render( "altaventa.twig", array('tiposingreso' => (TipoIngresoResource::getInstance()->get())));

    }


    public function newIngresoDetalle($app,$ingreso_tipo_id,$producto_id,$cantidad,$precio_unitario, $descripcion) {
        $app->applyHook('must.be.administrador.or.gestion');


        	if (IngresoDetalleResource::getInstance()->insert($ingreso_tipo_id,$producto_id,$cantidad,$precio_unitario,$descripcion)){
        			ProductoResource::getInstance()->descontarStock($producto_id,$cantidad);
           			$app->flash('success', 'Venta dada de alta correctamente');
        	} else {
          			$app->flash('error', 'No se pudo dar de alta la venta');
        			}
        	echo $app->redirect('/ingresos');

      }

}
?>
