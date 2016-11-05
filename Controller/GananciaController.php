<?php

namespace Controller;
use Model\Entity\EgresoDetalle;
use Model\Resource\EgresoDetalleResource;
use Model\Entity\IngresoDetalle;
use Model\Resource\IngresoDetalleResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\Pedido;
use Model\Resource\PedidoResource;
use Model\Entity\TipoEgreso;
use Model\Resource\TipoEgresoResource;
use Model\Entity\Compra;
use Model\Resource\CompraResource;

class GananciaController {



    public function showBusquedaGanancias($app, $desde, $hasta){
    
    echo $app->view->render( "ganancias.twig", array('egresos' => (EgresoDetalleResource::getInstance()->get()),'ingresos' => (IngresoDetalleResource::getInstance()->get()),'productos' => (ProductoResource::getInstance()->get()), 'desde' => ($desde), 'hasta' => ($hasta), 'tiposingreso' => (TipoEgresoResource::getInstance()->get())));
  }
  
  

}
?>
