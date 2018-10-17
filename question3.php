<?php
// 0=>Index   1=>Year   2=>Age   3=>Name   4=>Movie
// open oscar file.
$mainfile 	= fopen("oscar.csv","r");
/*  First Request  */
// set variable for maximum oscars number that own by actor.
$max		= 0	;
// set variable for hold actor name that has maximum oscars number.
$name_max	= "";
/*  second Request  */
// set variable for hold age of actor has older age.
$old		= "";
// set variable to hold name of actor.
$name_old	= "";
// set variable to hold year when actor has get oscar.
$year_old	= "";
// set variable to hold movie name for actor
$movie_old	= "";
/*  thrid Request  */
//set array for actors have more oscars.
$row		= array();
//start loop and check end of file pointer with feof function to continue.
while(!feof($mainfile)){
	//fgetcsv is function to get line from file pointer and parse.
	$Data	= fgetcsv($mainfile);
	if(isset($Data[0]) && isset($Data[1]) && isset($Data[2]) && isset($Data[3]) && isset($Data[4])){
		//reopen the file for make compired between lines of csv file.
		$targetfile = fopen("oscar.csv","r");
		$repeat		= 0;
		while(!feof($targetfile)){
			$text	= fgetcsv($targetfile);
			//if actor name is repeated then $repeat variable increased by one
			if($Data[3] == $text[3]){
				$repeat++;
			}
		}
		fclose($targetfile);
		//if repeating time more than max value that record it, hold it with $max variable 'first request'
		if($repeat > $max){
			$max	= $repeat;
			$name_max = $Data[3];
		}
		//if the age of actor is lager then last age that record it, hold it and record its related data.
		if($Data[2] > $old){
			$old = $Data[2];
			$name_old	= $Data[3];
			$year_old	= $Data[1];
			$movie_old	= $Data[4];			
		}
		//if the repeat time for oscar number that own by actor, push actor name and how many oscar he has get it 'third request'.
		if($repeat > 1){
			$html = "<tr>
						<td>$Data[3]</td>
						<td  style='text-align:center;'>$repeat</td>
					</tr>";
			if(!in_array($html, $row)){
				$row[] = $html;
			}
		}
	}
}
fclose($mainfile);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Question 3</title>
</head>
<body>
	<span>print name of the actor who has more Oscars from the others  : </span><br>
	<span><?php echo "<b>$name_max</b> has more Oscars from the others with total <b>$max Oscars</b>" ?></span>
	<hr>
	<span>print name of the actor who is the oldest actor or actress who got the Oscar, in what year and for what movie : </span><br>
	<span><?php echo "<b>$name_old</b> was get oscar when he has <b>$old</b> years, at <b>$year_old</b> A.D. with <b>$movie_old</b> movie" ?></span>
	<hr>
	<span>print the name of the actor who got the more than Oscar in row : </span>
	<table>
		<tr>
			<td><b>Artor Name</b></td>
			<td style='text-align:center;'><b>Number of Oscar</b></td>
		</tr>
		<?php foreach($row as $i => $value) { echo $row[$i]; } ?>
	</table>
	<hr>
</body>
</html>