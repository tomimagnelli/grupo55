<?php

namespace Controller;
use Model\Entity\Compra;
use Model\Resource\CompraResource;

class CompraController {

  public function listCompras($app){
    echo $app->view->render( "compras.twig", array('compras' => (CompraResource::getInstance()->get())));
  }
  

  public function newCompra($app,$proovedor,$proovedor_cuit) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (CompraResource::getInstance()->insert($nombre,$proovedor,$proovedor_cuit)){
       $app->flash('success', 'La compra ha sido dado de alta exitosamente');
    } else {
      $app->flash('error', 'No se pudo dar de alta la compra');
    }
    echo $app->redirect('/compras');
  }
}
?>
