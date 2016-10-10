<?php

namespace Controller;
use Model\Entity\EgresoDetalle;
use Model\Resource\EgresoDetalleResource;

class EgresoDetalleController {

  public function listEgresosDeCompra($app, $idCompra){
    echo $app->view->render( "egresos.twig", array('egresos' => (EgresoDetalleResource::getInstance()->getEgresosDeCompra($idCompra)), 'compras' => ($idCompra)));
  }
  
}
?>