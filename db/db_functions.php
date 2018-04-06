<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/8/18
 * Time: 12:28 PM
 */
class db_functions
{


    private $conn;
    private $result = array();

    function __construct()
    {

        require_once 'db_connect.php';

        $db = new db_connect();

        $this->conn = $db->connect();

    }

    /*
    This method is used when registering a new user through the app
    and allocated a user a token which will be used to perform any action in the app
    */
    public function registerUser($firstName, $lastName, $phoneNumber, $email, $address, $username, $password)
    {

        /*password encryption*/
        $hash_password = md5($password);

        $userReg = array();

        $stmt = $this->conn->prepare("CALL CreateUser(?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss", $firstName, $lastName, $phoneNumber, $email, $address, $username, $hash_password);

        if ($stmt->execute()) {

            $userReg['result'] = 'inserted';
            echo json_encode($userReg);


        } else {

            $userReg['error'] = 'not inserted';
            echo json_encode($userReg);

        }

        $stmt->close();


    }

    /*Method used when login into the app using username, password and token*/
    public function getUser($userName, $password)
    {
        $userCred = array();

        $stmt = $this->conn->prepare("CALL GetUsernamePassword(?,?)");
        $stmt->bind_param("ss", $userName, $password);

        if ($stmt->execute()) {

            $stmt->bind_result($user_name, $pass_word, $token, $id);
            while ($stmt->fetch()) {

                $this->result['username'] = $user_name;
                $this->result['password'] = $pass_word;
                $this->result['token'] = $token;
                $this->result['id'] = $id;

                $userCred[] = $this->result;

            }

            $stmt->close();

            if (!empty($userCred)) {

                echo json_encode($userCred);

            } else {

                echo "No user found";
            }

        } else {

            echo $this->conn->error;
        }


    }


    /*
     * This method gets products that the user has previously added to their shopping list
     * */

    public function getProducts($token)
    {

        $userProducts = array();

        $stmt = $this->conn->prepare("CALL GetPurchase(?)");
        $stmt->bind_param("s", $token);

        if ($stmt->execute()) {

            $stmt->bind_result($productName, $price);
            while ($stmt->fetch()) {

                $this->result['productName'] = $productName;
                $this->result['price'] = $price;
                $userProducts[] = $this->result;


            }
            $stmt->close();
            if (!empty($userProducts)) {

                echo json_encode($userProducts);

            } else {
                $this->result['error'] = 'No products';
                echo json_encode($userProducts);

            }

        } else {

            echo $this->conn->error;
        }

    }

    public function recordPurchase($product, $price, $token)
    {
        $productReg =array();

        $stmt = $this->conn->prepare("CALL RecordPurchase(?,?,?)");
        $stmt->bind_param("sss",$product,$price,$token);

        if ($stmt->execute()) {

            $productReg['result'] = 'inserted';
            echo json_encode($productReg);


        } else {

            $productReg['error'] = 'not inserted';
            echo json_encode($productReg);

        }

        $stmt->close();


    }


}
