
	<script type="text/javascript">
		$.fn.typeChanged = function() {
				var i = $(this).val();
				if (i == "page") {
					$('#blogEditRowB').hide();
					$('#blogEditRow').show();
				}
				else {
					$('#blogEditRow').hide();
					$('#blogEditRowB').show();
				}
		}
		
		$(document).ready(function(){
			$('#pageType').typeChanged();
		});
		
		$(function() {
			$('#pageType').change(function(){
				$(this).typeChanged();
			});
		});
		
		$.fn.ToggleAll = function(){
		    var that = $(this);
			$('input[name="pageCategories[]"]').each(function() {
				this.checked = that.prop('checked');
			});
		}
		
		function ToggleAllCats() {
			$("#all").ToggleAll();
		}
		
		function ToggleOneOrAll($this) {
			$this = $('input[name="pageCategories[]"]').filter('#'+$this.id);
			if ($this.prop('checked')) {
				$cats = $('input[name="pageCategories[]"]');
				console.log($cats);
				$checked = true;
				$i = 0;
				while($cats[$i] && $checked){
					$cat = $('input[name="pageCategories[]"]').filter('#'+$cats[$i].id)
					if ($cat.prop('id') != 'all' && !$cat.prop('checked'))
					    $checked = false;
					$i++;
				}
				if ($checked)
				    $('#all').prop('checked', true);
			}
			else 
			    $('#all').prop('checked', false);
		}
	</script>

	<form name="updatePageForm" method="post" action="?action=edit&pageid=<?php echo $page->id;?>&ptitle=<?php echo $page->title; ?>">
		<table style="margin-left:auto; margin-right:auto; border: 0;" rules="all">
			<tr>
				<td style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
					<div>
						<textarea style="resize:none; font-size:20px; font-decoration:bold; width:100%;" rows=1 cols=30 maxlength=60 name="newTitle" id="newTitle" placeholder="Title" required><?php echo $page->title; ?></textarea>
					</div>
					<div id="blogEditRow" style="float:left; clear:left;">
						<textarea name="contentEdit" id="contentEdit" ><?php echo $page->content; ?></textarea>
					</div>
					<div id="blogEditRowB"; style="float:left; clear:left; text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
<?php 					$cats = Category::GetAll();?>
						<strong>Select categories to display:</strong><br>
						<input type="checkbox" name="pageCategories[]" id="all" value="all" <?php if ($page->categories == "all") echo "checked "; ?> onClick="ToggleAllCats()">All<br>
<?php				foreach ($cats as $cat) {?>
						<input type="checkbox" name="pageCategories[]" value=<?php echo $cat->id()." id=".$cat->id()." "; if ($page->categories() == "all" || (is_array($page->categories)&& in_array($cat->id(), $page->categories()))) echo "checked "; ?> onClick="ToggleOneOrAll(this)"><?php echo $cat->name(); ?><br>
<?php				}?>
					<strong>Number of Posts to show: </strong><input name="numPosts" id="numPosts" type="number" value=<?php echo $page->numPosts; ?> maxlength=2 size=2><br>
					</div>
				</td>
				<td style="text-align:right; vertical-align:top; padding: 0px 10px 0px 10px;">
					<div>
						<select name="pageStatus" id="pageStatus">"
							<option value=1 <?php if ($page->status) echo "selected"; ?>>Published</option>
							<option value=0 <?php if (!$page->status) echo "selected"; ?>>Unpublished</option>
						</select>
					</div>
					<div>
						<select name="pageType" id="pageType">
							<option value="page" <?php if ($page->type == "page") echo "selected";?>>Page</option>
							<option value="blog" <?php if ($page->type == "blog") echo "selected";?>>Blog</option>
						</select>
					</div>
					<div>
					    This is Home Page<input type="checkbox" name="makeHome" id="makeHome" value=1 <?php if ($page->isHome == 1) echo "checked "; ?>><br>
					</div>
					<div>
						<textarea rows=4 cols=25 name="newDescription" id="newDescription" placeholder="Short description"><?php echo $page->description; ?></textarea>
					</div>
					<div>
						<textarea rows=2 cols=25 name="newTags" id="newTags" placeholder="Tags (comma seperated)"><?php echo $page->tags; ?></textarea>
					</div>
					<div>
						<input type="submit" name="savePage" id="savePage" value="Save">
					</div>
				</td>
			</tr>
		</table>
	</form>