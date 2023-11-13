<?php
require_once 'config.php'; 

class UserModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    public function getByUserName($userName) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE userName = ?');
        $query->execute([$userName]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
