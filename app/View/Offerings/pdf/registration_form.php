<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GigaMare Inc. - Learning Management System</title>
<style type="text/css">
	body{margin:0px;padding:0px;font-size:1.1em;font-family:Arial;}
</style>
</head>
<body>
	<div style="width: 1024px; margin: auto;">
   	  <div style="height: 154px; background: transparent url(<?php echo $this->Html->url('/img/gmi/gigamare_medium.jpg', true); ?>) top left no-repeat; padding-top: 25px;">
        	<h1 style="font-size: 2em; color: #0CF; float: right; padding:0px; margin:0px;">Registration Form</h1>
            <div style="clear:both;"></div>
        </div>
        <div style="width: 100%;">
       	  <div style="float: right;"><div style="float: left; width: 100px; font-size: 1em;"><b>Week No:</b></div><div style="float: left; width: 80px; text-align: center; border-bottom: 1px #000000 solid;"><?php echo $week; ?>&nbsp;</div></div>
            <div style="clear:both;"></div>
        </div>
		<div style="width: 100%; padding: 0px;"><h1 style="font-size: 1.3em;margin: 10px 0px 5px 0px;padding:0px;">COURSE INFORMATION</h1></div>
        <div style="width: 1002px; border: 1px #333333 solid; padding: 0px 10px 0px 10px;">
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 180px; float: left; font-size: 1em; color: #333;"><b>Course Title</b></div>
                <div style="width: 822px; float: left; font-size: 1em;"><b>:</b> <?php echo $offering[0]['Course']['title']; ?></div>
                <div style="clear:both;"></div>
            </div>
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 180px; float: left; font-size: 1em; color: #333;"><b>Venue</b></div>
                <div style="width: 822px; float: left; font-size: 1em;"><b>:</b> GigaMare Inc.</div>
                <div style="clear:both;"></div>
            </div>
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 180px; float: left; font-size: 1em; color: #333;"><b>Course Duration</b></div>
                <div style="width: 822px; float: left; font-size: 1em;"><b>:</b> <?php echo $this->DateRangeFormat->FormatDateRange(strtotime($offering[0]['Offering']['date_start']), strtotime($offering[0]['Offering']['date_end'])); ?></div>
                <div style="clear:both;"></div>
            </div>
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 180px; float: left; font-size: 1em; color: #333;"><b>Instructor(s)</b></div>
                <div style="width: 822px; float: left; font-size: 1em;"><b>:</b> <?php $instrs="";foreach($offerInstructors as $instructor){$instrs.=(trim($instrs)!=''?" / ":"").$instructor['OfferInstructor']['fullname'];} echo $instrs;?>&nbsp;</div>
                <div style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
		<div style="width: 100%; padding: 0px;"><h1 style="font-size: 1.3em; margin: 20px 0px 5px 0px; padding:0px;">STUDENT'S INFORMATION</h1></div>
        <div style="width: 1002px; border: 1px #333333 solid; padding: 0px 10px 0px 10px;">
        	<div style="margin: 20px 0px 10px 0px;">
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">First Name</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Middle Name</div>
            	<div style="width: 320px; float: left; font-size: 1em; text-align: center;">Last Name</div>
            	<div style="clear:both;"></div>
            </div>
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 661px; float: left; border-bottom: 1px #000000 solid; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Date of Birth</div>
            	<div style="width: 661px; float: left; font-size: 1em; text-align: center;">Home Address</div>
            	<div style="clear:both;"></div>
            </div>
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">E-mail Address</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Education</div>
            	<div style="width: 320px; float: left; font-size: 1em; text-align: center;">Degree</div>
            	<div style="clear:both;"></div>
            </div>
            <div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 320px; float: left; margin-right: 21px; padding-top: 11px;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; padding-top: 11px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">&nbsp;</div>
            	<div style="width: 320px; float: left; font-size: 1em; text-align: center;">PRC License, if any</div>
            	<div style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div style="width: 1002px; border: 1px #333333 solid; padding: 0px 10px 0px 10px; margin-top: 15px;">
        	<h1 style="font-size: 1.1em;margin: 10px 0px 5px 0px;padding:0px;">To be filled-up by Marine Participant only.</h1>
            <div style="margin: 10px 0px 10px 0px;">
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Years of Sea-going Service</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Last Vessel</div>
            	<div style="width: 320px; float: left; font-size: 1em; text-align: center;">Next Vessel</div>
            	<div style="clear:both;"></div>
            </div>
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Rank</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Principal</div>
            	<div style="width: 320px; float: left; font-size: 1em; text-align: center;">Manning Agent</div>
            	<div style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div style="width: 100%; padding: 0px;"><h1 style="font-size: 1.3em;margin: 20px 0px 5px 0px;padding:0px;">EMPLOYER'S INFORMATION</h1></div>
        <div style="width: 1002px; border: 1px #333333 solid; padding: 0px 10px 0px 10px;">
        	<div style="margin: 10px 0px 10px 0px;">
            	<div style="width: 661px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 661px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Company Name</div>
            	<div style="width: 320px; float: left; font-size: 1em; text-align: center;">Contact Number(s)</div>
            	<div style="clear:both;"></div>
            </div>
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 1002px; float: left; border-bottom: 1px #000000 solid; padding-top: 10px;">&nbsp;</div>
            	<div style="width: 1002px; float: left; font-size: 1em; text-align: center;">Business Address</div>
            	<div style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div style="width: 1004px; padding: 0px 10px 0px 10px; margin-top: 50px;">
        	<div style="margin: 15px 0px 15px 0px;">
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid; margin-right: 21px;">&nbsp;</div>
            	<div style="width: 320px; float: left; border-bottom: 1px #000000 solid;">&nbsp;</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Student's Signature</div>
            	<div style="width: 320px; float: left; margin-right: 21px; font-size: 1em; text-align: center;">Date of Registration</div>
            	<div style="width: 320px; float: left; font-size: 1em; text-align: center;">Registrar's Signature</div>
            	<div style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
		</div>
        <div style="width: 100%; padding: 0px;"><h1 style="font-size: 1.3em;margin: 50px 0px 5px 0px;padding:0px;">REMARKS</h1></div>
        <div style="width: 1002px; height: 200px; border: 1px #333333 solid; padding: 0px 10px 0px 10px;">
            <div style="clear:both;"></div>
		</div>
	</div>
</body>
</html>
