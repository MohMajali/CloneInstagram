<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["other_user_id"])&& isset($_GET['user_id'])){
				
				 $other_user_id = $_GET["other_user_id"]; //other_user_id
				 $user_id = $_GET['user_id'];  //user_id
				
			
				
	
				  $stmt = $con->prepare("DELETE FROM following WHERE user_id = ? AND other_user_id = ? LIMIT 1");
				  $stmt2 = $con->prepare("UPDATE users SET following=following-1 WHERE id = ? ");
				  $stmt3 = $con->prepare("UPDATE users SET followers=followers-1 WHERE id = ? ");
				  
				  $stmt->bind_param("ii", $user_id, $other_user_id);
				  $stmt2->bind_param("i", $user_id);
                  $stmt3->bind_param("i", $other_user_id);
			
							 
						 if($stmt->execute()){
								 $response['error'] = false;
								 $response['message'] = 'you have unfollowed this person';
								 $response['state'] = false;
								 
								 
								  if($stmt2->execute()){
									 $response['following'] = "number of following deceased";
											 
											  if($stmt3->execute()){
										         	 $response['followers'] = "number of following decreased";
											 
											
											 
									          	 }else{
											         $response['followers'] = "number of following did not decrease"; 
									        	 }
											
									 
								 }else{
									 $response['following'] = "number of following did not decrease"; 
								 }
							
						 }else{
							    $response['error'] = true;
								 $response['message'] = 'could not execute this query!';
								 
								
							 
						 }
						 
						  $stmt->close();
			
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>