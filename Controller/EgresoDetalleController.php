<?php

namespace Controller;
use Model\Entity\EgresoDetalle;
use Model\Resource\EgresoDetalleResource;
use Model\Entity\Producto;
use Model\Resource\ProductoResource;
use Model\Entity\TipoEgreso;
use Model\Resource\TipoEgresoResource;
use Model\Entity\Compra;
use Model\Resource\CompraResource;

class EgresoDetalleController {

   public function showEditEgreso($app,$id,$token){
    $egreso_detalle = EgresoDetalleResource::getInstance()->get($id);
    echo $app->view->render( "editegreso.twig", array('egreso_detalle' => ($egreso_detalle),'productos' => (ProductoResource::getInstance()->get()), 'tiposegreso' => (TipoEgresoResource::getInstance()->get()),'token' =>$token));
  }

   public function newEgresoDetalle($app,$compra, $producto,$cantidad,$precio_unitario, $egreso_tipo_id,$token) {
     CSRF::getInstance()->control($app,$token);

        $app->applyHook('must.be.administrador.or.gestion');


        	if (EgresoDetalleResource::getInstance()->insert($compra, $producto,$cantidad,$precio_unitario, $egreso_tipo_id)){
        			ProductoResource::getInstance()->sumarStock($producto,$cantidad);
           			$app->flash('success', 'Producto dado de alta correctamente');
        	} else {
          			$app->flash('error', 'No se pudo dar de alta el producto');
        			}
        	echo $app->redirect('/compras/page?ids=1');

      }

    public function showBusquedaEgresos($app, $desde, $hasta){
    $comprasentre = EgresoDetalleResource::getInstance()-> buscar($desde, $hasta);
    $sumaegresos = EgresoDetalleResource::getInstance()-> sumaEgresos($comprasentre);

    echo $app->view->render( "busquedaEgresos.twig", array('compras' => (CompraResource::getInstance()->get()),'egresos' => (EgresoDetalleResource::getInstance()->get()),'comprasentre' => ($comprasentre),'productos' => (ProductoResource::getInstance()->get()),'egresosdetalle' => (EgresoDetalleResource::getInstance()->get()),'sumaegresos' => ($sumaegresos), 'desde' => ($desde), 'hasta' => ($hasta), 'tiposegreso' => (TipoEgresoResource::getInstance()->get())));
  }

    public function edit($app,$producto,$cantidad,$precio_unitario,$egreso_tipo_id,$id,$token) {
      CSRF::getInstance()->control($app,$token);

       $app->applyHook('must.be.administrador');


          $data = EgresoDetalleResource::getInstance()->get($id);
             if ($data != null){
                 $cantvieja = $data->getCantidad();
                  ProductoResource::getInstance()->descontarStock($producto,$cantvieja);
          }


         if (EgresoDetalleResource::getInstance()->editEgreso($producto,$cantidad,$precio_unitario,$egreso_tipo_id,$id)){
           $app->flash('success', 'El egreso ha sido modificada exitosamente');
           ProductoResource::getInstance()->sumarStock($producto,$cantidad);
          } else {
            $app->flash('error', 'No se pudo modificar la venta');
          }
        echo $app->redirect('/compras/page?ids=1');

   }

     public function deleteEgreso($app, $id,$token) {
       CSRF::getInstance()->control($app,$token);

    $app->applyHook('must.be.administrador');
    if (EgresoDetalleResource::getInstance()->delete($id)) {
      $app->flash('success', 'Egreso eliminado exitosamente.');
    } else {
      $app->flash('error', 'No se pudo eliminar venta');
    }
    $app->redirect('/compras/page?ids=1');
  }

}
?>
