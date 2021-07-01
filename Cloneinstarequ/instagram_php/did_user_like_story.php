<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET['story_id']) && isset($_GET['user_id'])){
			
			$story_id = $_GET['story_id'];
			$user_id = $_GET['user_id'];
				
	 
				 $stmt = $con->prepare("SELECT * FROM likes WHERE user_id = ? AND  story_id = ?");
				 $stmt->bind_param("ii", $user_id, $story_id);
				 $stmt->execute();
				 $stmt->store_result();
				 
			 if($stmt->num_rows > 0){
					 $response['error'] = false;
					 $response['message'] = 'User already liked this story!';
					 $response['state'] = true;
					
			 }else{
				 
				    $response['error'] = false;
					 $response['message'] = 'User has not liked this story yet!';
					 $response['state'] = false;
			 
				
			 }
			  $stmt->close();
 
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>