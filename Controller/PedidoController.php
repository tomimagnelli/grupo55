<?php

namespace Controller;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\Pedido;
use Model\Resource\PedidoResource;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Model\Entity\Estado;
use Model\Resource\EstadoResource;

class PedidoController {

  public function listPedidos($app){
    $app->applyHook('must.be.administrador.or.gestion');
    echo $app->view->render( "pedidos.twig", array('pedidos' => (PedidoResource::getInstance()->get()),'estados' => (EstadoResource::getInstance()->get()), 'productos' => (ProductoResource::getInstance()->get()), 'usuarios' => (UsuarioResource::getInstance()->get())));
  }
  

  public function showAltaProducto($app){
    echo $app->view->render( "altaproducto.twig", array('categorias' => (CategoriaResource::getInstance()->get())));
  }

  


  public function deletePedido($app, $id) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (PedidoResource::getInstance()->delete($id)) {
      $app->flash('success', 'El pedido ha sido eliminado exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar el producto');
    }
    $app->redirect('/pedidos');
  }

  public function showProducto($app, $id){
    $app->applyHook('must.be.administrador.or.gestion');
    $producto = ProductoResource::getInstance()->get($id);
    $categoria = ProductoResource::getInstance()->categoria($id);
    echo $app->view->render( "editproducto.twig", array('producto' => ($producto), 'categoriaProd' => ($categoria), 'categorias' => (CategoriaResource::getInstance()->get())));
  }

}
