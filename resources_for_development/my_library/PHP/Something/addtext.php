<?php
header("Content-Type: application/json; charset=UTF-8");
$newTextJSON = json_decode($_POST["newTextJSONphp"], false);

$con = mysqli_connect('localhost','u2739_arabic','Roman_2016','u2739485_arabic');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_set_charset($con, "cp1251");
$sql="INSERT INTO rdspeed (section, texts, notes) VALUES ('$newTextJSON->categoryA', '$newTextJSON->textaddA', '$newTextJSON->otherA')";
$result = mysqli_query($con,$sql);
echo "<div class=\"notificationSuccess\">
<div>Success</div>";
echo "</div>";
mysqli_close($con);

?>
