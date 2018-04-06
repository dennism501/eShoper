<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/1/18
 * Time: 12:23 PM
 */

class db_connect{


    private $connection;

    public function connect(){

        require_once 'config.php';

        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        return $this->connection;


    }


}