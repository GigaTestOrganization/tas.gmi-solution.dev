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
                <li>Getting Started</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel2">

                <div class="panel-heading panel-heading2">
                	<h4 class="panel-title2 bl blueH4"><b> Getting started</b></h4>
                </div>

                <div class="panel-body2">
                    <div class="list">
                        <div class="sub2 psub2 container-fluid">
                            <h5 class="subtitle-or orangeH5"><b> User Login</b></h5>
                            <p> Your account credential is the same as your ACCDOM username and password.</p>
                            <br/>
                            <?php echo $this->Html->image('help/loginpage.jpg', array('alt' => 'Login Page', 'class' => 'img-responsive')); ?>
                            <br/>
                            <p> The system automatically remembers your login credentials after signing-in, allowing you to stay logged-in even after you close the browser. This will stay true unless you logout on your own.</p>
                            <br/>
                            <h5 class="subtitle-or orangeH5"><b> Navigation Bar</b></h5>
                            <p> This is in the top-most section of the page and it caters different menu for each different tabs. You can access all the important paegs using this navigation bar.</p>
                            <p> It also includes the User information and <em>Logout</em> button under the User menu.</p>
                            <br/>

                            <?php echo $this->Html->image('help/tas-home.jpg', array('alt' => 'Home Page', 'style'=>'margin-left:-30px;', 'class' => 'img-responsive')); ?>

                            <br/>
                            <h5 class="subtitle-or orangeH5"><b> Home Page</b></h5>
                            <p> After a successful login, you will reach the <em>Home</em> page. An overview of <em>On-going Events</em> and <em>Future Events</em> is shown in this page.</p>
                            <p> The On-going Events are events happening in the present week while the Future Events are those happening in the next three weeks. Both tables of show the unique Code, the Name, Start date, End date, and NoP or Number of Person of each event. To view further details on a certain event, click its event name.</p>

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
