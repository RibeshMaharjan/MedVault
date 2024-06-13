<?php
    session_start();

    require 'conn.php';

    function validate($inputdata){
        
        global $conn;
        
        $validatedData = mysqli_real_escape_string($conn, $inputdata);
        return trim($validatedData);
    }

    function redirect($url, $status){
        if ($url === 'back') {
            $url = $_SERVER['HTTP_REFERER'];
        }
        $_SESSION['status'] = $status;
        header('Location: '.$url);
        exit(0);
    }

    function webSetting($columnname){
        $setting = getById('settings','id',1);
        if($setting['status'] == 200){
            return $setting['data'][$columnname];
        }
    }

    function getmedicine($columnname,$id){
        $setting = getById('tbl_medicine','id',$id);
        if($setting['status'] == 200){
            return $setting['data'][$columnname];
        }
    }
    function logoutsession(){
        unset($_SESSION['auth']);
        unset($_SESSION['loggedInUserRole']);
        unset($_SESSION['loggedInUser']);
    }

    function alertmessage(){
        if(isset($_SESSION['status'])){
            echo 
                '<div class="alert alert-success w-25" role="alert">
                    '.$_SESSION['status'].'
                </div>';
            unset($_SESSION['status']);
        }
    }

    function checkParamId($paramType){

        if(isset($_GET[$paramType])){
            if($_GET[$paramType] != null){
                return $_GET[$paramType];
            }else{
                return 'No Id Found';
            }

        }else{
            return 'No Id Given';
        }
    }

    function getAll($tableName) { 

        global $conn;

        $table = validate($tableName);

        $query = "SELECT * FROM $table";
        $result = mysqli_query($conn,$query);
        return  $result;
    }

    function getAllProducts($tableName) { 

        global $conn;

        $table = validate($tableName);

        $query = "SELECT * FROM $table ORDER BY rand()";
        $result = mysqli_query($conn,$query);
        return  $result;
    }

    function getRandom($tableName,$type) { 

        global $conn;

        $table = validate($tableName);

        $query = "SELECT * FROM $table WHERE dosage='$type' ORDER BY rand() LIMIT 5";
        $result = mysqli_query($conn,$query);
        return  $result;
    }

    function getById($tableName, $col_name, $id){
        global $conn;

        $table = validate($tableName);
        $email = validate($id);

        $query ="SELECT * FROM $table WHERE $col_name='$id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array( $result , MYSQLI_ASSOC);
                $response = [
                    'status' => 200,
                    'message' => 'Data Fetched',
                    'data' => $row
                ];
                return $response;

            }else{
                $response = [
                    'status' => 404,
                    'message' => 'No Data Record'
                ];
                return $response;
            }
        }else{
            $response = [
                'status' => 500,
                'message' => 'Something Went Wrong'
            ];
            return $response;
        }
    }
    function getAllById($tableName, $col_name, $id){
        global $conn;

        $table = validate($tableName);
        $email = validate($id);

        $query ="SELECT * FROM $table WHERE $col_name='$id'";
        $result = mysqli_query($conn, $query);

        if($result){
            if(mysqli_num_rows($result) >= 1){
                $response = [
                    'status' => 200,
                    'message' => 'Data Fetched',
                    'data' => $result
                ];
                return $response;

            }else{
                $response = [
                    'status' => 404,
                    'message' => 'No Data Record'
                ];
                return $response;
            }
        }else{
            $response = [
                'status' => 500,
                'message' => 'Something Went Wrong'
            ];
            return $response;
        }
    }

    function deleteQuery($tableName,$col_name, $email){
        global $conn;

        $table = validate($tableName);
        $email = validate($email);

        $query = "DELETE FROM $table WHERE $col_name='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    // Get Total
    function getTotal($table){
        global $conn;
        $query = "SELECT * FROM $table";
        $data = mysqli_query($conn,$query);
        $result = mysqli_num_rows($data);

        if($data){
            return $result;
        }else{
            return "Null";
        }
    }

    function getTotalById($table,$col_name, $id){
        global $conn;
        $query = "SELECT * FROM $table WHERE $col_name='$id'";
        $data = mysqli_query($conn,$query);
        $result = mysqli_num_rows($data);

        if($data){
            return $result;
        }else{
            return "Null";
        }
    }

    function countcartitem(){
        global $conn;
        $user_id = $_SESSION['loggedInUser']['user_id'];
        $query ="SELECT * FROM cart WHERE pharmacy_id='$user_id'";
        $result = mysqli_query($conn, $query);
        $total = 0;
        while($row = mysqli_fetch_assoc($result)){
            $total += $row['quantity'];
        }
        return $total;
    }

?>