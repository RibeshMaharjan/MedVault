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
            echo '
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">MedVault</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    '.$_SESSION['status'].'
                </div>
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

        $query = "SELECT * FROM $table WHERE dosage='$type' ORDER BY rand() LIMIT 4";
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

    // File has no purpose - E-commerce functionality has been removed from the project
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

    // Pagination helper function
    function getPaginatedResults($table, $conditions = '', $page = 1, $itemsPerPage = 10) {
        global $conn;
        
        // Calculate offset
        $offset = ($page - 1) * $itemsPerPage;
        
        // Get total records
        $countQuery = "SELECT COUNT(*) as total FROM $table " . ($conditions ? "WHERE $conditions" : "");
        $countResult = mysqli_query($conn, $countQuery);
        $totalRecords = mysqli_fetch_assoc($countResult)['total'];
        
        // Get paginated records
        $query = "SELECT * FROM $table " . 
                 ($conditions ? "WHERE $conditions " : "") . 
                 "LIMIT $itemsPerPage OFFSET $offset";
        $result = mysqli_query($conn, $query);
        
        // Calculate total pages
        $totalPages = ceil($totalRecords / $itemsPerPage);
        
        return [
            'data' => $result,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalRecords' => $totalRecords,
            'hasNextPage' => $page < $totalPages,
            'hasPrevPage' => $page > 1
        ];
    }

    // Generate pagination links
    function generatePaginationLinks($currentPage, $totalPages, $urlPattern) {
        $links = '';
        $links .= '<nav aria-label="Page navigation" class="mt-4"><ul class="pagination justify-content-center">';
        
        // Previous button
        $prevClass = $currentPage <= 1 ? ' disabled' : '';
        $links .= sprintf(
            '<li class="page-item%s"><a class="page-link" href="%s">Previous</a></li>',
            $prevClass,
            str_replace('{page}', $currentPage - 1, $urlPattern)
        );
        
        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = $i == $currentPage ? ' active' : '';
            $links .= sprintf(
                '<li class="page-item%s"><a class="page-link" href="%s">%d</a></li>',
                $activeClass,
                str_replace('{page}', $i, $urlPattern),
                $i
            );
        }
        
        // Next button
        $nextClass = $currentPage >= $totalPages ? ' disabled' : '';
        $links .= sprintf(
            '<li class="page-item%s"><a class="page-link" href="%s">Next</a></li>',
            $nextClass,
            str_replace('{page}', $currentPage + 1, $urlPattern)
        );
        
        $links .= '</ul></nav>';
        return $links;
    }

?>