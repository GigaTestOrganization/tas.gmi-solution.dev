<?php if(!isset($search)): ?>
<table class="table table-hover table-striped" style="border:none !important;margin-bottom:0px;">
		<thead class="theader-default">
				<tr>
						<td colspan="3"><label style="font-weight:normal !important;"><input type="checkbox" name="isflex" id="isflex" value="1"/> Flex</label><small>&nbsp;&nbsp;|&nbsp;&nbsp;</small><input type="text" name="searchkeyword" id="searchkeyword" style="width:270px;"/></td>
				</tr>
				<tr>
						<th width="25">...</th>
						<th width="180"><span style="color:#30698a;">First Name</span></th>
						<th><span style="color:#30698a;">Last Name</span></th>
				</tr>
		</thead>
    <tbody id="instructorslist">
		    <?php foreach($instructors as $instructor): ?>
		    <tr>
			    	<td width="25"><input type="checkbox" name="<?php echo $instructor['Instructor']['last_name']; ?>" class="individualselect" id="<?php echo $instructor['Instructor']['id'];?>" value="<?php echo $instructor['Instructor']['id'];?>"/></td>
			      <td width="180"><label for="<?php echo $instructor['Instructor']['id'];?>"><?php echo $instructor['Instructor']['first_name']; ?></label></td>
			      <td><label for="<?php echo $instructor['Instructor']['id'];?>"><?php echo $instructor['Instructor']['last_name']; ?></label></td>
		    </tr>
		    <?php endforeach; unset($instructor); ?>
    </tbody>
</table>
<script language="javascript">
	$(function()
	{
			$("#searchkeyword").searchbox({prompt:'search', searcher:function($value, $name){ filter(false); }});
			$(document).on('click', "input#isflex", function(e){ filter(this.checked); });
			var filter = function(boolean)
			{
					$.post('/instructors/select/', {keyword:$("#searchkeyword").searchbox('getValue'),isflex:(boolean?1:0)},function(data){$('tbody#instructorslist').html(data);$('#okbtn').addClass('l-btn-disabled');},'text');
			}

			$(document).on("click", "input[type='checkbox'].individualselect", function(e)
			{
					var table= $(e.target).closest('table'); $('td input:checkbox',table).removeAttr('checked');
					$(this).prop('checked', true);
					if($("input[type='checkbox'].individualselect:checked").length!=0) $('#okbtn').removeClass('l-btn-disabled');
					else $('#okbtn').addClass('l-btn-disabled');
			});
	});
</script>
<?php else: foreach($instructors as $instructor): ?>
	    <tr>
		    	<td width="25"><input type="checkbox" name="<?php echo $instructor['Instructor']['last_name']; ?>" class="individualselect" id="<?php echo $instructor['Instructor']['id'];?>" value="<?php echo $instructor['Instructor']['id'];?>"/></td>
		      <td><label for="<?php echo $instructor['Instructor']['id'];?>"><?php echo $instructor['Instructor']['first_name']; ?></label></td>
		      <td><label for="<?php echo $instructor['Instructor']['id'];?>"><?php echo $instructor['Instructor']['last_name']; ?></label></td>
	    </tr>
<?php endforeach; unset($instructor); endif; ?>
