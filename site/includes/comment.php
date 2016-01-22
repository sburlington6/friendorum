<h3>Comment</h3>
		
		<form action="thread.php" method="post">
			<input type="hidden" name="threadId" value="<?php echo $threadId;?>"/>
			<table>
				<tr>
					<td>Subject:<input type="text" name="subject" value="<?php echo $subject; ?>"/></td>
				</tr>
				<tr>
					<td>Comment: <textarea rows="4" cols="50" name="comment"><?php echo $comment; ?></textarea></td>
				</tr>
				<tr>
					<td><input type="submit" value="Submit" name="submit"/></td>
				</tr>
			</table>
		</form>	