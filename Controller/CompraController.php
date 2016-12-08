<?php

namespace Controller;
use Model\Entity\Compra;
use Model\Resource\CompraResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\TipoEgreso;
use Model\Resource\TipoEgresoResource;

class CompraController {

  public function listCompras($app){
    $app->applyHook('must.be.administrador.or.gestion');
    echo $app->view->render( "compras.twig", array('compras' => (CompraResource::getInstance()->get())));
  }


  public function showAltaCompra($app,$token){
   echo $app->view->render( "altacompra.twig",array('tiposegreso' => (TipoEgresoResource::getInstance()->get()),'token'=>$token));
 }


  public function showAltaCompra2($app,$id,$token){
   echo $app->view->render( "agregarproductoacompra.twig", array('productos' => (ProductoResource::getInstance()->get()),'tiposegreso' => (TipoEgresoResource::getInstance()->get()),'compra' => (CompraResource::getInstance()->get($id)),'token'=>$token));
 }

 public function ShowEditCompra($app,$id,$token) {
   $app->applyHook('must.be.administrador');
   $compra = CompraResource::getInstance()->get($id);
   echo $app->view->render( "editCompra.twig", array('compra' => ($compra),'token'=>$token));

 }

 public function editCompra($app,$editproveedor,$editproveedor_cuit,$compraid,$token) {
   CSRF::getInstance()->control($app,$token);
   $app->applyHook('must.be.administrador');
   $errors = [];
   if (!Validator::hasLength(45, $editproveedor)) {
        $errors[] = 'El proveedor debe tener menos de 45 caracteres';
   }
   if(!Validator::isNumeric($editproveedor_cuit)) {
       $errors[] = 'El cuit debe ser numérico';
   }

   if (sizeof($errors) == 0) {
     if (CompraResource::getInstance()->edit($app,$editproveedor,$editproveedor_cuit,$compraid)){
        $app->flash('success', 'La compra ha sido modificado exitosamente');
     } else {
       $app->flash('error', 'No se pudo modificar la compra');
     }
     echo $app->redirect('/compras/page?ids=1');
    } else {
       $app->flash('errors', $errors);
       echo $app->redirect('/compras/editCompra?id=' .$compraid);
   }
 }



 public function deleteCompra($app, $id,$token) {
   CSRF::getInstance()->control($app,$token);
   $app->applyHook('must.be.administrador');
   if (CompraResource::getInstance()->delete($id)) {
     $app->flash('success', 'La compra ha sido eliminado exitosamente.');
   } else {
     $app->flash('error', 'No se pudo eliminar la compra');
   }
   $app->redirect('/compras/page?ids=1');
 }

  public function newCompra($app,$proveedor,$proveedor_cuit,$token) {
    CSRF::getInstance()->control($app,$token);
    $app->applyHook('must.be.administrador.or.gestion');
    $errors = [];
    if (!Validator::hasLength(45, $proveedor)) {
         $errors[] = 'El proveedor debe tener menos de 45 caracteres';
    }
    if(!Validator::isNumeric($proveedor_cuit)) {
        $errors[] = 'El cuit debe ser numérico';
    }

    if (sizeof($errors) == 0) {
      if (CompraResource::getInstance()->insert($app,$proveedor,$proveedor_cuit)){
        $app->flash('success', 'La compra ha sido dado de alta exitosamente');
      } else {
        $app->flash('error', 'No se pudo dar de alta la compra');
      }
      echo $app->redirect('/compras/page?ids=1');
    } else {
        $app->flash('errors', $errors);
        echo $app->redirect('/compras/altacompra');
    }

  }
}
?>
