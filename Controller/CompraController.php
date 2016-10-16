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


  public function showAltaCompra($app){
   echo $app->view->render( "altacompra.twig",array('tiposegreso' => (TipoEgresoResource::getInstance()->get())));
 }


  public function showAltaCompra2($app,$id){
   echo $app->view->render( "agregarproductoacompra.twig", array('productos' => (ProductoResource::getInstance()->get()),'tiposegreso' => (TipoEgresoResource::getInstance()->get()),'compra' => (CompraResource::getInstance()->get($id))));
 }

 public function ShowEditCompra($app,$id) {
   $app->applyHook('must.be.administrador');
   $compra = CompraResource::getInstance()->get($id);
   echo $app->view->render( "editCompra.twig", array('compra' => ($compra)));

 }

 public function editCompra($app,$editproveedor,$editproveedor_cuit,$compraid) {
   $app->applyHook('must.be.administrador');
   if (CompraResource::getInstance()->edit($app,$editproveedor,$editproveedor_cuit,$compraid)){
      $app->flash('success', 'La compra ha sido modificado exitosamente');
   } else {
     $app->flash('error', 'No se pudo modificar la compra');
   }
   echo $app->redirect('/compras');
 }

 public function deleteCompra($app, $id) {
   $app->applyHook('must.be.administrador');
   if (CompraResource::getInstance()->delete($id)) {
     $app->flash('success', 'La compra ha sido eliminado exitosamente.');
   } else {
     $app->flash('error', 'No se pudo eliminar la compra');
   }
   $app->redirect('/compras');
 }

  public function newCompra($app,$proveedor,$proveedor_cuit) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (CompraResource::getInstance()->insert($app,$proveedor,$proveedor_cuit)){
       $app->flash('success', 'La compra ha sido dado de alta exitosamente');
    } else {
      $app->flash('error', 'No se pudo dar de alta la compra');
    }
    echo $app->redirect('/compras');
  }
}
?>
