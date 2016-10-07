<?php

namespace Controller;
use Controller\Validator;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Model\Entity\Ubicacion;
use Model\Resource\UbicacionResource;

class UsuarioController {

  public function listUsuarios($app){
    $app->applyHook('must.be.administrador');
    echo $app->view->render( "users.twig", array('usuarios' => (UsuarioResource::getInstance()->get()), 'ubicaciones' => (UbicacionResource::getInstance()->get())));
  }

  public function cargaUbicaciones($app){
      $app->applyHook('must.be.administrador');
      echo $app->view->render( "altausuario.twig", array('ubicaciones' => (UbicacionResource::getInstance()->get())));

    }

  public function newUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null) {
    $app->applyHook('must.be.administrador');
    $error = false;
    if (!Validator::hasLength(50, $nombre)) {
         $error = true;
         $app->flash('error', 'El nombre debe tener menos de 50 caracteres');
    }
    if (!$error) {
        if (UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id)){
           $app->flash('success', 'El usuario ha sido dado de alta exitosamente');
       } else {
          $app->flash('error', 'No se pudo dar de alta el usuario');
      }
    }
    echo $app->redirect('/users');
  }

  public function editUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null,$id) {
    $app->applyHook('must.be.administrador');
    if (UsuarioResource::getInstance()->edit($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id,$id)){
       $app->flash('success', 'El usuario ha sido modificado exitosamente');
    } else {
      $app->flash('error', 'No se pudo modificar el usuario');
    }
    echo $app->redirect('/users');
  }

  public function registrarUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id = 2,$email,$ubicacion_id = null ) {
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
    $app->redirect('/users');
  }

  public function showUsuario($app, $id){
    $app->applyHook('must.be.administrador');
    $user = UsuarioResource::getInstance()->get($id);
    $ubicacion = UsuarioResource::getInstance()->ubicacion($id);
    echo $app->view->render( "edituser.twig", array('usuario' => ($user), 'ubicacionUser' => ($ubicacion), 'ubicaciones' => (UbicacionResource::getInstance()->get())));
  }

}
