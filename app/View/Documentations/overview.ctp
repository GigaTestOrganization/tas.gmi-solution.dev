<?php
    echo $this->Html->css(array('documentation'));
    echo $this->fetch("css");
?>
<section class="wrapper">
    <div class="row no-print">
        <div class="col-lg-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li><a href="/documentations/overview"><i class="fa fa-home"></i> Documentation</a></li>
                <li>Overview</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">

            <div id="example" class="panel panel2 panel-default2">
                <div class="panel-heading panel-heading2">
                    <h4 class="panel-title"></h4>
                    <p> The <strong>Training Administration System </strong>, also known as <strong>TAS</strong>, is an online application used to record, monitor, and manage data or create reports of training events.<br/>
                    TAS is a simple and straightforward system that provides you with intuitive user experience. It is packed with specialized features for the exact needs of a training center.</p>
                </div><!-- panel-heading -->

                <div class="panel-body2">
                    <div class="list">
                    	<h5 class="blueH4 subtitle-bl"><b> Key Features</b></h5>
                        <ul>
                            <li> In the Home tab, an overview of the <em>On-going</em> and <em>Future Events</em> is presented.</li>
                            <li> Create Training Event and plan for future training deliveries.</li>
                            <li> In Customers tab, create and manage companies and/or trainees.</li>
                            <li> The Libary tab, manage the courses and lessons.</li>
                            <li> Resources tab is for managing physical resources like intstructors and classrooms.</li>
                            <li> In Reports tab, different data representation and graphical views are available.</li>
                        </ul>
                    	<br/>
                    	<h5 class="blueH4 subtitle-bl"><b> Application</b></h5>
                        <ul>
                            <li><p>  TAS provides a quick and easy to use solutions in monitoring training deliveries. GigaMare Inc. is currently using the following implementations:</p>

                            <ul>
                                <li>  Virtual storage and management of all information involging training deliveries and these are the training schedules and details, customers, libraries, and resources.</li>
                                <li>  Easily create new events, customers, libraries, and resources. </li>
                                <li>  Download needed forms and reports for training events with less hassle.</li>
                                <li>  Charts and statistics for all the on-going and completed training events.</li>
                                <li>  Instructors are able to access the system to update a student/participant’s academic record inside the app.</li>
                                <li>  A system generated history of statistics.</li>
                            </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- panel -->

        </div>
    </div>

</section>
<?php
    echo $this->Html->script(array('jquery.dcjqaccordion.2.7', 'jquery.nicescroll', 'documentation'));
    echo $this->fetch("script");
?>
