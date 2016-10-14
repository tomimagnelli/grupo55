<?php

namespace Controller;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\Categoria;
use Model\Resource\CategoriaResource;

class ProductoController {


  public function showAltaProducto($app){
    echo $app->view->render( "altaproducto.twig", array('categorias' => (CategoriaResource::getInstance()->get())));
  }

  public function newProducto($app,$nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id = null,$descripcion) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (ProductoResource::getInstance()->insert($nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id,$descripcion)){
       $app->flash('success', 'El producto ha sido dado de alta exitosamente');
    } else {
      $app->flash('error', 'No se pudo dar de alta el producto');
    }
    echo $app->redirect('/listado');
  }

  public function editProducto($app,$nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id = null,$descripcion,$id) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (ProductoResource::getInstance()->edit($nombre,$marca,$stock,$stock_minimo,$proovedor,$precio_venta_unitario,$categoria_id,$descripcion,$id)){
       $app->flash('success', 'El producto ha sido modificado exitosamente');
    } else {
      $app->flash('error', 'No se pudo modificar el producto');
    }
    echo $app->redirect('/listado');
  }

  public function deleteProducto($app, $id) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (ProductoResource::getInstance()->delete($id)) {
      $app->flash('success', 'El producto ha sido eliminado exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar el producto');
    }
    $app->redirect('/listado');
  }

  public function showProducto($app, $id){
    $app->applyHook('must.be.administrador.or.gestion');
    $producto = ProductoResource::getInstance()->get($id);
    $categoria = ProductoResource::getInstance()->categoria($id);
    echo $app->view->render( "editproducto.twig", array('producto' => ($producto), 'categoriaProd' => ($categoria), 'categorias' => (CategoriaResource::getInstance()->get())));
  }

}
