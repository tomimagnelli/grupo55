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
use Model\Resource\MenuDelDiaResource;

class PedidoController {

  public function listPedidos($app){
    $app->applyHook('must.be.administrador.or.gestion');
    echo $app->view->render( "pedidos.twig", array('pedidos' => (PedidoResource::getInstance()->get()),'estados' => (EstadoResource::getInstance()->get()), 'productos' => (ProductoResource::getInstance()->get()), 'usuarios' => (UsuarioResource::getInstance()->get())));
  }

  public function showAltaPedido($app){
      $app->applyHook('must.be.online');
      echo $app->view->render( "altaPedido.twig");

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

  public function newPedido($app,$observacion,$userId) {
       $app->applyHook('must.be.online');

         if (PedidoResource::getInstance()->insert($observacion,$userId)){
               $app->flash('success', 'Pedido dado de alta correctamente');
         } else {
               $app->flash('error', 'No se pudo dar de alta el pedido');
             }
         echo $app->redirect('/pedidosUsuario/page?id=1&userId=' .$userId);

     }

     public function enviarPedido($app, $id, $userId) {
       $app->applyHook('must.be.online');
       if (PedidoResource::getInstance()->enviar($id)) {
         $app->flash('success', 'El pedido ha sido enviado exitosamente.');
       } else {
         $app->flash('error', 'No se pudo enviar el pedido');
       }
       $app->redirect('/pedidosUsuario/page?id=1&userId=' .$userId);
     }

     public function aceptarPedido($app, $id) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (PedidoResource::getInstance()->aceptar($id)) {
      $app->flash('success', 'Pedido aceptado');
    } else {
      $app->flash('error', 'No se pudo aceptar');
    }
    $app->redirect('/pedidos');
  }

   public function cancelarPedido($app, $id) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (PedidoResource::getInstance()->cancelar($id)) {
      $app->flash('success', 'Pedido cancelado');
    } else {
      $app->flash('error', 'No se pudo cancelar');
    }
    $app->redirect('/pedidos');
  }


}

?>
