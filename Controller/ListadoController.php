<?php

namespace Controller;
use Model\Entity\Producto;
use Model\Resource\IngresoDetalleResource;
use Model\Entity\IngresoDetalle;
use Model\Entity\Compra;
use Model\Resource\CompraResource;
use Model\Resource\ProductoResource;
use Model\Resource\ConfiguracionResource;
use Model\Resource\EgresoDetalleResource;
use Model\Entity\EgresoDetalle;
use Model\Resource\UsuarioResource;
use Model\Entity\Usuario;
use Model\Resource\MenuDelDiaResource;
use Model\Entity\MenuDelDia;
use Model\Resource\PedidoResource;
use Model\Entity\Pedido;
use Model\Resource\PedidoDetalleResource;
use Model\Entity\PedidoDetalle;
use Model\Resource\EstadoResource;



class ListadoController {

    public function indexActionStockMin($app,$page = 1) {
        $app->applyHook('must.be.administrador.or.gestion');
        $productos = ProductoResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = ProductoResource::getInstance()->getPaginateStockMin($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        echo $app->view->render('stockminimo.twig', array(
            "productos"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount
        ));
    }

    public function indexActionFaltantes($app,$page = 1) {
        $app->applyHook('must.be.administrador.or.gestion');
        $productos = ProductoResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = ProductoResource::getInstance()->getPaginateFaltantes($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        echo $app->view->render('faltantes.twig', array(
            "productos"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount
        ));
    }

    public function indexActionListado($app,$page = 1,$token) {
        $app->applyHook('must.be.administrador.or.gestion');
        $productos = ProductoResource::getInstance()->get();
        $prodgrafico=ProductoResource::getInstance()->grafico();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = ProductoResource::getInstance()->getPaginateListado($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        echo $app->view->render('listado.twig', array(
            "productos"     => $paginator,
            "prodgrafico"  => $prodgrafico,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "token"      => $token

        ));
    }

    public function indexActionIngresos($app,$page = 1,$token) {
        $app->applyHook('must.be.administrador.or.gestion');
        $ingresos = IngresoDetalleResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = IngresoDetalleResource::getInstance()->getPaginateIngreso($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        echo $app->view->render('ingresos.twig', array(
            "ingresos"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "token"      => $token

        ));
    }

    public function indexActionCompras($app,$page = 1,$token) {
        $app->applyHook('must.be.administrador.or.gestion');
        $compras = CompraResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = CompraResource::getInstance()->getPaginateCompra($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        echo $app->view->render('compras.twig', array(
            "compras"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "token"      => $token

        ));
    }


    public function indexActionEgresos($app, $idCompra, $page = 1,$token){
      $app->applyHook('must.be.administrador.or.gestion');
      $egresos = EgresoDetalleResource::getInstance()->get();
      $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
      $paginator = EgresoDetalleResource::getInstance()->getPaginateEgreso($pageSize,$idCompra,$page);
      $totalItems = count($paginator);
      $pagesCount = ceil($totalItems / $pageSize);
      echo $app->view->render('egresos.twig', array(
          "egresos"     => $paginator,
          "totalItems" => $totalItems,
          "pagesCount" => $pagesCount,
          "idCompra"   => $idCompra,
          "token"      => $token

      ));
    }

    public function indexActionUsuarios($app, $page = 1, $token){
      $app->applyHook('must.be.administrador.or.gestion');
      $usuarios = UsuarioResource::getInstance()->get();
      $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
      $paginator = UsuarioResource::getInstance()->getPaginateUsuario($pageSize,$page);
      $totalItems = count($paginator);
      $pagesCount = ceil($totalItems / $pageSize);
      echo $app->view->render('users.twig', array(
          "usuarios"     => $paginator,
          "totalItems" => $totalItems,
          "pagesCount" => $pagesCount,
          "token"      => $token
      ));
    }

    public function indexActionMenu($app, $page = 1,$token){
      $app->applyHook('must.be.administrador.or.gestion');
      $menus = MenuDelDiaResource::getInstance()->get();
      $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
      $paginator = MenuDelDiaResource::getInstance()->getPaginateMenu($pageSize,$page);
      $totalItems = count($paginator);
      $pagesCount = ceil($totalItems / $pageSize);
      echo $app->view->render('menu.twig', array(
          "menus"     => $paginator,
          "totalItems" => $totalItems,
          "pagesCount" => $pagesCount,
          "token"      => $token

      ));
    }

    public function indexActionPedidosUsuario($app, $page = 1, $userId,$token){
      $app->applyHook('must.be.administrador.or.online');
      $pedidos = PedidoResource::getInstance()->get();
      $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
      $paginator = PedidoResource::getInstance()->getPaginatePedidosUsuario($pageSize,$page,$userId);
      $totalItems = count($paginator);
      $pagesCount = ceil($totalItems / $pageSize);
      echo $app->view->render('pedidosUsuario.twig', array(
          "pedidos"     => $paginator,
          "totalItems" => $totalItems,
          "pagesCount" => $pagesCount,
          "token"      => $token

      ));
    }

    public function indexActionPedidosUsuarioProd($app, $idPedido, $page = 1){
      $app->applyHook('must.be.administrador.or.online');
      $pedidos = PedidoDetalleResource::getInstance()->get();
      $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
      $paginator = PedidoDetalleResource::getInstance()->getPaginatePedidosUsuarioProd($pageSize, $idPedido,$page);
      $totalItems = count($paginator);
      $pagesCount = ceil($totalItems / $pageSize);
      echo $app->view->render('pedidosUsuarioProd.twig', array(
          "pedidos"     => $paginator,
          "totalItems" => $totalItems,
          "pagesCount" => $pagesCount,
          "idPedido"   => $idPedido
      ));
    }

    public function indexActionPedidos($app, $page = 1,$token){
      $app->applyHook('must.be.administrador.or.online');
      $pedidos = PedidoResource::getInstance()->get();
      $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
      $paginator = PedidoResource::getInstance()->getPaginatePedidos($pageSize,$page);
      $totalItems = count($paginator);
      $pagesCount = ceil($totalItems / $pageSize);
      echo $app->view->render('pedidos.twig', array(
          "pedidos"     => $paginator,
          "totalItems" => $totalItems,
          "pagesCount" => $pagesCount,
          "token"      => $token

      ));
    }


}
