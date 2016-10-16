<?php

namespace Controller;
use Model\Entity\EgresoDetalle;
use Model\Resource\EgresoDetalleResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;

class EgresoDetalleController {

  public function listEgresosDeCompra($app, $idCompra){
  	$app->applyHook('must.be.administrador.or.gestion');
    echo $app->view->render( "egresos.twig", array('egresos' => (EgresoDetalleResource::getInstance()->get($idCompra))));
  }



   public function newEgresoDetalle($app,$compra, $producto,$cantidad,$precio_unitario, $egreso_tipo_id) {
        $app->applyHook('must.be.administrador.or.gestion');


        	if (EgresoDetalleResource::getInstance()->insert($compra, $producto,$cantidad,$precio_unitario, $egreso_tipo_id)){
        			ProductoResource::getInstance()->sumarStock($producto,$cantidad);
           			$app->flash('success', 'Producto dado de alta correctamente');
        	} else {
          			$app->flash('error', 'No se pudo dar de alta el producto');
        			}
        	echo $app->redirect('/compras');

      }

}
?>
