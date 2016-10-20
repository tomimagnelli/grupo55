<?php

namespace Controller;
use Model\Entity\IngresoDetalle;
use Model\Resource\IngresoDetalleResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\TipoIngreso;
use Model\Resource\TipoIngresoResource;

class IngresoDetalleController {


   public function showAltaVenta($app){
    echo $app->view->render( "altaventa.twig", array('productos' => (ProductoResource::getInstance()->get()), 'tiposingreso' => (TipoIngresoResource::getInstance()->get())));
  }

   public function showEditVenta($app,$id){
    $ingreso_detalle = IngresoDetalleResource::getInstance()->get($id);
    echo $app->view->render( "editingreso.twig", array('ingreso_detalle' => ($ingreso_detalle),'productos' => (ProductoResource::getInstance()->get()), 'tiposingreso' => (TipoIngresoResource::getInstance()->get())));
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

    public function deleteIngreso($app, $id) {
    $app->applyHook('must.be.administrador');
    if (IngresoDetalleResource::getInstance()->delete($id)) {
      $app->flash('success', 'Venta eliminada exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar venta');
    }
    $app->redirect('/ingresos');
  }

  public function edit($app,$producto,$cantidad,$precio_unitario,$ingreso_tipo_id,$descripcion,$id) {
    $app->applyHook('must.be.administrador');
    
    if (IngresoDetalleResource::getInstance()->editVenta($producto,$cantidad,$precio_unitario,$ingreso_tipo_id,$descripcion,$id)){
       $app->flash('success', 'La venta ha sido modificada exitosamente');
    } else {
      $app->flash('error', 'No se pudo modificar la venta');
    }
    echo $app->redirect('/ingresos');

   }
  }



?>
