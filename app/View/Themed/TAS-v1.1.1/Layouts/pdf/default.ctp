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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Training Administration System <?php echo $title_for_layout; ?></title>
	<?php echo $this->Html->meta('icon'); ?>
    <?php
			if($this->params['controller']!='reports'):
				echo $this->Html->css(array("download"), array('fullBase'=>true));
			else:
				echo $this->Html->css(array("cake.generic"), array('fullBase'=>true));
				echo '<style>	body { background-color: #FFF !important;} </style>';
			endif;
			echo $this->fetch('css');
		?>
</head>
<body>
	<?php echo $this->Session->flash(); ?>
    <?php //echo $plural_form; ?>
    <?php echo $this->fetch('content'); ?>
</body>
</html>
