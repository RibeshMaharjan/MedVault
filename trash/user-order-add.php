<?php
    include '../../config/function.php';

    $user_email = $_SESSION['loggedInUser']['email'];
    $user = getById('tbl_pharmacy','email',$user_email);
    echo $user['status'];
    // echo $user['data']['pharmacy_id'];

    if(isset($_POST['order-purchase'])){

        $medicine_id = checkParamId('medicine_id');
        $result = getById('tbl_medicine','medicine_id',$medicine_id);
        $medicine_name = $result['data']['medicine_name'];
        $manufacturer_name = $result['data']['manufacturer'];
        $price = $result['data']['price'];
        $date = $result['data']['expiration_date'];
        $dosage = $result['data']['dosage'];
        $fileNameNew = $result['data']['images'];

        $order_id = mt_rand (10000,99999);
        $user_id = $user['data']['pharmacy_id'];
        $amount_due = $_POST["subtotal"];
        $invoice_number = mt_rand();
        $product_quantity = $_POST["quantity"];
        $payment_option = $_POST["payment"];
        $city = $_POST["city"];
        $province = $_POST["state"];
        $street = $_POST["street-address"];
        $postal = $_POST["postal-code"];
        $status = "pending";

        
        $query = "INSERT INTO user_orders (order_id,user_id, medicine_id, invoice_number, total_products, amount, order_status) VALUES ('$order_id','$user_id','$medicine_id','$invoice_number','$product_quantity','$amount_due','$status')";
        // $data = mysqli_query($conn,$query);

        if ($conn->query($query) === TRUE) {
            // Retrieve the order_id generated for the newly inserted row
            // $order_id = $conn->insert_id;
        
            // Insert data into the order_address table using the retrieved order_id
            $sql_insert_order_address = "INSERT INTO order_address (order_id, city, province, street, postal)VALUES ('$order_id', '$city','$province','$street','$postal')";
            $sql_insert_order_pending = "INSERT INTO order_pending (order_id, user_id, medicine_id, invoice_number , total_products, amount, order_status)VALUES('$order_id','$user_id','$medicine_id','$invoice_number','$product_quantity','$amount_due','$status')";
            $sql_insert_order_inventory = "INSERT INTO inventory (medicine_id,medicine_name,manufacturer,price,quantity,expiration_date,dosage, image) VALUES('','$medicine_name','$manufacturer_name','$price','$product_quantity','$date','$dosage','../uploaded_img/$fileNameNew')";
        
            if (($conn->query($sql_insert_order_address) === TRUE) && ($conn->query($sql_insert_order_pending) === TRUE) && ($conn->query($sql_insert_order_inventory) === TRUE)) {
                if($payment_option == "esewa"){
                    redirect("e-sewa.php?order_id=$order_id&product_amount=$amount_due",'');
                }else{
                    redirect('../medicine.php','Your Order has been submitted.');
                }
            } else {
                echo "Error inserting data into order_address table: " . $conn->error;
            }
        } else {
            echo "Error inserting data into user_orders table: " . $conn->error;
        }

        // if($data){
        //     echo "<br>stored";
        //     // redirect('admin.php','data inserted');
        // }
        // else{
        //     echo "failed";
        // }
    }
?>