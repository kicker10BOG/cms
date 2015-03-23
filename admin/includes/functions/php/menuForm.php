
    <script type="text/javascript" src="/admin/<?php echo Configuration::js_function_dir; ?>jquery.tablednd.js"></script>

	<script type="text/javascript">

        $(document).ready(function() {

			$("#menuItemTable").tableDnD({
				onDrop: function(table, row) {
					//console.log("dropped");
					var rows = table.tBodies[0].rows;
					//var debugStr = "Row dropped was "+row.id+". New order: ";
					for (var i=0; i<rows.length; i++) {
						//debugStr += rows[i].id+" ";
						var rowID = "#"+rows[i].id;
						$(rowID).find("span.itemOrder").html(i+1);
						$(rowID).find("input#itemOrder[]").val(i+1);
						//console.log(rows[i]);
					}
					//console.log(debugStr);
				}
			});

			$("a.pubLink").click(function(event){
				event.preventDefault();
				//console.log("test");
				var img = $(this).children().first();
				//console.log(img);
				if (img.attr("title") == "Active") {
					img.attr("src", "/admin/<?php echo Configuration::$tpl->dir(); ?>images/redX.png")
					img.attr("title", "Inactive");
					//console.log($(this));
					var field = $(this).next();
					field.val("0");
					//console.log(field);
					//console.log(field.parent());
				}
				else {
					img.attr("src", "/admin/<?php echo Configuration::$tpl->dir(); ?>images/greenCheck.png")
					img.attr("title", "Active");
					var pattern = /[0-9]+/g;
					//console.log($(this));
					var result = $(this).attr("id").match(pattern);
					//console.log(result);
					var field = $(this).next();
					field.val("1");
					//console.log(field);
					//console.log(field.parent());
				}
			});
			
			$(".menuItemEditDiv").parent().css("max-width", $(".menuItemEditDiv").parent().width());
			$(".menuItemEditDiv").offset({left: -($("#menuItemTable").width()-$(".menuItemEditDiv").parent().width())});
			$(".menuItemEditDiv").width($("#menuItemTable").width());
		
			$(function() {
				$("select.typeEdit").change(function() {
					//console.log($(this));
					var pattern = /[0-9]+\-[0-9]+/g;
					var classes = $(this).attr("class");
					var idOrder = classes.match(pattern)[0];
					//console.log($(this).val());
					if ($(this).val() == "page"){
						//console.log("page");
						$("#"+idOrder+"-typePageEditDiv").show();
						$("#"+idOrder+"-typeExternalEditDiv").hide();
					}
					else if ($(this).val() == "external"){
						//console.log("external");
						$("#"+idOrder+"-typePageEditDiv").hide();
						$("#"+idOrder+"-typeExternalEditDiv").show();
					}
				});
			});

			$(function() {
				$('input[name=menuPType]').change(function(){
					var i = $('input[name=menuPType]:checked').val();
					// page
					if (i == "page") {
						$('#parentPage').slideDown();
					}
					else {
						$('#parentPage').slideUp();
					}
					// none
					if (i != "none") {
						$('#parentMenu').slideDown();
					}
					else {
						$('#parentMenu').slideUp();
					}
				});
			});

			$(function() {
				$("a.editLink").click(function(event){
					//console.log("test editLink");
					event.preventDefault();
					var pattern = /[0-9]+\-[0-9]+/g;
					var idOrder = $(this).attr("id").match(pattern)[0];
					//console.log(idOrder);
					var div = $('.menuItemEditDiv[id=idOrder]');
					//console.log(div);
					//$('[class="menuItemEditDiv"][id='+idOrder+']').slideToggle();
					$(".menuItemEditDiv."+idOrder).slideToggle();

					var img = $(this).children().first();
					if (img.attr("title") == "Edit") {
						img.attr("src", "/admin/<?php echo Configuration::$tpl->dir(); ?>images/arrow_up.png");
						img.attr("title", "Done");
					}
					else {
						img.attr("src", "/admin/<?php echo Configuration::$tpl->dir(); ?>images/arrow_down.png");
						img.attr("title", "Edit");
					}
				});
			});
		
			$(function() {
				$("a#addNewRowLink").click(function(event){
					event.preventDefault();
					var cont = (function() {/*<?php include("defaultItemRow.php"); ?>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
					var randno = Math.floor(Math.random() * 10000) + 10000;
					cont = cont.replace(/0-0/g, randno+"-"+randno);
					$('#menuItemBody').append(cont);
					/*var newRow = $("tr.menuItemRow:last").clone();
					newRow.appendTo('#menuItemBody');
					newRow.find('input#itemOrder[]').val($("tr.menuItemRow").length).next().html($("tr.menuItemRow").length);// set item order
					newRow.find('#itemNew[]').val('true');			// set item new
					newRow.find('#title[]').html("New Item");		// set item title
					newRow.find('#titleEdit[]').html("New Item");	// set item title
					newRow.find('#itemTypeEdit[]').val('page');			// set item type*/
					
					newRow = $("tr.menuItemRow:last");
					console.log(newRow);
					newRow.find(".menuItemEditDiv").parent().css("max-width", $(".menuItemEditDiv").parent().width());
					newRow.find(".menuItemEditDiv").offset({left: -($("#menuItemTable").width()-$(".menuItemEditDiv").parent().width())});
					newRow.find(".menuItemEditDiv").width($("#menuItemTable").width());
					
					newRow.find("a.editLink").click(function(event){
						console.log("test editLink");
						event.preventDefault();
						var pattern = /[0-9]+\-[0-9]+/g;
						var idOrder = $(this).attr("id").match(pattern)[0];
						console.log(idOrder);
						var div = $('.menuItemEditDiv[id=idOrder]');
						//console.log(div);
						//$('[class="menuItemEditDiv"][id='+idOrder+']').slideToggle();
						$(".menuItemEditDiv."+idOrder).slideToggle();

						var img = $(this).children().first();
						if (img.attr("title") == "Edit") {
							img.attr("src", "/admin/<?php echo Configuration::$tpl->dir(); ?>images/arrow_up.png");
							img.attr("title", "Done");
						}
						else {
							img.attr("src", "/admin/<?php echo Configuration::$tpl->dir(); ?>images/arrow_down.png");
							img.attr("title", "Edit");
						}
					});

					$("#menuItemTable").tableDnD({
						onDrop: function(table, row) {
							//console.log("dropped");
							var rows = table.tBodies[0].rows;
							//var debugStr = "Row dropped was "+row.id+". New order: ";
							for (var i=0; i<rows.length; i++) {
								//debugStr += rows[i].id+" ";
								var rowID = "#"+rows[i].id;
								$(rowID).find("span.itemOrder").html(i+1);
								$(rowID).find("input#itemOrder[]").val(i+1);
								//console.log(rows[i]);
							}
							//console.log(debugStr);
						}
					});

					newRow.find("a.pubLink").click(function(event){
						event.preventDefault();
						//console.log("test");
						var img = $(this).children().first();
						//console.log(img);
						if (img.attr("title") == "Active") {
							img.attr("src", "/admin/<?php echo Configuration::$tpl->dir(); ?>images/redX.png")
							img.attr("title", "Inactive");
							//console.log($(this));
							var field = $(this).next();
							field.val("0");
							//console.log(field);
							//console.log(field.parent());
						}
						else {
							img.attr("src", "/admin/<?php echo Configuration::$tpl->dir(); ?>images/greenCheck.png")
							img.attr("title", "Active");
							var pattern = /[0-9]+/g;
							//console.log($(this));
							var result = $(this).attr("id").match(pattern);
							//console.log(result);
							var field = $(this).next();
							field.val("1");
							//console.log(field);
							//console.log(field.parent());
						}
					});
					
					$(function() {
						newRow.find("select.typeEdit").change(function() {
							//console.log($(this));
							var pattern = /[0-9]+\-[0-9]+/g;
							var classes = $(this).attr("class");
							var idOrder = classes.match(pattern)[0];
							console.log(idOrder);
							//console.log($(this).val());
							if ($(this).val() == "page"){
								//console.log("page");
								$("#"+idOrder+"-typePageEditDiv").show();
								$("#"+idOrder+"-typeExternalEditDiv").hide();
							}
							else if ($(this).val() == "external"){
								//console.log("external");
								$("#"+idOrder+"-typePageEditDiv").hide();
								$("#"+idOrder+"-typeExternalEditDiv").show();
							}
						});
					});
					
					$(function() {
						newRow.find('input[name=menuPType]').change(function(){
							var i = $('input[name=menuPType]:checked').val();
							// page
							if (i == "page") {
								$('#parentPage').slideDown();
							}
							else {
								$('#parentPage').slideUp();
							}
							// none
							if (i != "none") {
								$('#parentMenu').slideDown();
							}
							else {
								$('#parentMenu').slideUp();
							}
						});
					});

					$(function() {
						newRow.find('.titleEdit').keyup(function(){
							//console.log('testTitleEdit');
							//console.log(classes);
							//console.log(idOrder);
							$(this).closest('tr.menuItemRow').find('#title[]').html($(this).val());
						});
					});

					$(function() {
						newRow.find(".disableEnter").keydown(function(e) {
							if (e.keyCode == 13) {
								return false;
							}
						});
					});
				});
			});

			$(function() {
				$('.titleEdit').keyup(function(){
					//console.log('testTitleEdit');
					//console.log(classes);
					//console.log(idOrder);
					$(this).closest('tr.menuItemRow').find('#title[]').html($(this).val());
				});
			});

			$(function() {
				$(".disableEnter").keydown(function(e) {
					if (e.keyCode == 13) {
						return false;
					}
				});
			});
			
		});

	</script>

	<form id="updateMenuForm" name="updateMenuForm" method="post" action="?action=edit&menuid=<?php echo $menu->id();?>&ptitle=<?php echo $menu->title(); ?>">
		<table style="margin-left:auto; margin-right:auto; border: 0;" rules="all">
			<tr>
				<td style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
					<div>
						<textarea style="resize:none; font-size:20px; font-decoration:bold; width:100%;" rows=1 cols=30 maxlength=60 name="newTitle" id="newTitle" placeholder="Title" required><?php echo $menu->title(); ?></textarea>
					</div>
					<div id="menuItemDiv">
						<table id="menuItemTable" rules="rows">
							<thead>
								<tr class="nodrag nodrop">
									<th style="padding-left:10px; padding-right:10px;">Title</th>
									<th style="padding-left:10px; padding-right:10px;">Type</th>
									<th style="padding-left:10px; padding-right:10px;">Active</th>
									<th style="padding-left:10px; padding-right:10px;">Order</th>
                                    <th style="padding-left:10px; padding-right:10px;">Linked to:</th>
                                    <th style="padding-left:10px; padding-right:10px;">&nbsp;</th>
								</tr>
							</thead>
							<tbody id="menuItemBody">
<?php                           $i = 1; // order counter
								// Put menu items in the table
								foreach ($menu->menuItems() as $item) {
									$idOrder = $item->id()."-$i"; ?>
									<tr class="menuItemRow" id="<?php echo $idOrder;?>-row" style="cursor:move">
                                        <input class="<?php echo $idOrder;?>" id="itemID[]" name="itemID[]" type="hidden" value=<?php echo $item->id();?>>
										<td class="<?php echo $idOrder;?>" style="vertical-align:top;" id="title[]" name="title[]"><?php echo $item->title();?></td>
                                        <td class="<?php echo $idOrder;?>" style="vertical-align:top; padding-left:10px; padding-right:10px;" id="type[]"><?php echo $item->type();?></td>
                                        <td class="<?php echo $idOrder;?>" id="<?php echo $idOrder;?>-active" style="vertical-align:top; text-align:center;"><?php
											if ($item->status())
												echo "<a class=\"pubLink\" id=\"$idOrder-pubLink\" href=\"#\"><img title=\"Active\" src=\"/admin/".Configuration::$tpl->dir()."images/greenCheck.png\"></a><input type=\"hidden\" id=\"itemPub[]\" name=\"itemPub[]\" value=1>";
											else
												echo "<a class=\"pubLink\" id=\"$idOrder-pubLink\" href=\"#\"><img title=\"Inactive\" src=\"/admin/".Configuration::$tpl->dir()."images/redX.png\"></a><input type=\"hidden\" id=\"itemPub[]\" name=\"itemPub[]\" value=0>";
										?>
										</td>
										<td style="vertical-align:top; text-align:center;">
											<input class="<?php echo $idOrder;?> itemOrder" id="itemOrder[]" name="itemOrder[]" type="hidden" value=<?php echo $i;?>>
											<span class="<?php echo $idOrder;?> itemOrder"><?php echo $i;?></span>
											<input class="<?php echo $idOrder;?> itemNew" id="itemNew[]" name="itemNew[]" type="hidden" value="false">
										</td>
										<td style="vertical-align:top; text-align:center; padding-left:10px; padding-right:10px;">
											<a class="<?php echo $idOrder;?>" id="<?php echo $idOrder; ?>-linkedTo" name="<?php echo $idOrder; ?>-linkedTo" href="<?php echo $item->url(); ?>" target="_blank"><?php
												if ($item->type() == "page") {
													$page = new Page(intval($item->pid()));
													echo $page->title();
												}
												elseif ($item->type() == "external") {
													echo $item->url();
												}
											?></a>
										</td>
                                        <td style="vertical-align:top; text-align:center;">
											<a class="<?php echo $idOrder;?> editLink" id="<?php echo $idOrder;?>-editLink" href="#" style="text-decoration:none; width:16px;">
												<img class="<?php echo $idOrder;?>" title="Edit" src="/admin/<?php echo Configuration::$tpl->dir(); ?>images/arrow_down.png">
											</a><br>
											<div class="<?php echo $idOrder;?> menuItemEditDiv" id="<?php echo $idOrder;?>" style="display:none; cursor:default;">
												<table>
													<tr>
														<td style="vertical-align:bottom;">
															New Title:<input class="<?php echo $idOrder;?> disableEnter titleEdit" id="titleEdit[]" name="titleEdit[]" type="text" value="<?php echo $item->title();?>">
														</td>
														<td style="vertical-align:bottom;">
															<select class="<?php echo $idOrder;?> typeEdit" id="typeEdit[]" name="typeEdit[]">
																<option value="page" <?php if ($item->type() == "page") echo "selected"; ?>>page</option>
																<option value="external" <?php if ($item->type() == "external") echo "selected"; ?>>external</option>
															</select>
														</td>
														<td style="vertical-align:bottom;">
															<div id="<?php echo $idOrder;?>-typePageEditDiv" name="<?php echo $idOrder;?>-typePageEditDiv" <?php if ($item->type() != "page") echo "style=\"display:none;\"";?>>
																<select class="<?php echo $idOrder;?> disableEnter"  id="pageSelect[]" name="pageSelect[]" >
<?php																	$pages = Page::GetAll();
																	foreach($pages as $page) {
																		for($n=0; $n<18;$n++)
																			echo "\t";
																		echo "<option value=\"".$page->id()."\"";
																		if ($item->pid() == $page->id())
																			echo " selected";
																		echo ">".$page->title()."</option>\n";
																	}
?>
																</select>
															</div>
															<div id="<?php echo $idOrder;?>-typeExternalEditDiv" name="<?php echo $idOrder;?>-typeExternalEditDiv" <?php if ($item->type() != "external") echo "style=\"display:none;\"";?>>
																<input class="<?php echo $idOrder;?> disableEnter" type="text" id="typeExternalEdit" name="typeExternalEdit[]" value="<?php echo $item->url();?>">
															</div>
														</td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
<?php								$i++;
									//break;
								}
?>
							</tbody>
						</table>
					</div>
				</td>
				<td style="text-align:right; vertical-align:top; padding: 0px 10px 0px 10px;">
					<div>
						<select name="menuStatus" id="menuStatus">"
							<option value=1 <?php if ($menu->status()) echo "selected"; ?>>Published</option>
							<option value=0 <?php if (!$menu->status()) echo "selected"; ?>>Unpublished</option>
						</select>
						<br>
						<a id="addNewRowLink" href="#">Add New Item</a>
					</div>
					<div style="text-align:left; vertical-align:top; padding: 0px 10px 0px 10px;">
					    <strong>Parent</strong>
						<br><input type="radio" name="menuPType" id="menuPType" value="none" <?php if($menu->parentType() == "none" || !$menu->parentType() || $menu->parentID() == 0) echo "checked"; ?>>None
						<br><input type="radio" name="menuPType" id="menuPType" value="page" <?php if($menu->parentType() == "page" && $menu->parentID() != 0) echo "checked"; ?>>Page
						<div id="parentPage" name="parentPage" style="max-height:120px; overflow:auto; padding-left:20px; <?php if($menu->parentType() != "page" || $menu->parentID() == 0) echo "display:none;"; ?>">
<?php					$pages = Page::GetAll();
						foreach($pages as $page) {
							for($n=0; $n<7;$n++)
								echo "\t";
							echo "<input type=\"radio\" name=\"parentPageID\" id=\"parentPageID\" value=\"".$page->id()."\" form=\"updateMenuForm\"";
							if ($menu->parentID() == $page->id())
								echo " checked";
							echo ">".$page->title()."<br>\n";
						}
?>
						</div>
						<div id="parentMenu" name="parentMenu" <?php if($menu->parentType() == "none" || $menu->parentMenu() == 0) echo "style=\"display:none;\""; ?>>
							<strong>Parent Menu</strong>
							<div style="max-height:120px; overflow:auto; padding-left:20px;">
<?php						$query = "SELECT title, id FROM ".Configuration::sitePrefix."menus WHERE id != ".$menu->id()." AND parentMenu = 0";
							$result = Configuration::Query($query);
							if ($result) {
								while ($row = $result->fetch_array(MYSQLI_ASSOC)){
									echo "<input type=\"radio\" name=\"parentMenuID\" id=\"parentMenuID\" value=\"".$row['id']."\" form=\"updateMenuForm\"";
									if ($menu->parentMenu() == $row['id'])
										echo " checked";
									echo ">".$row['title']."<br>\n";
								}
							}
							else
								echo Configuration::GetLink()->error."<br>".$query;
?>
							</div>
						</div>
					</div>
					<div>
						<input type="submit" name="saveMenu" id="saveMenu" value="Save">
					</div>
				</td>
			</tr>
		</table>
	</form>