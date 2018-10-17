<?php
$Result = "";
if(isset($_POST['__userid__'])){ //if form is submit.
	if(strlen($_POST['__userid__']) != 0 && $_POST['__userid__'] != null){ //if __userid__ not empty or null
		//get new json text from getUserPost function
		$post_obj = getUserPost($_POST['__userid__']);
		//check if return value is not empty
		if(count($post_obj) > 0){ $Result = "<hr><pre>".json_encode($post_obj, JSON_PRETTY_PRINT)."</pre><hr>"; }
		//check final result is not empty.
		if(count($post_obj) == 0){ $Result = "<hr>no have user with this id, try again !!<hr>"; }
	}else{
		//if no any user id is set correctly.
		$Result = "<hr>please insert user id !!<hr>";
	}
}
function getUserPost($__userid__){
	//make json format as array to hold new data. 
	$json				= array();
	//receive data in json format from posts file.
	$PostInfo			= json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'));
	//calculate "length" how many rows in data that recieved from posts file.
	$PostInfoCount		= count((array)$PostInfo);
	//receive data in json format from comments file.
	$CommentsInfo		= json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'));
	//calculate "length" how many rows in data that recieved from comments file.
	$CommentInfoCount	= count((array)$CommentsInfo);
	//set starting index for new posts json array.
	$x 					= 0;
	//while loop
	$i					= 0;
	while ($i < $PostInfoCount) {
		if($PostInfo[$i]->userId == $__userid__) { //if user id that requested equel to userId within received posts json => pass
			//new object for this post and set the values 
			$json[$x] = new stdClass;
			$json[$x]->userId = $PostInfo[$i]->userId;
			$json[$x]->id	  = $PostInfo[$i]->id;
			$json[$x]->title  = $PostInfo[$i]->title;
			$json[$x]->body	  = $PostInfo[$i]->body;
			//set starting index for new comments object.
			$y = 0;
			// set array variable for comments.
			$PostComment = array();
			//while loop
			$a = 0;
			while ($a < $CommentInfoCount) {
				if($CommentsInfo[$a]->postId == $PostInfo[$i]->id) { //if comment postId equal id for post => pass
					//new object for the comments of this post and set the values 
					$PostComment[$y] = new stdClass;
					$PostComment[$y]->id	= $CommentsInfo[$a]->id;
					$PostComment[$y]->name	= $CommentsInfo[$a]->name;
					$PostComment[$y]->email	= $CommentsInfo[$a]->email;
					$PostComment[$y]->body	= $CommentsInfo[$a]->body;
					$y++;
				}
				$a++;
			}
			//set new key and value for comments
			$json[$x]->comment = $PostComment;
			$x++;
		}
		$i++;
	}
	return $json;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Question 1</title>
</head>
<body>
	<form action="" method="POST">
		<span>Please type user id :</span>
		<input type="text" name="__userid__" autocomplete="off">
		<input type="submit" name="__submit__">
	</form>
	<div id="demo"><?php echo $Result; ?></div>
</body>
</html>