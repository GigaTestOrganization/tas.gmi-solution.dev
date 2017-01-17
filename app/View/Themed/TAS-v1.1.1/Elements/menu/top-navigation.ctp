<?php ?>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
			<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo $this->Html->url('/'); ?>"><b>GMI-TAS</b></a>
			</div>
			<div id="navbar" class="navbar-collapse navbar-inverse collapse">
					<ul class="nav navbar-nav">
							<?php if(in_array(AuthComponent::user('role'), array('admin', 'sales', 'registrar', 'instructor'))): ?>
							<li<?php echo ($this->params['controller']=='pages'?' class="active"':''); ?>><?php echo $this->Html->link('<span class="fa fa-home" aria-hidden="true"></span> Home', '/', array('escape' => false)); ?></li>
							<li<?php echo ($this->params['controller']=='offerings'?' class="active"':''); ?>><?php echo $this->Html->link('<span class="glyphicon glyphicon-education" aria-hidden="true"></span> Training Events', '/offerings', array('escape' => false)); ?></li>
							<li<?php echo ($this->params['controller']=='customers'||$this->params['controller']=='people'?' class="active'.(AuthComponent::user('role')!=='customer'?' dropdown':'').'"':''); ?>>
									<a<?php echo (AuthComponent::user('role')!=='customer'?' href="/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"':' href="/people"'); ?>><span class="fa fa-briefcase" aria-hidden="true"></span> <?php echo (AuthComponent::user('role')!=='customer'?'Customers':'People'); ?> <span class="caret"></span></a>
									<?php if(AuthComponent::user('role')!=='customer'): ?>
									<ul class="dropdown-menu">
											<li<?php echo ($this->params['controller']=='customers'?' class="active"':''); ?>><?php echo $this->Html->link(h('Companies'), array('controller'=>'customers', 'action' => '/'), array('escape' => false)); ?></li>
											<li<?php echo ($this->params['controller']=='people'?' class="active"':''); ?>><?php echo $this->Html->link(h('People'), array('controller'=>'people', 'action' => '/'), array('escape' => false)); ?></li>
									</ul>
									<?php endif; ?>
							</li>
							<li<?php echo ($this->params['controller']=='courses'||$this->params['controller']=='lessons'?' class="active"':''); ?>>
									<?php echo $this->Html->link('<span class="fa fa-book" aria-hidden="true"></span> Library <span class="caret"></span>', '/', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'role'=>'button', 'aria-haspopup'=>true, 'aria-expanded'=>false, 'escape'=>false)); ?>
									<ul class="dropdown-menu">
											<li<?php echo ($this->params['controller']=='courses'?' class="active"':''); ?>><?php echo $this->Html->link(h('Courses'), array('controller'=>'courses', 'action' => '/'), array('escape' => false)); ?></li>
											<li<?php echo ($this->params['controller']=='lessons'?' class="active"':''); ?>><?php echo $this->Html->link(h('Lessons'), array('controller'=>'lessons', 'action' => '/'), array('escape' => false)); ?></li>
									</ul>
							</li>
							<li<?php echo ($this->params['controller']=='instructors'||$this->params['controller']=='classrooms'?' class="active"':''); ?>>
									<?php echo $this->Html->link('<span class="fa fa-puzzle-piece" aria-hidden="true"></span> Resources <span class="caret"></span>', '/', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'role'=>'button', 'aria-haspopup'=>true, 'aria-expanded'=>false, 'escape'=>false)); ?>
									<ul class="dropdown-menu">
											<li<?php echo ($this->params['controller']=='instructors'?' class="active"':''); ?>><?php echo $this->Html->link(h('Instructors'), array('controller'=>'instructors', 'action' => '/'), array('escape' => false)); ?></li>
											<li<?php echo ($this->params['controller']=='classrooms'?' class="active"':''); ?>><?php echo $this->Html->link(h('Classrooms'), array('controller'=>'classrooms', 'action' => '/'), array('escape' => false)); ?></li>
									</ul>
							</li>
							<li<?php echo ($this->params['controller']=='reports'?' class="active"':''); ?>>
									<?php echo $this->Html->link('<span class="fa fa-area-chart" aria-hidden="true"></span> Reports <span class="caret"></span>', '/', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'role'=>'button', 'aria-haspopup'=>true, 'aria-expanded'=>false, 'escape'=>false)); ?>
									<ul class="dropdown-menu">
											<li<?php echo ($this->params['controller']=='reports'&&$this->params['action']=='training_summary'?' class="active"':''); ?>><?php echo $this->Html->link(h('Training Summary'), array('controller'=>'reports', 'action'=>'training_summary'), array('escape'=>false)); ?></li>
											<li<?php echo ($this->params['controller']=='reports'&&$this->params['action']=='course_man_days'?' class="active"':''); ?>><?php echo $this->Html->link(h('Course Man Days'), array('controller'=>'reports', 'action'=>'course_man_days'), array('escape'=>false)); ?></li>
											<li<?php echo ($this->params['controller']=='reports'&&$this->params['action']=='course_summary'?' class="active"':''); ?>><?php echo $this->Html->link(h('Course Summary'), array('controller'=>'reports', 'action'=>'course_summary'), array('escape'=>false)); ?></li>
											<li<?php echo ($this->params['controller']=='reports'&&$this->params['action']=='company_participants'?' class="active"':''); ?>><?php echo $this->Html->link(h('NoP / Company'), array('controller'=>'reports', 'action'=>'company_participants'), array('escape'=>false)); ?></li>
											<li role="separator" class="divider"></li>
											<li<?php echo ($this->params['controller']=='reports'&&$this->params['action']=='statistics_report'&&$this->params['pass'][0]=='participants'?' class="active"':''); ?>><?php echo $this->Html->link(h('Cumulative Participants'), array('controller'=>'reports', 'action'=>'statistics_report', 'participants'), array('escape'=>false)); ?></li>
											<li<?php echo ($this->params['controller']=='reports'&&$this->params['action']=='statistics_report'&&$this->params['pass'][0]=='course_man_days'?' class="active"':''); ?>><?php echo $this->Html->link(h('Cumulative CMD'), array('controller'=>'reports', 'action'=>'statistics_report', 'course_man_days'), array('escape'=>false)); ?></li>
											<li<?php echo ($this->params['controller']=='reports'&&$this->params['action']=='statistics_report'&&$this->params['pass'][0]=='monthly_participants'?' class="active"':''); ?>><?php echo $this->Html->link(h('Monthly Participants'), array('controller'=>'reports', 'action'=>'statistics_report', 'monthly_participants'), array('escape'=>false)); ?></li>
											<li role="separator" class="divider"></li>
											<li<?php echo ($this->params['controller']=='reports'&&$this->params['action']=='training_report'?' class="active"':''); ?>><?php echo $this->Html->link(h('Training Service Report'), array('controller'=>'reports', 'action'=>'training_report'), array('escape'=>false)); ?></li>
									</ul>
							</li>
							<?php
									endif;
									if(isset($current_user) && AuthComponent::user('role')==='admin'):
							?>
							<li><?php echo $this->Html->link('<span class="fa fa-cogs" aria-hidden="true"></span> Administration','', array('escape'=>false)); ?></li>
							<?php endif; ?>
					</ul>

					<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span> <?php echo ucwords($current_user['UserProfile']['first_name'].' '.$current_user['UserProfile']['last_name']);?> <span class="caret"></span></a>
									<ul class="dropdown-menu">
											<li<?php echo ($this->params['controller']=='documentations'?' class="active"':''); ?>><?php echo $this->Html->link(h('Documentation'), array('controller'=>'documentations', 'action'=>'/'), array('escape' => false)); ?></li>
											<li role="separator" class="divider"></li>
											<li><?php echo $this->Html->link(h('Profile & Settings'), array('controller'=>'users', 'action' => 'view', $current_user['id']), array('escape' => false)); ?></li>
											<li><a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'logout'))?>">Logout</a></li>
									</ul>
							 </li>
							 <li><a href="/" class="a-plain-text">logged in as: <?php echo strtolower($current_user['role']); ?></a></li>
					</ul>

			</div>
	</div>
</nav>
