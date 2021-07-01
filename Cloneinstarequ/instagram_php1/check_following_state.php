<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["other_user_id"])&& isset($_GET['user_id'])){
				
				 $other_user_id = $_GET["other_user_id"]; //other_user_id
				 $user_id = $_GET['user_id'];  //user_id
				
			
				
	
				 $stmt = $con->prepare("SELECT * FROM following WHERE user_id = ? AND other_user_id= ? ");
				 $stmt->bind_param("ii", $user_id, $other_user_id);
				 $stmt->execute();
				 $stmt->store_result();
							 
						 if($stmt->num_rows == 1){
								 $response['error'] = false;
								 $response['message'] = 'you are already following this person';
								 $response['state'] = true;
							
						 }else{
							    $response['error'] = false;
								 $response['message'] = 'you are not following this person';
								 $response['state'] = false;
								
							 
						 }
						 
						  $stmt->close();
			
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>