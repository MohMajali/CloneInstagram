<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(AllParametersAreNotNull(array('user_id','story_id','username','profile_image','comment_text','time'))){
				 $user_id = $_POST['user_id']; 
				 $story_id = $_POST['story_id']; 
				 $username =  $_POST['username'];
				 $profile_image = $_POST['profile_image'];
				 $comment_text = $_POST['comment_text'];
				 $time = $_POST['time'];
				 
			
	
					 $stmt = $con->prepare("INSERT INTO comments (user_id, story_id, username,profile_image,comment_text,time) VALUES (?,?,?,?,?,?)");
					 $stmt->bind_param("iissss", $user_id, $story_id, $username,$profile_image,$comment_text,$time);
					 
				 if($stmt->execute()){
					 
					 $comment_id = mysqli_insert_id($con);
			
					 
					 $comment = array(
					 'comment_id'=>$comment_id, 
					 'user_id'=>$user_id, 
					 'story_id'=>$story_id,
					 'username'=>$username,
					 'profile_image'=>$profile_image,
					 'comment_text'=>$comment_text,
					 'time'=>$time
					 );
					 
					 $stmt->close();
					 
					 $response['error'] = false; 
					 $response['message'] = 'comment added successfully!'; 
					 $response['comment'] = $comment; 
				  }
			 
 
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 
 function AllParametersAreNotNull($params){
 
 foreach($params as $param){
 if(!isset($_POST[$param])){
 return false; 
 }
 }
 return true; 
 }
 
 
 ?>