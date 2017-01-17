<?php echo $this->Form->create(array('action'=>'edit', 'id'=>'js-frm-saveadditionaldetails','style'=>'width:100% !important;')); ?>
<div class="float_left" style="padding:15px 0px 0px 20px;margin:0px;color:#666;">
    <div class="input text" style="margin-bottom:10px;">
        <label for="SalesOrderNo"><b>Sales Order No.</b></label>
        <select name="data[OfferingParticipant][sales_order_no]" class="easyui-combobox" data-options="{panelHeight:'auto',width:350,prompt:'--- sales order number ---'}" id="SalesOrderNo">
			      <option value="" selected="selected"></option>
      <?php
        	$sap_nos = explode(";", $additionalDetails[0]['Offering']['sales_order_no']);
  				foreach($sap_nos as $sap_no):
  					echo "<option value=\"".trim($sap_no)."\"".(trim($sap_no)==trim($additionalDetails[0]['OfferingParticipant']['sales_order_no'])?" selected":"").">".trim($sap_no)."</option>";
  				endforeach;
			?>
        </select>
        <input name="data[OfferingParticipant][id]" type="hidden" value="<?php echo $id; ?>"/>
        <input name="data[OfferingID]" type="hidden" value="<?php echo $additionalDetails[0]['OfferingParticipant']['offering_id']; ?>"/>
    </div>
    <div class="input text" style="margin-bottom:10px;">
        <label for="TransportProvider"><b>Transport Provider</b></label>
        <input name="data[OfferingParticipant][transport_provider]" class="easyui-textbox" style="width:350px;" type="text" id="TransportProvider" value="<?php echo $additionalDetails[0]['OfferingParticipant']['transport_provider']; ?>"/>
    </div>
    <div class="input text" style="margin-bottom:10px;">
        <label for="TransportArrangment"><b>Transport Arrangement</b></label>
        <input name="data[OfferingParticipant][transport_arrangement]" class="easyui-textbox" style="width:350px;height:55px;" data-options="multiline:true" type="text" id="TransportArrangment" value="<?php echo $additionalDetails[0]['OfferingParticipant']['transport_arrangement']; ?>"/>
    </div>
    <div class="input text" style="margin-bottom:10px;">
        <label for="HotelName"><b>Hotel Name</b></label>
        <input name="data[OfferingParticipant][hotel_name]" class="easyui-textbox" style="width:350px;" type="text" id="HotelName" value="<?php echo $additionalDetails[0]['OfferingParticipant']['hotel_name']; ?>"/>
    </div>
    <div class="input text" style="margin-bottom:10px;">
        <label for="RoomType"><b>Room Type</b></label>
        <input name="data[OfferingParticipant][hotel_room_type]" class="easyui-textbox" style="width:350px;" type="text" id="RoomType" value="<?php echo $additionalDetails[0]['OfferingParticipant']['hotel_room_type']; ?>"/>
    </div>
    <div class="input text" style="margin-bottom:10px;">
        <label for="PeriodOfStay"><b>Period of Stay</b></label>
        <input name="data[OfferingParticipant][hotel_period_of_stay]" class="easyui-textbox" style="width:350px;height:55px;" data-options="multiline:true" type="text" id="PeriodOfStay" value="<?php echo $additionalDetails[0]['OfferingParticipant']['hotel_period_of_stay']; ?>"/>
    </div>
    <div class="input text">
        <label for="MealArrangement"><b>Meal Arrangement</b></label>
        <input name="data[OfferingParticipant][meal_arrangement]" class="easyui-textbox" style="width:350px;height:55px;" data-options="multiline:true" type="text" id="MealArrangement" value="<?php echo $additionalDetails[0]['OfferingParticipant']['meal_arrangement']; ?>"/>
    </div>
</div>
<input type="hidden" name="data[ApplyToAll]" value="1"/>
<br/>
<?php echo $this->Form->end();?>
