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

    public function indexActionListado($app,$page = 1) {
        $app->applyHook('must.be.administrador.or.gestion');
        $productos = ProductoResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = ProductoResource::getInstance()->getPaginateListado($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        echo $app->view->render('listado.twig', array(
            "productos"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount
        ));
    }

    public function indexActionIngresos($app,$page = 1) {
        $app->applyHook('must.be.administrador.or.gestion');
        $ingresos = IngresoDetalleResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = IngresoDetalleResource::getInstance()->getPaginateIngreso($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        echo $app->view->render('ingresos.twig', array(
            "ingresos"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount
        ));
    }

    public function indexActionCompras($app,$page = 1) {
        $app->applyHook('must.be.administrador.or.gestion');
        $compras = CompraResource::getInstance()->get();
        $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
        $paginator = CompraResource::getInstance()->getPaginateCompra($pageSize,$page);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        echo $app->view->render('compras.twig', array(
            "compras"     => $paginator,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount
        ));
    }


    public function indexActionEgresos($app, $idCompra, $page = 1){
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
          "idCompra"   => $idCompra
      ));
    }

    public function indexActionUsuarios($app, $page = 1){
      $app->applyHook('must.be.administrador.or.gestion');
      $usuarios = UsuarioResource::getInstance()->get();
      $pageSize = ConfiguracionResource::getInstance()->get('paginacion')->getValor();
      $paginator = UsuarioResource::getInstance()->getPaginateUsuario($pageSize,$page);
      $totalItems = count($paginator);
      $pagesCount = ceil($totalItems / $pageSize);
      echo $app->view->render('users.twig', array(
          "usuarios"     => $paginator,
          "totalItems" => $totalItems,
          "pagesCount" => $pagesCount
      ));
    }


}
