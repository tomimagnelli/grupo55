<?php

namespace Controller;
use Model\Entity\Usuario;
use Model\Resource\ConfiguracionResource;

class ConfigController {

   public function showConfig($app){
      $app->applyHook('must.be.administrador');
      $configResource = ConfiguracionResource::getInstance();
      echo $app->view->render( "config.twig",
       array('tituloDescripcion' => ($configResource->get('tituloDescripcion')),
      'infoDescripcion' => ($configResource->get('infoDescripcion')),
      'imgDescripcion' => ($configResource->get('imgDescripcion')),
      'tituloMenu' => ($configResource->get('tituloMenu')),
      'infoMenu' => ($configResource->get('infoMenu')),
      'imgMenu' => ($configResource->get('imgMenu'))));
  }

 public function setPaginacion($app,$value) {
    $app->applyHook('must.be.administrador');
    ConfiguracionResource::getInstance()->edit('paginacion',$value);
    echo $app->redirect('/config');
  }

public function setTituloDescripcion($app,$value) {
    $app->applyHook('must.be.administrador');
    ConfiguracionResource::getInstance()->edit('tituloDescripcion',$value);
 }

  public function setInfoDescripcion($app,$value) {
    $app->applyHook('must.be.administrador');
    ConfiguracionResource::getInstance()->edit('infoDescripcion',$value);
  }

  public function setImgDescripcion($app) {
    $app->applyHook('must.be.administrador');
  	if (isset($_FILES["myFileInfo"])) {
  	     $target_path = "img/";
	        $target_path = $target_path . basename( $_FILES["myFileInfo"]['name']);
           move_uploaded_file($_FILES["myFileInfo"]['name'], $target_path);
            ConfiguracionResource::getInstance()->edit('imgDescripcion',$target_path);
    }
  }

 public function setDescripcion($app,$titulo,$descripcion) {
    $app->applyHook('must.be.administrador');
  	$this->setTituloDescripcion($app,$titulo);
  	$this->setInfoDescripcion($app,$descripcion);
  	$this->setImgDescripcion($app);
    echo $app->redirect('/config');
 }

 public function setTituloMenu($app,$value) {
    ConfiguracionResource::getInstance()->edit('tituloMenu',$value);
 }

 public function setInfoMenu($app,$value) {
    ConfiguracionResource::getInstance()->edit('infoMenu',$value);
 }

public function setImgMenu($app) {
    if (isset($_FILES["myFileMenu"])) {
  	$target_dir = "img/";
	$target_file = $target_dir .  basename( $_FILES["myFileMenu"]["name"]);
    move_uploaded_file($_FILES["myFileMenu"]["name"], $target_file);
    ConfiguracionResource::getInstance()->edit('imgMenu',$target_file);
	}
  }
  public function setMenu($app,$titulo,$descripcion) {
    $app->applyHook('must.be.administrador');
  	$this->setTituloMenu($app,$titulo);
  	$this->setInfoMenu($app,$descripcion);
  	$this->setImgMenu($app);
    echo $app->redirect('/config');
  }

}
