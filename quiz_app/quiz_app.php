<?php
$server = "localhost";
$user = "root";
$password = "";
$dbname = "quiz_app";

$conn = new mysqli($server, $user, $password, $dbname);
if($conn->connect_error){
	die($conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == 'POST'){
	$title = $_POST["title"];
	$description = $_POST["description"];
	$time = $_POST["time"];
	$price = $_POST["price"];

	$query = $conn->prepare("INSERT INTO quizzes (title, description, time, price) VALUES (?, ?, ? ,?)");
	$query->bind_param("sssi", $title, $description, $time, $price);

	if($query->execute()){
		echo "<p>inserted successfully</p>";
	}
	
	$query->close();
}

// fetch data from database
$sql = "SELECT * FROM quizzes";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"></meta>
<meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
<title>Admin Quiz Page</title>
</head>
<body>
<h2>Admin Page for Quiz</h2>
<form method="POST" action="">
	<label>title : </label><input type="text" name="title"required><br><br>
	<label>description : </label><input type="text" name="description" required><br><br>
	<label>time : </label><input type="text" name="time"><br><br>
	<label>price : </label><input type="text"  name="price"required><br><br>
	<button type="submit" value="submit" name="submit">Add quiz</button>
</form>

<h2>Stored Data</h2>
<table border="1">
    <tr>
	<th>title</th>
	<th>description</th>
	<th>time</th>
	<th>price</th>
    </tr>
    <?php
	 if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo "<tr>
				<td>{$row['title']}</td>
				<td>{$row['description']}</td>
				<td>{$row['time']}</td>
				<td>{$row['price']}</td>
			</tr>";
		}
	 }else{
		echo "<tr><td colspan='3'>no data found</td></tr>";
	 }
    ?>
</table>
</body>
</html>
<?php
$conn->close();
?>