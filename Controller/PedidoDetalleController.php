<?php

namespace Controller;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Model\Entity\Estado;
use Model\Resource\EstadoResource;
use Model\Resource\MenuDelDiaResource;
use Model\Resource\PedidoResource;
use Model\Resource\PedidoDetalleResource;


class PedidoDetalleController {



    public function showAgregarProdutcoPedido($app,$id,$token){
        $app->applyHook('must.be.online');
        echo $app->view->render( "agregarProductoPedido.twig", array('menus' => (MenuDelDiaResource::getInstance() -> menusHoy()), 'pedido' => (PedidoResource::getInstance() -> get($id)),'token' => $token));

      }

      public function newProducto($app,$producto, $cant, $userId, $pedido,$token) {
        CSRF::getInstance()->control($app,$token);

           $app->applyHook('must.be.online');


             if (PedidoDetalleResource::getInstance()->insertProd($producto, $cant, $pedido)){
                   $app->flash('success', 'Producto dado de alta correctamente');
             } else {
                   $app->flash('error', 'No se pudo dar de alta el producto');
                 }
             echo $app->redirect('/pedidosUsuario/page?id=1&userId=' .$userId);

         }







}

?>
