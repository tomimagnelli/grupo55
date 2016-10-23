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

  public function newUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null,$habilitado) {
    $app->applyHook('must.be.administrador');
    $errors = [];
      if (!Validator::hasLength(45, $nombre)) {
           $errors[] = 'El nombre debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(45, $apellido)) {
           $errors[] = 'El apellido debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(45, $user)) {
           $errors[] = 'El username debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(20, $pass)) {
           $errors[] = 'La contraseña debe tener menos de 20 caracteres';
      }
      if (!Validator::hasNumbers($pass)) {
           $errors[] = 'La contraseña debe tener una combinación de números y caracteres';
      }
      if(!Validator::isEmail($email)) {
          $errors[] = 'Debe ser un email válido';
      }
      if(!Validator::isNumeric($documento)) {
          $errors[] = 'El documento debe ser numérico';
      }
      if(!Validator::hasLength(8,$documento)) {
          $errors[] = 'El documento debe tener 8 números';
      }
      if(!Validator::isNumeric($telefono)) {
          $errors[] = 'El teléfono debe ser numérico';

          }

    $existeusuario = UsuarioResource::getInstance()->existeUsuario($user);
    if (!$existeusuario){
         $error = true;
        $app->flash('error', 'No se puede dar de alta. Ya existe ese nombre de usuario');
        echo $app->redirect('/users/altausuario');

    }
    if (sizeof($errors) == 0) {
      if (UsuarioResource::getInstance()->insert($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id,$habilitado)){
        $app->flash('success', 'El usuario ha sido dado de alta exitosamente');
        echo $app->redirect('/users/page?id=1');
      } else {
        $app->flash('error', 'No se pudo dar de alta el usuario');
        echo $app->redirect('/users/altausuario');
      }
    } else {
      $app->flash('errors', $errors);
      echo $app->redirect('/users/altausuario');
    }
   //echo $app->view->render( "/users/altausuario.twig", array('user' => ($user), 'nombre' => ($nombre), 'ubicaciones' => (UbicacionResource::getInstance()->get()),
   //'apellido' => ($apellido),'documento' => ($documento),'telefono' => ($telefono),'email' => ($email)));

  }

  public function editUsuario($app,$user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id = null,$habilitado,$id) {
    $app->applyHook('must.be.administrador');

    $errors = [];
    if (!Validator::hasLength(45, $nombre)) {
         $errors[] = 'El nombre debe tener menos de 45 caracteres';
    }
    if (!Validator::hasLength(45, $apellido)) {
         $errors[] = 'El apellido debe tener menos de 45 caracteres';
    }
    if (!Validator::hasLength(45, $user)) {
         $errors[] = 'El username debe tener menos de 45 caracteres';
    }
    if (!Validator::hasLength(20, $pass)) {
         $errors[] = 'La contraseña debe tener menos de 20 caracteres';
    }
    if (!Validator::hasNumbers($pass)) {
         $errors[] = 'La contraseña debe tener una combinación de números y caracteres';
    }
    if(!Validator::isEmail($email)) {
        $errors[] = 'Debe ser un email válido';
    }
    if(!Validator::isNumeric($documento)) {
        $errors[] = 'El documento debe ser numérico';
    }
    if(!Validator::hasLength(8,$documento)) {
        $errors[] = 'El documento debe tener 8 números';
    }
    if(!Validator::isNumeric($telefono)) {
        $errors[] = 'El teléfono debe ser numérico';
    }

    $existeusuario = UsuarioResource::getInstance()->existeUsuarioEdit($user, $id);

    if (!$existeusuario){
         $error = true;
        $app->flash('error', 'No se puede modificar. Ya existe ese nombre de usuario');
        echo $app->redirect('/users/edituser?id=' .$id);

    }


    if (sizeof($errors) == 0) {
        if (UsuarioResource::getInstance()->edit($user,$pass,$nombre,$apellido,$documento,$telefono,$rol_id,$email,$ubicacion_id,$habilitado,$id)){
          $app->flash('success', 'El usuario ha sido modificado exitosamente');
          echo $app->redirect('/users/page?id=1');
        } else {
          $app->flash('error', 'No se pudo modificar el usuario');
          echo $app->redirect('/users/edituser?id=' .$id);
        }
    } else {
        $app->flash('errors', $errors);
        echo $app->redirect('/users/edituser?id=' .$id);
    }


  }


  public function deleteUsuario($app, $id) {
    $app->applyHook('must.be.administrador');
    if (UsuarioResource::getInstance()->delete($id)) {
      $app->flash('success', 'El usuario ha sido eliminado exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar el usuario');
    }
    $app->redirect('/users/page?id=1');
  }

  public function showUsuario($app, $id){
    $app->applyHook('must.be.administrador');
    $user = UsuarioResource::getInstance()->get($id);
    $ubicacion = UsuarioResource::getInstance()->ubicacion($id);
    echo $app->view->render( "edituser.twig", array('usuario' => ($user), 'ubicacionUser' => ($ubicacion), 'ubicaciones' => (UbicacionResource::getInstance()->get())));
  }


}
