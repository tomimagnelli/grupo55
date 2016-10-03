<?php 
// Initialize Slim (the router/micro framework used)
require_once 'vendor/autoload.php';
 
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

 
$app->get('/', function () use ($app) {
    $app->render('index.twig');
});


$app->group('/login', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('login.twig');
	});

	$app->post('/', function() use ($app, $userResource) {
	  $name = $app->request->post('usuario');
    $pass = $app->request->post('contraseña');
    $user = $userResource->login($name, $pass);
    if ($user) {
    	$_SESSION['id']=$user->getId();
    	$_SESSION['user']=$user->getUsuario();
    	$_SESSION['rol']=$user->getRol_Id();
    	$app->redirect('/backend.twig');
    } else {
      $app->flash('error', 'Usuario o contraseña incorrecto');
      $app->redirect('/');
	}
});
});

$app->group('/backend', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('backend.twig');
	});
});


$app->group('/balanceIngresos', function() use($app) {
	$app->get('/', function() use($app){
		echo $app->view->render('balanceIngresos.twig');
	});
});



$app->run();
?>