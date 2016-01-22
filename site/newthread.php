<h1>New Thread</h1>

<form action="<?php echo $filename; ?>" method="post">
	<table>
		<tr>
			<td>Name:<input type="text" name="name" value="<?php echo $name; ?>"/></td>
		</tr>
		<tr>
			<td>Topic:<input type="text" name="topic" value="<?php echo $topic; ?>"/></td>
		</tr>
		<tr>
			<td>Description: <textarea rows="4" cols="50" name="desc"><?php echo $desc; ?></textarea></td>
		</tr>
		<tr>
			<td>Text: <textarea rows="20" cols="50" name="text"><?php echo $text; ?></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" value="Submit" name="submit"/></td>
		</tr>
	</table>
</form>