<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($nome, $email, $senha, $telefone) {

        $stmt = $this->conn->prepare("INSERT INTO usuarios(nome, email, senha, telefone) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("ssss",$nome, $email, $senha, $telefone);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $usuario = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $usuario;
        } else {
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $senha) {

        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $usuario = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $senha = $usuario['senha'];
            // check for password equality
            if ($senha == $senha) {
                // user authentication details are correct
                return $usuario;
            }
        } else {
            return NULL;
        }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from usuarios WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
}

?>
