<?php

namespace Controller;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\Categoria;
use Model\Resource\CategoriaResource;

class ProductoController {

  public function listProductos($app){
    $app->applyHook('must.be.administrador.or.gestion');
    echo $app->view->render( "listado.twig", array('productos' => (ProductoResource::getInstance()->get()), 'categorias' => (CategoriaResource::getInstance()->get())));
  }
  public function listStockminimo($app){
    echo $app->view->render( "stockminimo.twig", array('productos' => (ProductoResource::getInstance()->get()), 'categorias' => (CategoriaResource::getInstance()->get())));
  }

  public function showAltaProducto($app){
    echo $app->view->render( "altaproducto.twig", array('categorias' => (CategoriaResource::getInstance()->get())));
  }

  public function newProducto($app,$nombre,$marca,$stock,$stock_minimo,$proveedor,$precio_venta_unitario,$categoria_id = null,$descripcion) {
    $app->applyHook('must.be.administrador.or.gestion');

    $errors = [];
      if (!Validator::hasLength(45, $nombre)) {
           $errors[] = 'El nombre debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(45, $marca)) {
           $errors[] = 'La marca debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(45, $proveedor)) {
           $errors[] = 'El proveedor debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(45, $descripcion)) {
           $errors[] = 'La descripcion debe tener menos de 20 caracteres';
      }
      if(!Validator::isNumeric($stock)) {
          $errors[] = 'El stock debe ser numérico';
      }
      if(!Validator::isNumeric($stock_minimo)) {
          $errors[] = 'El stock minimo debe ser numérico';
      }
      if(!Validator::isNumeric($precio_venta_unitario)) {
          $errors[] = 'El precio de venta unitario debe ser numérico';
      }

      if (sizeof($errors) == 0) {
        if (ProductoResource::getInstance()->insert($nombre,$marca,$stock,$stock_minimo,$proveedor,$precio_venta_unitario,$categoria_id,$descripcion)){
           $app->flash('success', 'El producto ha sido dado de alta exitosamente');
        } else {
          $app->flash('error', 'No se pudo dar de alta el producto');
        }
        echo $app->redirect('/listado/page?ids=1');
       } else {
          $app->flash('errors', $errors);
          echo $app->redirect('/listado/altaproducto');
      }


  }

  public function editProducto($app,$nombre,$marca,$stock,$stock_minimo,$proveedor,$precio_venta_unitario,$categoria_id = null,$descripcion,$id) {
    $app->applyHook('must.be.administrador.or.gestion');

    $errors = [];
      if (!Validator::hasLength(45, $nombre)) {
           $errors[] = 'El nombre debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(45, $marca)) {
           $errors[] = 'La marca debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(45, $proveedor)) {
           $errors[] = 'El proveedor debe tener menos de 45 caracteres';
      }
      if (!Validator::hasLength(45, $descripcion)) {
           $errors[] = 'La descripcion debe tener menos de 20 caracteres';
      }
      if(!Validator::isNumeric($stock)) {
          $errors[] = 'El stock debe ser numérico';
      }
      if(!Validator::isNumeric($stock_minimo)) {
          $errors[] = 'El stock minimo debe ser numérico';
      }
      if(!Validator::isNumeric($precio_venta_unitario)) {
          $errors[] = 'El precio de venta unitario debe ser numérico';
      }

      if (sizeof($errors) == 0) {
        if (ProductoResource::getInstance()->edit($nombre,$marca,$stock,$stock_minimo,$proveedor,$precio_venta_unitario,$categoria_id,$descripcion,$id)){
           $app->flash('success', 'El producto ha sido modificado exitosamente');
        } else {
          $app->flash('error', 'No se pudo modificar el producto');
        }
        echo $app->redirect('/listado/page?ids=1');
       } else {
          $app->flash('errors', $errors);
          echo $app->redirect('/listado/editProducto?id=' .$id);
      }


  }

  public function deleteProducto($app, $id) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (ProductoResource::getInstance()->delete($id)) {
      $app->flash('success', 'El producto ha sido eliminado exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar el producto');
    }
    $app->redirect('/listado/page?ids=1');
  }

  public function showProducto($app, $id){
    $app->applyHook('must.be.administrador.or.gestion');
    $producto = ProductoResource::getInstance()->get($id);
    $categoria = ProductoResource::getInstance()->categoria($id);
    echo $app->view->render( "editproducto.twig", array('producto' => ($producto), 'categoriaProd' => ($categoria), 'categorias' => (CategoriaResource::getInstance()->get())));
  }

}
