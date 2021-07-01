<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["story_id"])&& isset($_GET['user_id'])){
				
				 $story_id = $_GET["story_id"];
				 $user_id = $_GET['user_id']; 
				
			
				
	
				  $stmt = $con->prepare("DELETE FROM likes WHERE user_id = ? AND story_id = ? LIMIT 1");
				  
				  $stmt->bind_param("ii", $user_id, $story_id);
				
							 
						 if($stmt->execute()){
								 $response['error'] = false;
								 $response['message'] = 'user was deleted from likes db!';
							
								 
							
						 }else{
							    $response['error'] = true;
								 $response['message'] = 'could not delete user from likes db!';
								 
								
							 
						 }
						 
						  $stmt->close();
			
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>