<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['email']) && isset($_POST['senha'])) {

    // receiving the post params
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // get the user by email and password
    $usuario = $db->getUserByEmailAndPassword($email, $senha);

    if ($usuario != false) {
        // use is found
        $response["error"] = FALSE;
        $response["usuario"]["nome"] = $usuario["nome"];
        $response["usuario"]["email"] = $usuario["email"];
		$response["usuario"]["telefone"] = $usuario["telefone"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or senha is missing!";
    echo json_encode($response);
}
?>

