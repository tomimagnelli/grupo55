<?php

namespace Controller;
use Model\Entity\EgresoDetalle;
use Model\Resource\EgresoDetalleResource;

class EgresoDetalleController {

  public function listEgresosDeCompra($app, $idCompra){
  	$app->applyHook('must.be.administrador.or.gestion');
    echo $app->view->render( "egresos.twig", array('egresos' => (EgresoDetalleResource::getInstance()->getEgresosDeCompra($idCompra))));
  }

}
?>
