<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
/*################## LOGIN #############*/
 
 if(AllParametersAreNotNull(array('username', 'password'))){
 
			 $username = $_POST['username'];
			 $password = md5($_POST['password']); 
			 
			 $stmt = $con->prepare("SELECT id, username, email,image,followers,following,posts FROM users WHERE username = ? AND password = ?");
			 $stmt->bind_param("ss",$username, $password);
			 
			 $stmt->execute();
			 
			 $stmt->store_result();
			 
			 if($stmt->num_rows > 0){
			 
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
					 $response['message'] = 'Login successfully'; 
					 $response['user'] = $user; 
			 }else{
					 $response['error'] = true; 
					 $response['message'] = 'Invalid username or password';
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