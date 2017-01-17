<?php
    echo $this->Html->css(array('documentation'));
    echo $this->fetch("css");
?>
<section class="wrapper">
    <div class="row no-print">
        <div class="col-lg-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                <li>Training Events</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel2">
                <div class="panel-heading panel-heading2">
                    <h4 class="panel-title2 bl blueH4"><b>Training Events</b></h4>
                    <p> TAS helps you track and manage training events. In the <em>Training Events</em>, menus and a variety of tools are provided to easily manage event data and create reports you need.</p>
                </div><!-- panel-heading -->
            </div><!-- panel -->
            <div class="panel" id="viewmode">
                <div class="panel-heading panel-heading2">
                    <h4 class="panel-title"><b> View Mode</b></h4>
                    <p>On the Training Events page, you will see he list of events in table form. The display can be toggled based on your preference using the view mode panel.</p>
                </div><!-- panel-heading -->
                <div class="panel-collapse collapse in" id="accordion1_1" aria-expanded="true">
                    <div class="panel-body">
                        <div class="sub2 list">

                            <h5 class="subtitle-or orangeH5"><b>List View</b></h5>
                            <p>The default view mode is the list which shows a summarized information of events: </p>
                            <ul>
                            	<li>Code</li>
                                <li>Name</li>
                                <li>Status</li>
                                <li>Start (date)</li>
                                <li>End (date)</li>
                                <li>NoP (Number of Participants)</li>
                            </ul>
                            <br/>
                            <?php echo $this->Html->image('help/list-view.jpg', array('alt' => 'Training Event List', 'style'=>'margin-left:-30px;', 'class' => 'img-responsive')); ?>
                            <br/>
                            <br/>
                            <p>Each table column are sortable, just click the column's header to sort either ascending or descending. To see the full details of an event, click its name or NoP to view its full detailed page mode. </p>
                            <p>If you are not in the list view mode yet, you can change it by clicking the list view icon in the view mode panel in the top-most section below the navigation bar ( hover in the icon to see its name pop-up ).</p>
                            <?php echo $this->Html->image('help/view-mode.jpg', array('alt' => 'View Mode (List)', 'class' => 'img-responsive')); ?>
                            <br/>

                            <h5 class="subtitle-or orangeH5"><b> Calendar View</b></h5>
                            <p> Click the calendar icon in the View mode panel to access the <em>Calendar View</em>.</p>
                            <?php echo $this->Html->image('help/view-mode2.jpg', array('alt' => 'View Mode (Calendar)', 'class' => 'img-responsive')); ?>
                            <br/>
                           	<p> In this mode, you can view each scheduled training events per month, week, or even per day. You will have a better time perspective for each event. You can hover the training event to see summarized details of it or click it to see its full detailed page.</p>
                            <br/>
                            <?php echo $this->Html->image('help/month-cal.jpg', array('alt' => 'Calendar View', 'style'=>'margin-left:-30px;', 'class' => 'img-responsive')); ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="panel" id="actions">
                <div class="panel-heading panel-heading2">
                    <h4 class="panel-title"><b>Actions</b></h4>
                    <p>On the left side of the View mode panel, you can see the Actions button. Click this button to reveal the Actions Dropmenu. In this menu you can <em>Add New</em> training events and <em>Export Schedule</em>.</p>
                </div><!-- panel-heading -->
                <div class="panel-collapse collapse in" id="accordion1_1" aria-expanded="true">
                    <div class="panel-body">
                        <div class="sub2 list">
                        	<?php echo $this->Html->image('help/actions.jpg', array('alt' => 'Event Actions', 'class' => 'img-responsive')); ?>
                            <br/>
                            <h5 class="subtitle-or orangeH5"><b>Add New</b></h5>
                            <p>You can add new training events by clicking the "Add New" button under the Actions dropdown menu. Go to <a href="#newEvent">New Event</a> for further details.</p>
                            <br/>

                            <h5 class="subtitle-or orangeH5"><b>Export Schedule</b></h5>
                            <p>To create and download reports, click the "Export Schedule" button under the Actions dropdown menu. Go to <a href="#exportSched">Export Training Schedule</a> for further details.</p>

                        </div>
                    </div>
                </div>
            </div>

            <div class="panel" id="newEvent">
                <div class="panel-heading panel-heading2">
                    <h4 class="panel-title"><b>New Event</b></h4>
                    <p>In the <em>New Event</em> page, you can fill up the details needed for the new training event. Make sure to fill up all the required fields in every section and these fields are in color red to make it easier to notice. Upon completing the form, you can click the <em>Submit</em> button below the page or the <em>Cancel</em> button to cancel the event.</p>
                </div><!-- panel-heading -->
                <div class="panel-collapse collapse in" id="accordion1_1" aria-expanded="true">
                    <div class="panel-body">
                        <div class="sub2 list">

                            <h5 class="subtitle-or orangeH5"><b>General Information</b></h5>
                            <p>The first section of New Event page, here you need to fill up the following fields:</p>
                            <ul>
                            	<li>
                                    <h5>SO Number</h5>
                                    <p>
                                        <br/>
                                        <?php echo $this->Html->image('help/so-num.jpg', array('alt' => 'SO Number (required)', 'class' => 'img-responsive')); ?>
                                        <br/>
                                        This is a special assigned numbers for each event. This field is required.
                                    </p>
                                </li>
                                <li>
                                    <h5>Course</h5>
                                    <p>
                                        <br/>
                                        <?php echo $this->Html->image('help/course-event.jpg', array('alt' => 'Course (required)', 'class' => 'img-responsive')); ?>
                                        <br/>
                                        The name of the course you will use for the new training event. A dropdown tree menu will show when you click this field. Click the arrow beside the folder to show or hide its sub-folders or files. Click the file icon or the course name that you want. This field is required.</p>
                                        <br/>
                                         <?php echo $this->Html->image('help/course-event.jpg', array('alt' => 'Course (required)', 'class' => 'img-responsive')); ?>
                                        <p>If the course that you need does not exist in the dropdown tree menu, you can add it by clicking the green cross button beside the field. Go to <a href="#">Courses</a> in the Library help page for further details.</p>
                                </li>
                                <li>
                                    <h5>Date Start/End</h5>
                                    <p>
                                        <br/>
                                        <?php echo $this->Html->image('help/start-end.jpg', array('alt' => 'Date Start & End (required)', 'class' => 'img-responsive')); ?>
                                        <br/>
                                        Enter the start date and end date of the new training event. You can also choose the date in the dropdown calendar that will show if you click the claendar icon inside the fields. This field is required.
                                    </p>
                                </li>
                                <li>
                                    <h5>Status</h5>
                                    <p>
                                        <br/>
                                        <?php echo $this->Html->image('help/status.jpg', array('alt' => 'Status (optional)', 'class' => 'img-responsive')); ?>
                                        <br/>
                                        Select the status of the new training event. This field is optional.
                                    </p>
                                </li>
                            </ul>
                            <br/>
                            <br/>

                            <h5 class="subtitle-or orangeH5"><b>Resources</b></h5>
                            <p> You can the resources need for the new traing event.</p>
                            <ul>
                            	<li>
                                    <h5>Instructors</h5>
                                    <p>
                                        <br/>
                                        <?php echo $this->Html->image('help/instructors-ev.jpg', array('alt' => 'Instructor (optional)', 'class' => 'img-responsive')); ?>
                                        <br/>
                                        This table shows that list of instructors involved in the new training event. You can add an instructors in this list by selecting one in the dropdown field above the table and clicking the "add" button beside it. This field is optional.
                                    </p>
                                    <p>You can choose whose the <em>Lead</em> instructor in the table list or delete anyone of them.</p>
                                </li>
                                <li>
                                    <h5>Classrooms</h5>
                                    <p>
                                        <br/>
                                        <?php echo $this->Html->image('help/class-ev.jpg', array('alt' => 'Classroom (optional)', 'class' => 'img-responsive')); ?>
                                        <br/>
                                        This table shows that list of classrooms to be used for the new training event. You can add a classroom in this list by selecting one in the dropdown field above the table and clicking the "add" button beside it. This field is optional.
                                    </p>
                                    <p>You can also delete any classroom you want in the table list.</p>
                                </li>
                            </ul>
                            <br/>
                            <br/>

                            <h5 class="subtitle-or orangeH5"><b>Course Program</b></h5>
                            <p> This will show the weekly schedule of the new training event in a table format.</p>
                            <br/>
							<?php echo $this->Html->image('help/course-prog.jpg', array('alt' => 'Course Program (optional)', 'class' => 'img-responsive')); ?>
                            <br/>


                        </div>
                    </div>
                </div>
            </div>

            <div class="panel" id="exportSched">
                <div class="panel-heading panel-heading2">
                    <h4 class="panel-title"><b>Export Training Schedule</b></h4>
                    <p>In this page, you can filter and customize the training schedule report you want and export/download it. You just need to choose the date range and all the events within it will be included in the list.</p>
                </div><!-- panel-heading -->
                <div class="panel-collapse collapse in" id="accordion1_1" aria-expanded="true">
                    <div class="panel-body">
                        <div class="sub2 list">
                        	  <br/>
                            <?php echo $this->Html->image('help/exportsched.jpg', array('alt' => 'Export Training Schedule', 'style'=>'margin-left:-30px;', 'class' => 'img-responsive')); ?>
                            <br/>
                            <h5 class="subtitle-or orangeH5"><b>Status</b></h5>
                            <p>Select the Status of the event you wanted to filter.</p>
                            <h5 class="subtitle-or orangeH5"><b>Date Range</b></h5>
                            <p>Choose the Start and End date of thre training event/s.</p>
                            <h5 class="subtitle-or orangeH5"><b>Search</b></h5>
                            <p>Upon entering the filtering details (Status and Date Range), click <em>Search</em> button to show the filtered training events list.</p>
                            <h5 class="subtitle-or orangeH5"><b>Download</b></h5>
                            <p>To download this list, click the Actions dropdown menu and choose <em>Download</em>. Each training event will be automatically download in a singe excel file.</p>
                            <h5 class="subtitle-or orangeH5"><b>List of Events</b></h5>
                            <p>This will redirect you back to the List View mode of all existing training events in the system.</p>
                            <br/>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php
    echo $this->Html->script(array('jquery.dcjqaccordion.2.7', 'jquery.nicescroll', 'documentation'));
    echo $this->fetch("script");
?>
