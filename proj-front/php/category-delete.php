<?php
    require('../../config/function.php');

    // Check if request is coming from modal form
    if(isset($_POST['delete-category']) && isset($_POST['delete_category_id'])) {
        $category_id = validate($_POST['delete_category_id']);
        
        // Process deletion
        processCategoryDeletion($category_id);
    }
    // Check if request is coming from direct link (backwards compatibility)
    else if(isset($_GET['c_id'])) {
        $paraResult = checkParamId('c_id');
        if(is_numeric($paraResult)){
            $category_id = validate($paraResult);
            
            // Process deletion
            processCategoryDeletion($category_id);
        }else{
            redirect('../category.php', $paraResult);
        }
    }
    else {
        redirect('../category.php', 'Invalid request');
    }
    
    // Function to handle category deletion process
    function processCategoryDeletion($category_id) {
        global $conn;
        
        // Check if category has medicines before deletion
        $medicine_check = mysqli_query($conn, "SELECT COUNT(*) as count FROM user_medicine_tbl WHERE c_id = '$category_id'");
        $medicine_count = mysqli_fetch_assoc($medicine_check)['count'];
        
        if($medicine_count > 0) {
            // Category has medicines - show warning
            redirect('../category.php', 'Cannot delete: This category contains ' . $medicine_count . ' medicines. Please reassign them first.');
            return;
        }
        
        // Get category info before deletion
        $category = getById('user_category_tbl', 'c_id', $category_id);
        if($category['status'] == 200){
            $categorydelete = deleteQuery('user_category_tbl', 'c_id', $category_id);
            if($categorydelete){
                redirect('../category.php','Category deleted successfully');
            }else{
                redirect('../category.php','Something went wrong!');
            }
        }else{
            redirect('../category.php','Category not found');
        }
    }
?>