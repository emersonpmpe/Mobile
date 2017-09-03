<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['telefone'])) {

    // receiving the post params
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
	$telefone = $_POST['telefone'];

    // check if user is already existed with the same email
    if ($db->isUserExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        $usuario = $db->storeUser($nome, $email, $senha, $telefone);
        if ($usuario) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["usuario"]["nome"] = $usuario["nome"];
            $response["usuario"]["email"] = $usuario["email"];
			$response["usuario"]["telefone"] = $usuario["telefone"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (nome, email, senha or telefone) is missing!";
    echo json_encode($response);
}
?>

