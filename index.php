<?php
require 'db.php';
require 'lib/autoload.php';
require 'helper/helper.php';
$app = new \Slim\Slim(array(
    'mode' => 'development'
));

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});

 // getPatients();
 $app->get('/', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API";
});

$app->get('/patients', 'getPatients');
// $app->get('/patients/:id', 'getPatientById');
// $app->get('/patients/search/:query', 'findByName');
// $app->get('/patients', 'addPatient');
// $app->put('/patients/:id', 'updatePatient');
// $app->delete('/patients/:id', 'deletePatient');

$app->run();

function getPatients()
{
   //echo 'Adrian Mercado';
  //echo "id: " .  $id;
   $sql_query = "select `lname`,`fname`,`id` FROM patient_data ORDER BY lname";
    try {
        $dbCon = getDB();
        $stmt   = $dbCon->query($sql_query);
        $patients  = $stmt->fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
        echo '{"users": ' . json_encode($patients) . '}';
    }
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 
}

?>