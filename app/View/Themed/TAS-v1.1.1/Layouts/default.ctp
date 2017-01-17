<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php echo $this->Html->docType('html5'); ?>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Training Administration System - <?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('font-awesome.min', 'bootstrap', 'tas-default'), 'stylesheet', array('media'=>'all'));
		echo $this->Html->script(array('jquery-1.9.1.min', 'bootstrap', "jquery.nicescroll.min", 'tas-default'));
	?>
</head>
<body>
	<?php if(AuthComponent::user()): ?>
	<?php echo $this->element('menu/top-navigation'); ?>
	<?php echo ($this->params['controller']=='documentations'?$this->element("menu/documentation-side-navbar"):''); ?>
	<?php endif; ?>
	<div class="container">
			<div class="row">
					<div class="col-lg-12">
							<div class="row"><div class="col-lg-12" style="height: 60px;">&nbsp;</div></div>
							<section class="content">
									<?php echo $this->Session->flash(); ?>
									<?php echo $this->fetch('content'); ?>
							</section>
					</div>
			</div>
	</div>
	<footer class="footer">
    	<p class="text-muted text-right">Copyright &copy; 2016 GigaMare Inc.</p>
  </footer>
</body>
</html>
