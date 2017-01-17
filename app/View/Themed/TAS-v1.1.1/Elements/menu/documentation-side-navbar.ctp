<?php ?>
<aside>
    <div id="sidebar"  class="nav-collapse">
        <ul class="sidebar-menu" id="nav-accordion">
            <li class="<?php echo ($this->params['controller']=='documentations' && $this->params['action']=='overview' ?'active':''); ?>">
                <a href="<?php echo $this->Html->url(array("controller" => "documentations","action" => "overview"));?>" class="<?php echo ($this->params['controller']=='documentations' && $this->params['action']=='overview' ?'active':''); ?>">
                	<?php echo ($this->params['controller']=='documentations' && $this->params['action']=='overview' ?'<div class="arrow-left hidden-xs"></div>':''); ?>
                	<span>Overview</span>
            	</a>
            </li>
            <li class="<?php echo ($this->params['controller']=='documentations' && $this->params['action']=='getting_started' ?'active':''); ?>">
                <a href="<?php echo $this->Html->url(array("controller" => "documentations","action" => "getting_started"));?>" class="<?php echo ($this->params['controller']=='documentations' && $this->params['action']=='getting_started' ?'active':''); ?>">
                	<?php echo ($this->params['controller']=='documentations' && $this->params['action']=='getting_started' ?'<div class="arrow-left hidden-xs"></div>':''); ?>
                	<span>Getting Started</span>
            	</a>
            </li>
            <li class="sub-menu <?php echo ($this->params['controller']=='documentations' && $this->params['action']=='training_events' ?'active':''); ?>">
                <a href="<?php echo $this->Html->url(array("controller" => "documentations","action" => "training_events"));?>" class="<?php echo ($this->params['controller']=='documentations' && $this->params['action']=='training_events' ?'active':''); ?>">
                	<?php echo ($this->params['controller']=='documentations' && $this->params['action']=='training_events' ?'<div class="arrow-left hidden-xs"></div>':''); ?>
                	<span>Training Events</span>
                </a>
                <ul class="sub">
                    <li><a href="#viewmode" >View Mode</a></li>
                    <li><a href="#actions">Actions</a></li>
                    <li><a href="#newEvent">New Event</a></li>
                    <li><a href="#exportSched">Export Training Schedule</a></li>
                </ul>
            </li>
            <li class="sub-menu ">
                <a href="javascrit:;" class="">

                	<span>Customers</span>
                </a>
                <ul class="sub">
                    <li><a href="#companies" >Companies</a></li>
                    <li><a href="#people">People</a></li>
                </ul>
            </li>
            <li class="sub-menu ">
                <a href="javascrit:;" class="">

                	<span>Library</span>
                </a>
                <ul class="sub">
                    <li><a href="#courses" >Courses</a></li>
                    <li><a href="#lessons">Lessons</a></li>
                </ul>
            </li>
            <li class="sub-menu ">
                <a href="javascrit:;" class="">

                	<span>Resources</span>
                </a>
                <ul class="sub">
                    <li><a href="#intructors" >Instructors</a></li>
                    <li><a href="#classrooms">Classrooms</a></li>
                </ul>
            </li>
            <li class="sub-menu ">
                <a href="javascrit:;" class="">

                	<span>Reports</span>
                </a>
                <ul class="sub">
                    <li><a href="#intructors" >Training Summary</a></li>
                    <li><a href="#classrooms">Course Man Days</a></li>
                    <li><a href="#intructors" >Course Summary</a></li>
                    <li><a href="#classrooms">NoP/Company</a></li>
                    <li><a href="#intructors" >Cumulative Participants</a></li>
                    <li><a href="#classrooms">Cumulative CMD</a></li>
                    <li><a href="#intructors" >Monthly Participants</a></li>
                    <li><a href="#classrooms">Training Report</a></li>
                </ul>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
