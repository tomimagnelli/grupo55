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
use Model\Resource\PedidoDetalleResource;
use Model\Resource\GananciaResource;
use mpdf;

class GananciaController {




  public function showBusquedaGanancias($app, $desde, $hasta){

  $ingresosentre = IngresoDetalleResource::getInstance()-> buscar($desde, $hasta);
  $sumaingresos = IngresoDetalleResource::getInstance()-> sumaingresos($ingresosentre);
  $pedidos = IngresoDetalleResource::getInstance()-> buscarpedidos($desde, $hasta);
  $sumapedidos = IngresoDetalleResource::getInstance()-> sumaPedidos($pedidos);

  $comprasentre = EgresoDetalleResource::getInstance()-> buscar($desde, $hasta);
  $sumaegresosdetalle = EgresoDetalleResource::getInstance()-> sumaEgresos($comprasentre);

  $sumaingresosdetalle= $sumaingresos;

  $total = $sumaingresosdetalle - $sumaegresosdetalle;

  $productos = GananciaResource::getInstance()->getVentasEntre($desde,$hasta);

  $ingresos=IngresoDetalleResource::getInstance()->getVentasEntre($desde,$hasta);
  foreach ($ingresos as &$valor) {
    $valor['y']=(float)$valor['y'];
    /*$valor['name']=$valor['name']->format('Y-m-d');*/
  }
  echo $app->view->render( "ganancias.twig", array('json2' => $this->armoJsonVentas($ingresos), 'json' => $this->armoJsonGanancias($this->valoresGanancias($app,$desde,$hasta)),'desde' => ($desde), 'hasta' => ($hasta), 'productos' => ($productos),'sumaingresosdetalle' => ($sumaingresosdetalle), 'sumaegresosdetalle' => ($sumaegresosdetalle), 'total' => ($total)));
  }

public function exportGanancias($app,$desde,$hasta)
{
    $mpdf=new mPDF('');
    $listado=$this->valoresGanancias($app,$desde,$hasta);
    $html .= "
    <div style=\"font-family:arialunicodems;\">
    <table border=\"1\">
    <thead>
    <tr style=\"text-rotate:0\">
            <th>Dia  </th>
            <th>Ganancia</th>
    </tr>
    </thead>
    ";
    foreach($listado as $row) {
            $html .= "<tr>";
      $html .= '<td style="font-family: arial;">'.$row['name'].'</td>';
      $html .= '<td style="font-family: arial;">'.$row['y'].'</td>';
      $html .= "</tr>
    ";
    }
    $html .= "</table>
    </div>
    ";
    $html = utf8_encode($html);
    if ($_REQUEST['html']) { echo $html; exit; }
    $mpdf->WriteHTML($html);
    $mpdf->Output('nombre.pdf','D'); exit;
    $app->flash('success', 'El responsable a sido desasignado exitosamente.');
    header("Refresh:0");
      }

  public function valoresGanancias($app,$desde,$hasta)
{
    $egresos=EgresoDetalleResource::getInstance()->getSumEgresontre($desde,$hasta);
    $ingresos=IngresoDetalleResource::getInstance()->getSumIngresos($desde,$hasta);
    //$pedidos=PedidoDetalleResource::getInstance()->getSumPedidos($desde,$hasta);
    foreach ($egresos as &$valor) {
        $valor['name']=$valor['name']->format('Y-m-d');
    }
        foreach ($ingresos as &$valor) {
        $valor['name']=$valor['name']->format('Y-m-d');
    }
  //  foreach ($pedidos as &$valor) {
    //$valor['name']=$valor['name']->format('Y-m-d');
//}
    $params=$this->myMerge($ingresos,$egresos);
    foreach ($params as &$valor) {
      $valor['y']=(float)$valor['y'];
      /*$valor['name']=$valor['name']->format('Y-m-d');*/
    }
    return $params;
}

public function myMerge($ingresos,$egresos)
{

  foreach ($ingresos as &$ingreso) {
      foreach ($egresos as $key=>&$egreso) {
        if ($ingreso['name']==$egreso['name']) {
          $ingreso['y']=$ingreso['y']-$egreso['y'];
          unset($egresos[$key]);
        }
      }
    }
    foreach ($egresos as &$egreso) {
      $egreso['y']=$egreso['y']*-1;
      array_push($ingresos,$egreso);
    }
    return $ingresos;
}

public function myMerge2($ingresos,$egresos)
{   foreach ($ingresos as &$ingreso) {
      foreach ($egresos as $key=>&$egreso) {
        if ($ingreso['name']==$egreso['name']) {
          $ingreso['y']=$ingreso['y']-$egreso['y'];
          unset($egresos[$key]);
        }
      }
    //  foreach ($pedidos as $key=>&$pedido){
      //  if ($ingreso['name']==$pedido['name']) {
        //  $ingreso['y']=$ingreso['y']+$pedido['y'];
          //unset($pedidos[$key]);
        //}
      //}

    }
    foreach ($egresos as &$egreso) {
      $egreso['y']=$egreso['y']*-1;
      array_push($ingresos,$egreso);
    }
    return $ingresos;
}



public function armoJsonGanancias($values)
{

 $arregloJson=
       array(
       'chart'=>array(
           'type'=> 'column'
       ),
       'title'=>array(
           'text'=>'Ganancias'
       ),
       'subtitle'=>array(
           'text'=>'Click the columns to view versions. Source: <a href="http://netmarketshare.com">netmarketshare.com</a>.'
       ),
       'xAxis'=>array(
           'type'=>'category'
       ),
       'yAxis'=>array(
           'title'=>array(
               'text'=>'Total percent market share'
           )

       ),
       'legend'=>array(
           'enabled'=>false
       ),
       'plotOptions'=>array(
           'series'=>array(
               'borderWidth'=>0,
               'dataLabels'=>array(
                   'enabled'=>true,
                   'format'=>'${point.y:.1f}'
               )
           )
       ),

       'tooltip'=>array(
           'headerFormat'=>'<span style="font-size:11px">{series.name}</span><br>',
           'pointFormat'=>'<span style="color:{point.color}">{point.name}</span>: <b>${point.y:.2f}</b><br/>'
       ),

       'series'=>[array(
           'name'=>'Brands',
           'colorByPoint'=>true,
           'data'=>$values)
     ])
   ;
 return $arregloJson;


}

public function ventas($app,$desde,$hasta)
  {
    $ingresos=IngresoDetalleResource::getInstance()->getVentasEntre($desde,$hasta);
    foreach ($ingresos as &$valor) {
      $valor['y']=(float)$valor['y'];
      /*$valor['name']=$valor['name']->format('Y-m-d');*/
    }
    $app->applyHook('must.be.gestion.or.administrador');
    echo $app->view->render( "balanceIngresos.twig", array('json' => $this->armoJsonVentas($ingresos),'ventas'=>$ingresos));
  }

public function armoJsonVentas($values)
{

  $arregloJson=
        array(
            'chart'=>array(
                'plotBackgroundColor'=>null,
                'plotBorderWidth'=>null,
                'plotShadow'=>false,
                'type'=>'pie'
            ),
            'title'=>array(
                'text'=>'Productos vendidos'
            ),
            'tooltip'=>array(
                'pointFormat'=>'{series.name}: <b>{point.percentage:.1f}%</b>'
            ),
            'plotOptions'=>array(
                'pie'=>array(
                    'allowPointSelect'=>true,
                    'cursor'=>'pointer',
                    'dataLabels'=>array(
                        'enabled'=>false
                    ),
                    'showInLegend'=>true
                )
            ),
          'series'=>[array(
            'name'=>'Brands',
            'colorByPoint'=>true,
            'data'=>$values)
      ])
    ;

  return $arregloJson;


}




}
?>
