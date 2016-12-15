<?php

namespace Controller;
use Controller\Validator;
use Model\Entity\MenuDelDia;
use Model\Resource\MenuDelDiaResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;

class MenuController {


  public function showAltaMenu($app){
    $token=rand(0,999999);
    array_push($_SESSION['csrf_token'], $token );
      $app->applyHook('must.be.administrador');

      echo $app->view->render( "altamenu.twig", array('productos' => (ProductoResource::getInstance()->get()), 'hoy' =>(MenuDelDiaResource::getInstance()->hoy()),'token'=>$token));

    }

     public function showEditMenu($app, $id){
       $token=rand(0,999999);
       array_push($_SESSION['csrf_token'], $token );
      $app->applyHook('must.be.administrador');
      $menu = MenuDelDiaResource::getInstance()->get($id);
      echo $app->view->render( "editmenu.twig", array('menu' => ($menu),'productos' => (ProductoResource::getInstance()->get()),'token'=>$token));

    }

    public function newMenu($app,$fecha, $producto,$habilitado,$token) {
      CSRF::getInstance()->control($app,$token);

         $app->applyHook('must.be.administrador.or.gestion');

          if(ProductoResource::getInstance()->hayStock($producto)){
             if (MenuDelDiaResource::getInstance()->insert($fecha, $producto, $habilitado)){
                   $app->flash('success', 'Menu dado de alta correctamente');
             } else {
                   $app->flash('error', 'No se pudo dar de alta el menu');
                 }
             echo $app->redirect('/menu/page?id=1');

         }else{
           $app->flash('error', 'No hay stock del producto seleccionado');
           echo $app->redirect('/menu/page?id=1');
         }
       }

       public function editMenu($app,$fecha,$producto,$habilitado, $menuid,$token){
         CSRF::getInstance()->control($app,$token);



        if (MenuDelDiaResource::getInstance()->edit($fecha,$producto,$habilitado, $menuid)){

           $app->flash('success', 'El menu ha sido modificado exitosamente');

        } else {
          $app->flash('error', 'No se pudo modificar el menu');
        }
        echo $app->redirect('/menu/page?id=1');

      }


     public function deleteMenu($app, $id,$token) {
       CSRF::getInstance()->control($app,$token);

          $app->applyHook('must.be.administrador.or.gestion');
          if (MenuDelDiaResource::getInstance()->delete($id)) {
            $app->flash('success', 'El menu ha sido eliminado exitosamente.');
          } else {
            $app->flash('error', 'No se pudo eliminar el menu');
          }
          $app->redirect('/menu/page?id=1');
    }



}

?>
