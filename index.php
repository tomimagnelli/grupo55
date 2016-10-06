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




$app->get('/', function () use ($app) {
    $app->render('index.twig');
});

// login...
$app->post('/', function() use ($app, $userResource) {
	  $name = $app->request->post('usuario');
    $pass = $app->request->post('contraseña');
    $user = $userResource->login($name, $pass);
    if ($user) {
    	$_SESSION['id']=$user->getId();
    	$_SESSION['user']=$user->getUsuario();
    	$_SESSION['rol']=$user->getRol_Id();
    	$app->flash('success', 'Usuario logueado correctamente como '. $user->getUsuario());
    	$app->redirect('/backend');
    } else {
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

$app->group('/backend', function() use($app) {
	$app->get('/', function() use($app){
      $app->applyHook('must.be.logueado');
	 	echo $app->view->render('backend.twig');
	});
});

$app->group('/listado', function() use($app) {
    $app->get('/', function() use($app){
        echo $app->view->render('listado.twig');
    });
});


$app->group('/altaproducto', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('altaproducto.twig');
	});
});

$app->group('/users', function() use ($app, $userResource) {
    // Listar
    $app->get('/', '\Controller\UsuarioController:listUsuarios')->setParams(array($app));
});

$app->group('/altausuario', function() use($app) {
    $app->get('/', function() use($app){
        echo $app->view->render('altausuario.twig');
    });
});

$app->group('/ventasprod', function() use($app) {
    $app->get('/', function() use($app){
        echo $app->view->render('ventasprod.twig');
    });
});

$app->group('/altaventa', function() use($app) {
    $app->get('/', function() use($app){
        echo $app->view->render('altaventa.twig');
    });
});
$app->group('/compras', function() use($app) {
    $app->get('/', function() use($app){
        echo $app->view->render('compras.twig');
    });
});

$app->group('/altacompra', function() use($app) {
    $app->get('/', function() use($app){
        echo $app->view->render('altacompra.twig');
    });
});




$app->run();
?>
