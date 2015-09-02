<?php
echo '<h2>hee</h2>';
require 'db.php';
//var $g = {$GLOBALS['srcdir']}/patient.inc");

//var $s = getDB();

// var_dump($s)

require 'lib/autoload.php';
// $app =  new \Slim\Slim();
 
$app = new \Slim\Slim(array(
    'mode' => 'development'
));
 
// $app->get('/', function() use($app) {
//     $app->response->setStatus(200);
//     echo "Welcome to Slim 3.0 based API";
// });  
//      OR
 $app->get('/', function() {
    $app = \Slim\Slim::getInstance();
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API";
});
$app->run();

?>