
	<form name="updatePostForm" method="post" action="?action=edit&postid=<?php echo $post->id; ?>&ptitle=<?php echo $post->title; ?>">
		<table style="margin-left:auto; margin-right:auto; border: 0;" rules="all">
			<tr>
				<td>
					<div style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
						<textarea style="resize:none; font-size:20px; font-decoration:bold; width:100%;" rows=1 cols=30 maxlength=60 name="newTitle" id="newTitle" placeholder="Title" required><?php echo $post->title;?></textarea>
					</div>
					<div id="blogEditRow" style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
						<textarea name="contentEdit" id="contentEdit"><?php echo $post->content();?></textarea>
					</div>
				<td style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
					<div style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
						<select name="postStatus" id="postStatus">
							<option value=1 <?php if ($post->status) echo "selected"; ?>>Published</option>
							<option value=0 <?php if (!$post->status) echo "selected"; ?>>Unpublished</option>
						</select>
					</div>
					<div style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
						<textarea rows=4 cols=25 name="newDescription" id="newDescription" placeholder="Short description"><?php echo $post->description; ?></textarea>
					</div>
					<div style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
						<textarea rows=2 cols=25 name="newTags" id="newTags" placeholder="Tags (comma seperated)"><?php echo $post->tags; ?></textarea>
					</div>
					<div style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;"><strong>Categories</strong><div style="max-height:200px; width:100%; overflow:auto;">
<?php					$pcats = $post->categories();
						foreach ($categories as $cat) {
							if (in_array($cat->id(), $pcats))
								echo "<input type=\"checkbox\" name=\"postCategories[]\" value=\"".$cat->id()."\" checked>".$cat->name()."</br>";
						}
						foreach ($categories as $cat) {
							if (!in_array($cat->id(), $pcats))
								echo "<input type=\"checkbox\" name=\"postCategories[]\" value=\"".$cat->id()."\">".$cat->name()."</br>";
						}?>
					</div>
						<div style="text-align:right; vertical-align:top; padding: 0px 10px 0px 10px;">
							<input type="submit" name="savePost" id="savePost" value="Save">
						</div>
					</div>
				</td>
			</tr>
		</table>
	<form>
