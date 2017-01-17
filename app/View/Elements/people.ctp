<?php if(!isset($search)): ?>
<div id="selectpeople">
		<table class="table table-hover table-striped" style="border:none !important;margin-bottom:0px;">
				<thead class="theader-default">
						<tr>
					    	<td colspan="4" valign="middle">Find: <input type="text" name="searchkeyword" id="searchkeyword" style="width:200px;"/> <select name="customer_id" id="customer_id" style="width:200px;"><option value="" selected="selected">All Company</option><?php foreach($customers as $customer):?><option value="<?php echo $customer['Customer']['id']; ?>"><?php echo $customer['Customer']['name']; ?></option><?php endforeach; unset($customer); ?></select></td>
				    </tr>
						<tr>
					    	<th valign="top" width="25"><input type="checkbox" id="selectall"/></th>
								<th valign="top" width="120"><span style="color:#30698a;">First Name</span></th>
								<th valign="top" width="120"><span style="color:#30698a;">Last Name</span></th>
								<th valign="top"><span style="color:#30698a;">Company</span></th>
						</tr>
				</thead>
		</table>
		<table class="table table-hover table-striped" style="border:none !important;margin-bottom:0px;margin-top:0px;">
		    <tbody id="peoplelist">
				    <?php foreach($people as $person): ?>
				    <tr>
				    		<td valign="top" width="25"><input type="checkbox" name="<?php echo $person['Person']['last_name']; ?>" class="individualselect" id="<?php echo $person['Person']['id'];?>" value="<?php echo $person['Person']['id'];?>"/></td>
				        <td valign="top" width="120"><label for="<?php echo $person['Person']['id'];?>"><?php echo $person['Person']['first_name']; ?></label></td>
				        <td valign="top" width="120"><label for="<?php echo $person['Person']['id'];?>"><?php echo $person['Person']['last_name']; ?></label></td>
				        <td valign="top"><label for="<?php echo $person['Person']['id'];?>" data-customer_id="<?php echo $person['Customer']['id']; ?>"><?php echo $person['Customer']['name']; ?></label></td>
				    </tr>
				    <?php endforeach; unset($person); ?>
		    </tbody>
		</table>
</div>
<script language="javascript">
	$(function()
	{
			$(document).on("click", "input[type='checkbox']#selectall", function(e)
			{
					$('td input:checkbox',$("#peoplelist")).prop('checked',this.checked);
					toggleOkButton();
			});
			$(document).on("click", "input[type='checkbox'].individualselect", function(e)
			{
					if($("input[type='checkbox'].individualselect").length==$("input[type='checkbox'].individualselect:checked").length)  $("input[type='checkbox']#selectall").prop("checked", "checked");
					else $("input[type='checkbox']#selectall").removeAttr("checked");
					toggleOkButton();
			});
			var toggleOkButton = function()
			{
					if($("input[type='checkbox'].individualselect:checked").length!=0)
					{
						$('#okbtn').removeClass('l-btn-disabled');
					}
					else $('#okbtn').addClass('l-btn-disabled');
			}
	});
</script>
<?php else: foreach($people as $person): ?>
	    <tr>
	    		<td valign="top" width="25"><input type="checkbox" class="individualselect" id="<?php echo $person['Person']['id'];?>" value="<?php echo $person['Person']['id'];?>"/></td>
	        <td valign="top" width="120"><label for="<?php echo $person['Person']['id'];?>"><?php echo $person['Person']['first_name']; ?></label></td>
	        <td valign="top" width="120"><label for="<?php echo $person['Person']['id'];?>"><?php echo $person['Person']['last_name']; ?></label></td>
	        <td valign="top"><label for="<?php echo $person['Person']['id'];?>"><?php echo $person['Customer']['name']; ?></label></td>
	    </tr>
<?php endforeach; unset($person); endif; ?>
