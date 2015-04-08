<?php
include ('../../../config/config.php');
$c = 0;
$c = $_POST['color_id'];

$sqlclr = mysqli_query($con,"SELECT * FROM colors WHERE color_id='$c'");
$rowclr = mysqli_fetch_assoc($sqlclr);

if($c == 0)
{
	echo "No Color selected.";
}
else
{
	if(/*$rowclr['color_code'] == "" && */$rowclr['color_image_name'] != "")
	{
		echo '<img src="../'.$rowclr['color_image_name'].'" style="height:15px; width:15px; float:left; position:relative; left:30px;" />';
	}
	elseif(/*$rowclr['color_code'] != "" && */$rowclr['color_image_name'] == "")
	{
		echo '<span style="background-color:#'.$rowclr['color_code'].'; height:15px; width:15px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
	}
	else
	{
		echo '<div style="background-color:#'.$rowclr['color_code'].'; height:15px; width:15px"></div>&nbsp;&nbsp;&nbsp;<img src="../'.$rowclr['color_image_name'].'" style="height:15px; width:15px; float:left; position:relative; left:30px; bottom:15px;" />';
	}
}
?>