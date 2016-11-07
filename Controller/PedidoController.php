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
use Model\Resource\PedidoDetalleResource;

class PedidoController {



  public function showAltaPedido($app){
      $app->applyHook('must.be.online');
      echo $app->view->render( "altaPedido.twig");

    }

    public function pedidosEntreFechas($app, $desde, $hasta,$userid){ 
    $pedidosentre = PedidoResource::getInstance()-> buscar($desde, $hasta, $userid);

    echo $app->view->render( "pedidosEntreFechas.twig", array('pedidos' => ($pedidosentre),'productos' => (ProductoResource::getInstance()->get()),'desde' => ($desde), 'hasta' => ($hasta), 'estados' => (EstadoResource::getInstance()->get())));
  }

  public function deletePedido($app, $id) {
    $app->applyHook('must.be.administrador.or.gestion');
    if (PedidoResource::getInstance()->delete($id)) {
      $app->flash('success', 'El pedido ha sido eliminado exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar el producto');
    }
    $app->redirect('/pedidos/page?id=1');
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
    if(PedidoDetalleResource::getInstance()->aceptarStock($id)){
       PedidoDetalleResource::getInstance()->descontarStock($id);

        if (PedidoResource::getInstance()->aceptar($id)) {
          $app->flash('success', 'Pedido aceptado');
        } else {
          $app->flash('error', 'No se pudo aceptar');
        }
        $app->redirect('/pedidos/page?id=1');
    }else{
    $app->flash('error', 'No hay stock');
    $app->redirect('/pedidos/page?id=1');
    }
      }

   public function cancelarPedido($app, $id) {


          $app->applyHook('must.be.administrador.or.gestion');
          if (PedidoResource::getInstance()->cancelar($id)) {
               $app->flash('success', 'Pedido cancelado');
          } 
          else {
             $app->flash('error', 'No se pudo cancelar');
          }
        $app->redirect('/pedidos/page?id=1');

   }

   public function cancelarPedidoUsuario($app, $id, $userId) {

          $pedido = PedidoResource::getInstance()->get($id);
        $fechapedido = $pedido->getFecha()->format('Y-m-d H:i:s');
        $fechaactual = (new \DateTime())->format('Y-m-d H:i:s');
  
         $minutos = (strtotime($fechaactual)-strtotime($fechapedido))/60;
         $minutos = abs($minutos); $minutos = floor($minutos);

         if ($minutos > 30) {
            $app->flash('error', 'No se puede cancelar el pedido, pasaron mas de 30 min');
            $app->redirect('/pedidosUsuario/page?id=1&userId=' .$userId);
         }

        else {

          
          if (PedidoResource::getInstance()->cancelar($id)) {
               $app->flash('success', 'Pedido cancelado');
          } 
          else {
             $app->flash('error', 'No se pudo cancelar');
          }
        $app->redirect('/pedidosUsuario/page?id=1&userId=' .$userId);

        }

   }

    


}

?>
