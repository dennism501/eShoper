<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/6/18
 * Time: 11:03 AM
 */

require_once ('db_functions.php');

$db = new db_functions();

$db->getUser('user123','1234');