<?php
// Routes

require  '../class/db.class/db.conn.php';



//VISTA USUARIOS
$app->get('/menu', function($req, $res) use($app){
    return $this->renderer->render($res, 'menu/menu_creator.php');
});