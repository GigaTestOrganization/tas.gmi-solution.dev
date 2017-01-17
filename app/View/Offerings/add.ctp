<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default">New Event</h3>
</div>
<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-2 col-lg-8">
						<?php echo $this->Form->create('Offering', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'CreateNewOfferForm', 'class'=>'form-horizontal', 'role' => 'form', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>General Information</b></h4>
						</div>
							<?php if(AuthComponent::user('role')!=='customer'): ?>
								<div class="form-group form-group-sm">
										<label class="control-label col-sm-2">SO Number:</label>
										<div class="col-sm-10">
												<input name="data[Offering][sales_order_no]" maxlength="60" style="width: 500px;" type="text" value="" id="OfferingSONum" class="form-control easyui-textbox" data-options="required:true"/>
										</div>
								</div>
							<?php endif; ?>
			          <div class="form-group form-group-sm">
										<label class="control-label col-sm-2">Course:</label>
										<div class="col-sm-10">
					              <input type="hidden" name="data[Offering][user_id]" id="activeuserid" value="<?php echo $this->Session->read('Auth.User.id'); ?>"/>
												<input type="text" name="data[Offering][course_id]" value="" id="OfferingCourseID" style="width:500px;" class="form-control"/>
					              <?php echo $this->Html->link('', array('controller'=>'courses','action'=>'add', 'custom'), array("class"=>"easyui-linkbutton tool_tips",  "data-options"=>"iconCls:'icon-add'", "style"=>"padding: 0px 0px 0px 0px;", "title"=>"Course does not exist? Create it in the Library first<br/>then come back here and check under the category<br/>you place it.<br/><br/>Click this button to proceed."));?>
										</div>
			          </div>
			          <div class="form-group form-group-sm">
										<label class="control-label col-sm-2">Date Start/End:</label>
										<div class="col-sm-10">
				            		<input name="data[Offering][date_start]" style="width: 130px;" type="text" value="" id="OfferingDateStart" class="form-control"/> - <input name="data[Offering][date_end]" style="width: 130px;" type="text" value="" id="OfferingDateEnd" class="form-control"/>
										</div>
				        </div>
							<?php if(AuthComponent::user('role')!=='customer'): ?>
			          <div class="form-group form-group-sm">
										<label class="control-label col-sm-2">Status:</label>
										<div class="col-sm-10">
			                  <select name="data[Offering][status]" class="form-control easyui-combobox" id="OfferingStatus" data-options="{onLoadSuccess:function(){$(this).combobox('setValue','');},panelHeight:'auto',prompt:'--- please select status ---'}" style="width:170px;">
			                     <option value="0">For Confirmation</option>
			                     <option value="1">Confirmed</option>
			                     <option value="2">Delivered</option>
			                     <option value="3">Invoiced</option>
			                     <option value="4">Cancelled</option>
			                  </select>
										</div>
			          </div>
								<div class="page-header">
		                <h4 class="text-default"><b>Resources</b></h4>
		            </div>
			          <div class="form-group form-group-sm">
										<div class="col-sm-12" style="margin-bottom:5px;">
												<select name="InstructorsList" class="easyui-combobox" id="InstructorsList" style="width:250px;" data-options="{onLoadSuccess:function(){$(this).combobox('setValue','');},panelHeight:'150px',prompt:'--- please select instructor ---'}">
														<?php foreach($instructors as $instructor):?>
														<option value="<?php echo $instructor['Instructor']['id']; ?>"><?php echo $instructor['Instructor']['fullname']; ?></option>
														<?php endforeach; unset($instructor); ?>
												</select>
												<a href="#" class="easyui-linkbutton tool_tips" title="Add Instructors" id="addofferinstructor" data-options="iconCls:'icon-add'">add</a>
										</div>
										<div class="col-sm-12">
					              <table class="table table-bordered table-hover table-striped">
														<thead class="thead-default">
					                      <th>Instructor(s)</th>
					                      <th width="50" style="text-align:center;">Lead</th>
					                      <th width="30">&nbsp;</th>
					                  </thead>
					                  <tbody id="AddedOfferInstructors"></tbody>
					              </table>
										</div>
			          </div>
			          <br/>
			          <div class="form-group form-group-sm">
										<div class="col-sm-12" style="margin-bottom:5px;">
												<select name="ClassroomsList" class="easyui-combobox" id="ClassroomsList" style="width:250px;" data-options="{onLoadSuccess:function(){$(this).combobox('setValue','');},panelHeight:'150px',prompt:'--- please select classroom ---'}">
														<?php foreach($classrooms as $classroom):?>
														<option value="<?php echo $classroom['Classroom']['id']; ?>"><?php echo $classroom['Classroom']['name']; ?></option>
														<?php endforeach; unset($classroom); ?>
												</select>
												<a href="#" class="easyui-linkbutton tool_tips" title="Add Room" id="addofferclassroom" data-options="iconCls:'icon-add'">add</a>
										</div>
										<div class="col-sm-12">
					              <table class="table table-bordered table-hover table-striped">
														<thead class="thead-default">
					                      <th>Classroom(s)</th>
					                      <th width="30">&nbsp;</th>
					                  </thead>
			                  		<tbody id="AddedOfferClassrooms"></tbody>
			              		</table>
										 </div>
			          </div>
							<?php endif; ?>
								<div class="page-header">
		                <h4 class="text-default"><b>Course Program</b> | <a href="#" class="easyui-linkbutton tool_tips" title="Reset the course program to default." id="usedefault" data-options="iconCls:'icon-reload'">Default</a></h4>
		            </div>
								<div class="form-group form-group-sm">
		                <div class="col-sm-12" id="course_program">
		                     <p data-week="1">
													  <table id="timetable" class="table table-bordered table-hover table-striped">
																<thead class="thead-default">
		                                <th width="115">Days</th>
		                                <th valign="bottom">Lessons</th>
		                                <th width="165">Instructor</th>
		                                <th width="135" align="center">Duration</th>
		                                <th width="145" align="center">Time Slot</th>
		                            </thead>
		                            <tbody>
		                                <tr height="50">
		                                    <td class="time">Monday</td>
		                                    <td colspan="4" class="schedules" data-week="1" data-day="1">&nbsp;</td>
		                                </tr>
		                                <tr height="50">
		                                    <td class="time">Tuesday</td>
		                                    <td colspan="4" class="schedules" data-week="1" data-day="2">&nbsp;</td>
		                                </tr>
		                                <tr height="50">
		                                    <td class="time">Wednesday</td>
		                                    <td colspan="4" class="schedules" data-week="1" data-day="3">&nbsp;</td>
		                                </tr>
		                                <tr height="50">
		                                    <td class="time">Thursday</td>
		                                    <td colspan="4" class="schedules" data-week="1" data-day="4">&nbsp;</td>
		                                </tr>
		                                <tr height="50">
		                                    <td class="time">Friday</td>
		                                    <td colspan="4" class="schedules" data-week="1" data-day="5">&nbsp;</td>
		                                </tr>
		                                <tr height="50">
		                                    <td class="time">Saturday</td>
		                                    <td colspan="4" class="schedules" data-week="1" data-day="6">&nbsp;</td>
		                                </tr>
		                                <tr height="50">
		                                    <td class="time">Sunday</td>
		                                    <td colspan="4" class="schedules" data-week="1" data-day="7">&nbsp;</td>
		                                </tr>
		                          </tbody>
		                       </table>
		                    </p>
		                </div>
								</div>
								<hr/>
								<div class="form-group form-group-sm">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <span class="pull-right">
                            <input type="submit" value="Submit" class="btn btn-sm btn-primary" id="SubmitCreateNewOfferForm"/>
                            <a class="btn btn-sm btn-default" id="cancelOfferForm" href="<?php echo $this->Html->url(array('controller'=>'offerings', 'action'=>'/')); ?>">Cancel</a>
                        </span>
                    </div>
                </div>
						<?php echo $this->Form->end(); ?>
				</div>
		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("offerings/offering.add"));
		echo $this->fetch("script");
?>
