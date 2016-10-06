<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\ConfiguracionResource;
use Model\Entity\Ubicacion;
use Model\Resource\UbicacionResource;

class HomeController {

   public function showHome($app){

    $configResource = ConfiguracionResource::getInstance();
    echo $app->view->render( "home.twig",
     array('tituloDescripcion' => ($configResource->get('tituloDescripcion')),
      'infoDescripcion' => ($configResource->get('infoDescripcion')),
      'imgDescripcion' => ($configResource->get('imgDescripcion')),
      'tituloMenu' => ($configResource->get('tituloMenu')),
      'infoMenu' => ($configResource->get('infoMenu')),
      'imgMenu' => ($configResource->get('imgMenu')), 'ubicaciones' => (UbicacionResource::getInstance()->get())));
  }
}
