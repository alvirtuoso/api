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
 $app->get('/patients/:id', 'getPatientById');
 $app->get('/patients/search/:query', 'findByName');
 $app->post('/patients', 'addPatient');
$app->put('/patients/:id', 'updatePatient');
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

function getPatientById($id)
{ 
  // echo "{:id}";
  //if(!IsNullOrEmptyString($id)){

      $sql = "SELECT * FROM patient_data WHERE id = :id";
    try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $query = "%".$id."%";
      $stmt->bindParam("id", $id);
      $stmt->execute();
      $patient = $stmt->fetchObject();
      $db = null;
        echo json_encode($patient);
    } catch (PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
  //}

}

function findByName($query)
{
  //echo 'finding name ';
  $sql = "SELECT * FROM patient_data WHERE UPPER(lname) LIKE :query || UPPER(fname) LIKE :query ORDER BY lname";
  try {
    $db = getDB();
    $stmt = $db->prepare($sql);
    $query = "%".$query."%";
    $stmt->bindParam("query", $query);
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
      echo '{"patient": ' . json_encode($patients) . '}';
  } catch (PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function addPatient()//$fname, $lname, $dob, $sex) 
{
  echo "hello";
     $request = \Slim\Slim::getInstance()->request();
     $patient = json_decode($request->getBody());
     var_dump($patients);
    // $sql = "INSERT INTO patient_data (fname, lname, DOB, sex) VALUES (:fname, :lname, :dob, :sex)";
    // try {
    //     $db = getConnection();
    //     $stmt = $db->prepare($sql);
    //     $stmt->bindParam("name", $patient->name);
    //     $stmt->bindParam("grapes", $patient->grapes);
    //     $stmt->bindParam("country", $patient->country);
    //     $stmt->bindParam("region", $patient->region);
    //     $stmt->bindParam("year", $patient->year);
    //     $stmt->bindParam("description", $patient->description);
    //     $stmt->execute();
    //     $patient->id = $db->lastInsertId();
    //     $db = null;
    //     echo json_encode($patient);
    // } catch(PDOException $e) {
    //     echo '{"error":{"text":'. $e->getMessage() .'}}';
    // }
}

function updateWine($id) {
    $request = \Slim\Slim::getInstance()->request();
    $body = $request->getBody();
    $patient = json_decode($body);
    $sql = "UPDATE wine SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("name", $patient->name);
        $stmt->bindParam("grapes", $patient->grapes);
        $stmt->bindParam("country", $patient->country);
        $stmt->bindParam("region", $patient->region);
        $stmt->bindParam("year", $patient->year);
        $stmt->bindParam("description", $patient->description);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($patient);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


?>