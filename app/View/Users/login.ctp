<?php echo $this->Html->docType('html5'); ?>
<html>
	<head>
			<?php echo $this->Html->charset(); ?>
			<title>Training Administration System - <?php echo $title_for_layout; ?></title>
			<?php
					echo $this->Html->meta('icon');
					echo $this->Html->meta(array('name'=>'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'));
					echo $this->fetch('meta');

					echo $this->Html->css(array('bootstrap', 'font-awesome.min', 'app.login'), 'stylesheet', array('media'=>'all'));
					echo $this->fetch('css');

					echo $this->Html->script(array('jquery-1.9.1.min', 'bootstrap'));
					echo $this->fetch('script');
			?>
	</head>

	<body>
	    <div class="container">
					<div class="absolute-center is-responsive">
						<?php echo $this->Session->flash(); ?>
			        <div class="card card-container">
			            <img id="profile-img" class="profile-img-card" src="/img/administration.jpg" />
			            <p id="profile-name" class="profile-name-card">Training Administration System</p>
									<?php echo $this->Form->create('User', array('url'=>array('controller'=>'users', 'action'=>'login'), 'class'=>'form-signin','role' => 'form')); ?>
			                <span id="reauth-email" class="reauth-email"></span>
			                <input type="text" name="data[User][username]" id="inputUsername" class="form-control" placeholder="Domain Username" required autofocus>
			                <input type="password" name="data[User][password]" id="inputPassword" class="form-control" placeholder="Password" required>
			                <div id="remember" class="checkbox"><label><input type="checkbox" name="data[User][remember_me]" value="1"/> Remember me</label></div>
			                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
			            <?php echo $this->Form->end(); ?>
			            <a href="/users/register" class="forgot-password">Don't have access?</a>
			        </div>
							<center><h4><small>GigaMare Inc. - TAS &copy; 2016</small></h4></center>
					</div>
	    </div>
	</body>
</html>
