<?php
// Initialize Slim (the router/micro framework used)
require_once 'vendor/autoload.php';
require_once 'Model/Resource/UsuarioResource.php';
use Model\Entity\Usuario;
use Model\Resource\UsuarioResource;
use Controller\UsuarioController;

session_start();

$app = new \Slim\Slim([
        'debug' => true,
        'templates.path' => 'templates'
    ]);

// and define the engine used for the view @see http://twig.sensiolabs.org
$app->view = new \Slim\Views\Twig();
$app->view->setTemplatesDirectory("templates");

// Twig configuration
$view = $app->view();
$view->parserOptions = ['debug' => true];
$view->parserExtensions = [new \Slim\Views\TwigExtension()];
$view->getEnvironment()->addGlobal('session', $_SESSION);
$view->getEnvironment()->addGlobal('server', $_SERVER);
$userResource = UsuarioResource::getInstance();
require_once 'permissions.php';




$app->get('/', '\Controller\HomeController:showHome')->setParams(array($app));


// login...
$app->post('/', function() use ($app, $userResource) {
	  $name = $app->request->post('usuario');
    $pass = $app->request->post('contraseña');

    $user = $userResource->login($name, $pass);
    $habilitado = $userResource->estaHabilitado($name, $pass);
    if ($user) {
      if ($habilitado) {
    	$_SESSION['id']=$user->getId();
    	$_SESSION['user']=$user->getUsuario();
    	$_SESSION['rol']=$user->getRol_Id();
    	$app->flash('success', 'Usuario logueado correctamente como '. $user->getUsuario());
    	$app->redirect('/backend');
      }
      else {
        $app->flash('error', 'Usuario Inhabilitado');
        $app->redirect('/');
      }
    }

    else {
      $app->flash('error', 'Usuario o contraseña incorrecto');
      $app->redirect('/');
	 }
});

$app->get('/logout', function() use ($app, $userResource) {
    session_destroy();
    $app->view->getEnvironment()->addGlobal('session',$_SESSION);
    $app->flash('success', 'Sesión cerrada correctamente');
    $app->redirect('/');
});

$app->group('/login', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('login.twig');
	});

});

$app->group('/agregarproductos', function() use($app) {
  $app->get('/', function() use($app){
    echo $app->view->render('agregarproductos.twig');
  });

});


$app->group('/backend', function() use($app) {
	$app->get('/', function() use($app){
      $app->applyHook('must.be.logueado');
	 	echo $app->view->render('backend.twig');
	});
});

$app->group('/listado', function() use($app) {
     $app->get('/', '\Controller\ListadoController:indexActionListado')->setParams(array($app));
     $app->get('/page', '\Controller\ListadoController:indexActionListado')->setParams(array($app, $app->request->get('ids')));

     $app->get('/delete', '\Controller\ProductoController:deleteProducto')->setParams(array($app, $app->request->get('id')));
     $app->get('/listado/delete', '\Controller\ProductoController:deleteProducto')->setParams(array($app, $app->request->get('id')));

     $app->get('/editProducto', '\Controller\ProductoController:showProducto')->setParams(array($app, $app->request->get('id')));

     $app->post('/editProducto', '\Controller\ProductoController:editProducto')->setParams(
            array($app, $app->request->post('nombre'),
            $app->request->post('marca'),
            $app->request->post('stock'),
            $app->request->post('stock_minimo'),
            $app->request->post('proovedor'),
            $app->request->post('precio_venta_unitario'),
            $app->request->post('categoria_id'),
            $app->request->post('descripcion'),
            $app->request->post('productoid'))
    );

    $app->get('/listado/editProducto', '\Controller\ProductoController:showProducto')->setParams(array($app, $app->request->get('id')));

    $app->post('/listado/editProducto', '\Controller\ProductoController:editProducto')->setParams(
           array($app, $app->request->post('nombre'),
           $app->request->post('marca'),
           $app->request->post('stock'),
           $app->request->post('stock_minimo'),
           $app->request->post('proovedor'),
           $app->request->post('precio_venta_unitario'),
           $app->request->post('categoria_id'),
           $app->request->post('descripcion'),
           $app->request->post('productoid'))
    );

    $app->group('/altaproducto', function() use($app) {
        $app->get('/', '\Controller\ProductoController:showAltaProducto')->setParams(array($app));
        $app->post('/', '\Controller\ProductoController:newProducto')->setParams(
              array($app,$app->request->post('nombre'),
              $app->request->post('marca'),
              $app->request->post('stock'),
              $app->request->post('stock_minimo'),
              $app->request->post('proovedor'),
              $app->request->post('precio_venta_unitario'),
              $app->request->post('categoria_id'),
              $app->request->post('descripcion')));
      });


});



$app->group('/faltantes', function() use($app) {
  $app->get('/', '\Controller\ListadoController:indexActionFaltantes')->setParams(array($app));
  $app->get('/page', '\Controller\ListadoController:indexActionFaltantes')->setParams(array($app, $app->request->get('id')));
});

$app->group('/stockminimo', function() use($app) {
  $app->get('/', '\Controller\ListadoController:indexActionStockMin')->setParams(array($app));
  $app->get('/page', '\Controller\ListadoController:indexActionStockMin')->setParams(array($app, $app->request->get('id')));
});


$app->group('/users', function() use ($app, $userResource) {
    // Listar
    $app->get('/', '\Controller\ListadoController:indexActionUsuarios')->setParams(array($app));
    $app->get('/page', '\Controller\ListadoController:indexActionUsuarios')->setParams(array($app, $app->request->get('id')));

    $app->group('/altausuario', function() use($app, $userResource) {
       $app->get('/', '\Controller\UsuarioController:cargaUbicaciones')->setParams(array($app));


        $app->post('/', '\Controller\UsuarioController:newUsuario')->setParams(
              array($app, $app->request->post('user'),
              $app->request->post('pass'),
              $app->request->post('nombre'),
              $app->request->post('apellido'),
              $app->request->post('documento'),
              $app->request->post('telefono'),
              $app->request->post('rol_id'),
              $app->request->post('email'),
              $app->request->post('ubicacion_id'),
              $app->request->post('habilitado'))
      );

    });

    $app->group('/users/altausuario', function() use($app, $userResource) {
       $app->get('/', '\Controller\UsuarioController:cargaUbicaciones')->setParams(array($app));


        $app->post('/', '\Controller\UsuarioController:newUsuario')->setParams(
              array($app, $app->request->post('user'),
              $app->request->post('pass'),
              $app->request->post('nombre'),
              $app->request->post('apellido'),
              $app->request->post('documento'),
              $app->request->post('telefono'),
              $app->request->post('rol_id'),
              $app->request->post('email'),
              $app->request->post('ubicacion_id'),
              $app->request->post('habilitado'))
      );

    });

    $app->group('/edituser', function() use($app, $userResource) {
        $app->get('/', '\Controller\UsuarioController:showUsuario')->setParams(array($app, $app->request->get('id'), $app->request->get('cat')));

        $app->post('/', '\Controller\UsuarioController:editUsuario')->setParams(
               array($app, $app->request->post('user'),
               $app->request->post('pass'),
               $app->request->post('nombre'),
               $app->request->post('apellido'),
               $app->request->post('documento'),
               $app->request->post('telefono'),
               $app->request->post('rol_id'),
               $app->request->post('email'),
               $app->request->post('ubicacion_id'),
               $app->request->post('habilitado'),
               $app->request->post('userid'))
       );

    });

    $app->group('/users/edituser', function() use($app, $userResource) {
        $app->get('/', '\Controller\UsuarioController:showUsuario')->setParams(array($app, $app->request->get('id'), $app->request->get('cat')));

        $app->post('/', '\Controller\UsuarioController:editUsuario')->setParams(
               array($app, $app->request->post('user'),
               $app->request->post('pass'),
               $app->request->post('nombre'),
               $app->request->post('apellido'),
               $app->request->post('documento'),
               $app->request->post('telefono'),
               $app->request->post('rol_id'),
               $app->request->post('email'),
               $app->request->post('ubicacion_id'),
               $app->request->post('habilitado'),
               $app->request->post('userid'))
       );

    });

    $app->get('/delete', '\Controller\UsuarioController:deleteUsuario')->setParams(array($app, $app->request->get('id')));
    $app->get('/users/delete', '\Controller\UsuarioController:deleteUsuario')->setParams(array($app, $app->request->get('id')));



});



$app->group('/ventasprod', function() use($app) {
    $app->get('/', function() use($app){
        echo $app->view->render('ventasprod.twig');
    });
});



$app->group('/altaventa', function() use($app) {
    $app->get('/', '\Controller\IngresoDetalleController:showAltaVenta')->setParams(array($app));
    $app->post('/', '\Controller\IngresoDetalleController:newIngresoDetalle')->setParams(
          array($app,$app->request->post('ingreso_tipo_id'),
          $app->request->post('producto_id'),
          $app->request->post('cantidad'),
          $app->request->post('precio_unitario'),
          $app->request->post('descripcion')));

  });






$app->group('/compras', function() use ($app) {
  $app->get('/', '\Controller\ListadoController:indexActionCompras')->setParams(array($app));
  $app->get('/page', '\Controller\ListadoController:indexActionCompras')->setParams(array($app, $app->request->get('ids')));

  $app->group('/altacompra', function() use($app) {
        $app->get('/', '\Controller\CompraController:showAltaCompra')->setParams(array($app));
        $app->post('/', 'Controller\CompraController:newCompra')->setParams(
              array($app, $app->request->post('proveedor'),
              $app->request->post('proveedor_cuit')));

        });
  $app->group('/egresos', function() use ($app) {
        $app->get('/', '\Controller\ListadoController:indexActionEgresos')->setParams(array($app, $app->request->get('user')));
        $app->get('/page', '\Controller\ListadoController:indexActionEgresos')->setParams(array($app, $app->request->get('user'),$app->request->get('ids')));
      });
  $app->group('/compras/egresos', function() use ($app) {
        $app->get('/', '\Controller\ListadoController:indexActionEgresos')->setParams(array($app,$app->request->get('user')));
        $app->get('/page', '\Controller\ListadoController:indexActionEgresos')->setParams(array($app, $app->request->get('user'),$app->request->get('ids')));

    });
    $app->group('/agregarproductoacompra', function() use($app) {
       $app->get('/', '\Controller\CompraController:showAltaCompra2')->setParams(array($app,$app->request->get('id')));
         $app->post('/', '\Controller\EgresoDetalleController:newEgresoDetalle')->setParams(
              array($app,$app->request->post('compra'),
              $app->request->post('producto'),
              $app->request->post('cantidad'),
              $app->request->post('precio_unitario'),
              $app->request->post('egreso_tipo_id')));


    });
    $app->group('/compras/agregarproductoacompra', function() use($app) {
       $app->get('/', '\Controller\CompraController:showAltaCompra2')->setParams(array($app,$app->request->get('id')));
         $app->post('/', '\Controller\EgresoDetalleController:newEgresoDetalle')->setParams(
              array($app,$app->request->post('compra'),
              $app->request->post('producto'),
              $app->request->post('cantidad'),
              $app->request->post('precio_unitario'),
              $app->request->post('egreso_tipo_id')));


    });

    $app->group('/editCompra', function() use($app) {
          $app->get('/', '\Controller\CompraController:showEditCompra')->setParams(array($app, $app->request->get('id')));
          $app->post('/', '\Controller\CompraController:editCompra')->setParams(
                   array($app, $app->request->post('editproveedor'),
                   $app->request->post('editproveedor_cuit'),
                  $app->request->post('compraid')));

    });


    $app->group('/compras/editCompra', function() use($app) {
          $app->get('/', '\Controller\CompraController:showEditCompra')->setParams(array($app, $app->request->get('id')));
          $app->post('/', '\Controller\CompraController:editCompra')->setParams(
                   array($app, $app->request->post('editproveedor'),
                   $app->request->post('editproveedor_cuit'),
                  $app->request->post('compraid')));

    });

    $app->get('/deleteCompra', '\Controller\CompraController:deleteCompra')->setParams(array($app, $app->request->get('id')));
    $app->get('/compras/deleteCompra', '\Controller\CompraController:deleteCompra')->setParams(array($app, $app->request->get('id')));


});

$app->group('/ingresos', function() use ($app) {
  $app->get('/', '\Controller\ListadoController:indexActionIngresos')->setParams(array($app));
  $app->get('/page', '\Controller\ListadoController:indexActionIngresos')->setParams(array($app, $app->request->get('id')));

  $app->group('/editingreso', function() use($app) {
      $app->get('/', '\Controller\IngresoDetalleController:showEditVenta')->setParams(array($app, $app->request->get('id')));
      $app->post('/', '\Controller\IngresoDetalleController:edit')->setParams(
          array($app,$app->request->post('producto_id'),
          $app->request->post('cantidad'),
          $app->request->post('precio_unitario'),
          $app->request->post('ingreso_tipo_id'),
          $app->request->post('descripcion'),
          $app->request->post('ingresoid')));

});

$app->get('/deleteVenta', '\Controller\IngresoDetalleController:deleteIngreso')->setParams(array($app, $app->request->get('id'))); 

});





$app->group('/config', function() use($app) {
  $app->get('/', '\Controller\ConfigController:showConfig')->setParams(array($app));

  $app->post('/setPaginacion', '\Controller\ConfigController:setPaginacion')->setParams(
           array($app, $app->request->post('paginacionInt')));
  $app->post('/setDescripcion', '\Controller\ConfigController:setDescripcion')->setParams(
           array($app, $app->request->post('titleInfo'),$app->request->post('descInfo')));
  $app->post('/setMenu', '\Controller\ConfigController:setMenu')->setParams(
           array($app, $app->request->post('menuTitulo'),$app->request->post('menuInfo')));
});




$app->run();
?>
