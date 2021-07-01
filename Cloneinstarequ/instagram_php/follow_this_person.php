<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["other_user_id"])&& isset($_GET['user_id'])){
				
				 $other_user_id = $_GET["other_user_id"]; //other_user_id
				 $user_id = $_GET['user_id'];  //user_id
				
			
				
	
				 $stmt = $con->prepare("INSERT INTO following (user_id,other_user_id) VALUES (?,?) ");
				  $stmt2 = $con->prepare("UPDATE users SET following=following+1 WHERE id = ? ");
				  $stmt3 = $con->prepare("UPDATE users SET followers=followers+1 WHERE id = ? ");
				 $stmt->bind_param("ii", $user_id, $other_user_id);
				 $stmt2->bind_param("i", $user_id);
				 $stmt3->bind_param("i", $other_user_id);
			
							 
						 if($stmt->execute()){
								 $response['error'] = false;
								 $response['message'] = 'you are now following this person';
								 $response['state'] = true;
								 
								 if($stmt2->execute()){
									 $response['following'] = "number of following increased";
											 
											  if($stmt3->execute()){
										         	 $response['followers'] = "number of following increased";
											 
											
											 
									          	 }else{
											         $response['followers'] = "number of following did not increase"; 
									        	 }
											
									 
								 }else{
									 $response['following'] = "number of following did not increase"; 
								 }
							
						 }else{
							    $response['error'] = true;
								 $response['message'] = 'could not execute query!';
								
								
							 
						 }
						 
						  $stmt->close();
			
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>