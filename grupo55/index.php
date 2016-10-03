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

});

$app->group('/backend', function() use($app) {
	$app->get('/', function() use($app){
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

$app->group('/users', function() use($app) {
    $app->get('/', function() use($app){
        echo $app->view->render('users.twig');
    });
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