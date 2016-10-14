<?php

namespace Controller;
use Model\Entity\Producto;
use Model\Resource\IngresoDetalleResource;
use Model\Entity\IngresoDetalle;
use Model\Resource\ProductoResource;
use Model\Resource\ConfiguracionResource;

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
        $ingresos = IngresoDetalleResource::getInstance()->getIngresosDeCompra();
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


}
