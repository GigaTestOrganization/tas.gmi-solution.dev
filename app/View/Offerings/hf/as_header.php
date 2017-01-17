<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GigaMare Inc. - Learning Management System</title>
<style type="text/css">
	body{margin:0px;padding:0px;font-family:Arial;}
	h1{color:#CCC;padding:0px;margin:0px;font-size:3em;}
</style>
</head>

<body>
	<div style="width:2238px;height:400px;margin:auto;">
    	<div style="float:left;width:2236px;height:100px;padding-top:60px;margin: 0px 0px 15px 0px;background: transparent url(<?php echo $this->Html->url('/img/gmi/gigamare_medium_low_opacity.jpg', true); ?>) top left no-repeat;text-align:right;">
        	<h1>Daily Attendance Record</h1>
            <div style="clear:both;"></div>
        </div>
        <div style="float:left;width:2236px;font-size:1.2em;">
        	<div style="float:left;width:1495px;padding:0px 30px 0px 5px;">
            	<div style="margin:0px 0px 15px 0px;">
            		<div style="float:left;width:220px;padding:2px;"><b>Course Title</b></div>
                    <div style="float:left;width:20px;padding:2px;text-align:center;"><b>:</b></div>
                    <div style="float:left;width:650px;padding:2px;border-bottom:1px #999999 solid;"><?php echo $offering[0]['Course']['title']; ?></div>
                    <div style="clear:both;"></div>
                </div>
            	<div style="margin:0px 0px 15px 0px;">
            		<div style="float:left;width:220px;padding:2px;"><b>Class Schedule</b></div>
                    <div style="float:left;width:20px;padding:2px;text-align:center;"><b>:</b></div>
                    <div style="float:left;width:650px;padding:2px;border-bottom:1px #999999 solid;"><?php echo $this->DateRangeFormat->FormatDateRange(strtotime($offering[0]['Offering']['date_start']), strtotime($offering[0]['Offering']['date_end'])); ?></div>
                    <div style="clear:both;"></div>
                </div>
            	<div style="margin:0px 0px 15px 0px;">
            		<div style="float:left;width:220px;padding:2px;"><b>Practicum Site/Vessel</b></div>
                    <div style="float:left;width:20px;padding:2px;text-align:center;"><b>:</b></div>
                    <div style="float:left;width:650px;padding:2px;border-bottom:1px #999999 solid;">&nbsp;</div>
                    <div style="clear:both;"></div>
                </div>
                <div>
            		<div style="float:left;width:220px;padding:2px;"><b>Instructor(s)</b></div>
                    <div style="float:left;width:20px;padding:2px;text-align:center;"><b>:</b></div>
                    <div style="float:left;width:650px;padding:2px;border-bottom:1px #999999 solid;"><?php $instrs="";foreach($offerInstructors as $instructor){$instrs.=(trim($instrs)!=''?" / ":"").$instructor['OfferInstructor']['fullname'];} echo $instrs;?>&nbsp;</div>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div style="float:left;width:700px;">
            	<div style="margin:0px 0px 15px 0px;">
            		<div style="float:left;width:180px;padding:2px;"><b>Class No.</b></div>
                    <div style="float:left;width:20px;padding:2px;text-align:center;"><b>:</b></div>
                    <div style="float:left;width:400px;padding:2px;border-bottom:1px #999999 solid;">&nbsp;</div>
                    <div style="clear:both;"></div>
                </div>
            	<div style="margin:0px 0px 15px 0px;">
            		<div style="float:left;width:180px;padding:2px;"><b>Bldg. & Room No.</b></div>
                    <div style="float:left;width:20px;padding:2px;text-align:center;"><b>:</b></div>
                    <div style="float:left;width:400px;padding:2px;border-bottom:1px #999999 solid;">&nbsp;</div>
                    <div style="clear:both;"></div>
                </div>
            	<div style="margin:0px 0px 15px 0px;">
            		<div style="float:left;width:180px;padding:2px;"><b>Practicum Date</b></div>
                    <div style="float:left;width:20px;padding:2px;text-align:center;"><b>:</b></div>
                    <div style="float:left;width:400px;padding:2px;border-bottom:1px #999999 solid;">&nbsp;</div>
                    <div style="clear:both;"></div>
                </div>
                <div>
            		<div style="float:left;width:180px;padding:2px;"><b>Assessor(s)</b></div>
                    <div style="float:left;width:20px;padding:2px;text-align:center;"><b>:</b></div>
                    <div style="float:left;width:400px;padding:2px;border-bottom:1px #999999 solid;">&nbsp;</div>
                    <div style="clear:both;"></div>
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
</body>
</html>
