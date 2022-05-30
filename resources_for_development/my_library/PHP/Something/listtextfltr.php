<?php

$fltr = $_GET['fltr1'];

$con = mysqli_connect('localhost','u2739_arabic','Roman_2016','u2739485_arabic');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_set_charset($con, "cp1251");
$sql="SELECT * FROM rdspeed WHERE texts LIKE '%$fltr%'";
$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>ID</th>
<th>Section</th>
<th>text</th>
<th>notes</th>
<th>user</th>
<th>date</th>
<th>trash</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['section'] . "</td>";
    echo "<td>" . $row['texts'] . "</td>";
    echo "<td>" . $row['notes'] . "</td>";
    echo "<td>" . $row['userowner'] . "</td>";
    echo "<td>" . $row['datecreate'] . "</td>";
    echo "<td>" . $row['trash'] . "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<div class=\"notificationSuccess\">
<div>Success</div>";
echo "</div>";
mysqli_close($con);

?>
