<?php

namespace Controller;
use Model\Entity\User;
use Model\Resource\UserResource;
use Model\Entity\Ubicacion;
use Model\Resource\UbicacionResource;

class UsuarioController {

  public function listUsuarios($app){
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "usuarios/index.twig", array('usuarios' => (UsuarioResource::getInstance()->get()), 'ubicaciones' => (UbicacionResource::getInstance()->get())));
  }

  public function newUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id) {
    $app->applyHook('must.be.administrador');
    if (UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id)){
       $app->flash('success', 'El usuario ha sido dado de alta exitosamente');
    } else {
      $app->flash('error', 'No se pudo dar de alta el usuario');
    }
    echo $app->redirect('/usuarios');
  }

  public function registrarUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id = 2,$email,$ubicacion_id ) {
    if (UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id)){
       $app->flash('success', 'El registro se ha realizado con éxito');
    } else {
      $app->flash('error', 'No se pudo dar de alta el usuario');
    }
    echo $app->redirect('/');
  }

  public function deleteUsuario($app, $id) {
    $app->applyHook('must.be.administrador');
    if (UsuarioResource::getInstance()->delete($id)) {
      $app->flash('success', 'El usuario ha sido eliminado exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar el usuario');
    }
    $app->redirect('/usuarios');
  }

  public function showUsuario($app, $id){
    $app->applyHook('must.be.administrador');
    $user = UsuarioResource::getInstance()->get($id);
    echo $app->view->render( "usuarios/show.twig", array('usuario' => ($user), (UbicacionResource::getInstance()->get($user['id']))));
  }

}
