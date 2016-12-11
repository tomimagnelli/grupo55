<?php

$mensaje = 'No tiene los permisos para acceder a esa seccion.';

$app->hook('must.be.administrador', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }else{
        if ($_SESSION['rol']!==1) {
            $app->flash('error', $mensaje);
            $app->redirect('/');
        }
    }
});

$app->hook('must.be.administrador.or.gestion', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }else{
        if ($_SESSION['rol'] == 2) {
            $app->flash('error', $mensaje);
            $app->redirect('/');
        }
    }
});

$app->hook('must.be.online', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }else{
        if ($_SESSION['rol'] !== 2) {
            $app->flash('error', $mensaje);
            $app->redirect('/');
        }
    }
});

$app->hook('must.be.logueado', function () use ($app, $mensaje) {
    if (!isset($_SESSION['rol'])) {
        $app->flash('error', $mensaje);
        $app->redirect('/');
    }
});



 ?>
