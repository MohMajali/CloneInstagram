<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 
 if(isset($_POST['user_id']) && isset($_POST['email'])){
	 
	 $email = $_POST['email'];
	 $user_id = $_POST['user_id'];

	
	
	 //prepering query
	 $query = $con->prepare("UPDATE users SET email= ?  WHERE id = ? ");
	
	//binding parameters
	$query->bind_param("si",$email,$user_id);

		
						if($query->execute()){
							
							$response['error'] = false;
							$response['message'] = 'User Data Updated Successfully';
							$response['email'] = $email;
							
					

						
						}else{
							$response['error'] = true;
							$response['message'] = 'Failed to update user data';
							
						}
	 
	 
	 
 }else{
	 
	 $response['error'] = true;
     $response['message']= 'not all parameters are set'; 
	 
 }
 
 echo json_encode($response);