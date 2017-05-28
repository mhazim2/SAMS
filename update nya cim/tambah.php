<!DOCTYPE html>
<html>
<head>
	<title>Test doang</title>
</head>
<body>
	<h2>Tambah Agenda</h2>

	<p><a href="Home.php">Back</a>

	<form action="inviteteman.php" method="post">
		<table cellpadding="3" cellspacing="0">
			<tr>
				<td>Subject</td>
				<td>:</td>
				<td><input type="text" name="subject" required></td>
			</tr>
			<tr>
				<td>Place</td>
				<td>:</td>
				<td><input type="text" name="place" size="30" required></td>
			</tr>
      <tr>
				<td>Time</time></td>
				<td>:</td>
				<td><input type="time" name="timeagenda" size="30" required></td>
			</tr>
      <tr>
				<td>Date</time></td>
				<td>:</td>
				<td><input type="date" name="dateagenda" size="30" required></td>
			</tr>
      <tr>
				<td>Description</td>
				<td>:</td>
				<td><input type="textfield" name="description" size="255"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td><input type="submit" name="tambah" value="Tambah"></td>
			</tr>
		</table>
	</form>
</body>
</html>
