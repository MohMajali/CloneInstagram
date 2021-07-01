<?php 
 
 require_once 'connection.php';
 
 $response = array();
 

/*########## RESISTER #########*/
 if(AllParametersAreNotNull(array('username','email','password'))){
				 $username = $_POST['username']; 
				 $email = $_POST['email']; 
				 $password = md5($_POST['password']);
				 $image = "http://mifo.000webhostapp.com/users_images/default_image.jpg";
				 $followers = 0;
				 $following = 0;
				 $posts = 0;
				
	 
				 $stmt = $con->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
				 $stmt->bind_param("ss", $username, $email);
				 $stmt->execute();
				 $stmt->store_result();
				 
			 if($stmt->num_rows > 0){
					 $response['error'] = true;
					 $response['message'] = 'User already registered';
					 $stmt->close();
			 }else{
					 $stmt = $con->prepare("INSERT INTO users (username, email, password,image,followers,following,posts) VALUES (?, ?, ?,?,?,?,?)");
					 $stmt->bind_param("ssssiii", $username, $email, $password,$image,$followers,$following,$posts);
					 
				 if($stmt->execute()){
					 $stmt = $con->prepare("SELECT id, username, email,image,followers,following,posts FROM users WHERE username = ?"); 
					 $stmt->bind_param("s",$username);
					 $stmt->execute();
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
					 
					 $stmt->close();
					 
					 $response['error'] = false; 
					 $response['message'] = 'User registered successfully'; 
					 $response['user'] = $user; 
				  }
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