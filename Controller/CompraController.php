<?php

namespace Controller;
use Model\Entity\Compra;
use Model\Resource\CompraResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;

class CompraController {

  public function listCompras($app){
    $app->applyHook('must.be.administrador.or.gestion');
    echo $app->view->render( "compras.twig", array('compras' => (CompraResource::getInstance()->get())));
  }


  public function showAltaCompra($app){
   echo $app->view->render( "altacompra.twig", array('productos' => (ProductoResource::getInstance()->get())));
 }


  public function newCompra($app,$proveedor,$proveedor_cuit,$producto_id) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (CompraResource::getInstance()->insert($proovedor,$proovedor_cuit)){
       $app->flash('success', 'La compra ha sido dado de alta exitosamente');
    } else {
      $app->flash('error', 'No se pudo dar de alta la compra');
    }
    echo $app->redirect('/compras');
  }
}
?>
