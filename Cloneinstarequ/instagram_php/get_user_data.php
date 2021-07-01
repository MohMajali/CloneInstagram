<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["user_id"])){
				
				 $user_id = $_GET["user_id"];
				
			
				 $stmt = $con->prepare("SELECT id, username, email,image,followers,following,posts FROM users WHERE id = ?");
				 $stmt->bind_param("i",$user_id);
				
				
		
				if($stmt->execute()){
					
					 $stmt->bind_result($id, $username, $email,$image,$followers,$following,$posts);
					 $stmt->fetch();
					 
					 $user = array(
					 'id'=>$id, 
					 'username'=>$username, 
					 'email'=>$email,
					 'image'=>$image,
					 'followers'=>$followers,
					 'following'=>$following,
					 'posts'=>$posts
					 );
					 
					
                     $response['error'] = false;					 
					 $response['user'] = $user; 
					 $response['message']="user data returned successfully";
					 $stmt->close();
					
				}else{
					
					
                     $response['error'] = true;		
                     $response['message']="could not return user data";					 
					 $stmt->close();
					
					
				}
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>