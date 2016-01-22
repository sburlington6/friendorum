<h2>Post a status:</h2>

<form action="<?php echo $filename; ?>" method="post">
	<table>
		<tr>
			<td>Status: <textarea rows="20" cols="50" name="text"><?php echo $text; ?></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" value="Submit" name="statusSubmit"/></td>
		</tr>
	</table>
</form>