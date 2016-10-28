<?php

namespace Controller;
use Controller\Validator;
use Model\Entity\MenuDelDia;
use Model\Resource\MenuDelDiaResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;

class MenuController {


  public function showAltaMenu($app){
      $app->applyHook('must.be.administrador');
      echo $app->view->render( "altamenu.twig", array('productos' => (ProductoResource::getInstance()->get()), 'hoy' =>(MenuDelDiaResource::getInstance()->hoy())));

    }

    public function newMenu($app,$fecha, $producto,$habilitado) {
         $app->applyHook('must.be.administrador.or.gestion');


           if (MenuDelDiaResource::getInstance()->insert($fecha, $producto, $habilitado)){
                 $app->flash('success', 'Menu dado de alta correctamente');
           } else {
                 $app->flash('error', 'No se pudo dar de alta el menu');
               }
           echo $app->redirect('/menu/page?id=1');

       }

}

?>
