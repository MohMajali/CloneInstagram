<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["story_id"])){
				
				 $story_id = $_GET["story_id"]; 
		
				 
				  $stmt = $con->prepare("UPDATE stories SET num_of_likes=num_of_likes-1 WHERE id = ? ");
			
				 $stmt->bind_param("i", $story_id);
			
							 
						 if($stmt->execute()){
								 $response['error'] = false;
								 $response['message'] = 'likes decreased';
								
								 
							
						 }else{
							     $response['error'] = true;
								 $response['message'] = 'likes did not decrease';
								
								
							 
						 }
						 
						  $stmt->close();
			
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>