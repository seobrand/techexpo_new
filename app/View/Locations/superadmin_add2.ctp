<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addlocation')); ?>

<script type="text/javascript">
function validate()
{		
		
					/*window.parent.$("#text").text(parent.$("#text").text() + " cdsfsdfsdfdsfs,");
					
					parent.$.colorbox.close();
					return false;*/
		var LocationSiteName =  $('#LocationSiteName').val();
		var LocationSiteAddress =  $('#LocationSiteAddress').val();
		var LocationLocationCity =  $('#LocationLocationCity').val();
		var LocationSiteZip =  $('#LocationSiteZip').val();
		var LocationSiteElectricityCost =  $('#LocationSiteElectricityCost').val();
		var LocationInternetConnectivityCost =  $('#LocationInternetConnectivityCost').val();
		
		if(LocationSiteName=='')
		{
			alert('Please enter site name');
			return false;	
		}
		else if(LocationSiteAddress=='')
		{
			alert('Please enter site address');
			return false;	
		}
		else if(LocationLocationCity=='')
		{
			alert('Please enter location city');
			return false;	
		}
		else if(LocationSiteZip=='')
		{
			alert('Please enter site zip');
			return false;	
		}
		else if(isNumber(LocationSiteElectricityCost, true, false))
		{
			alert('Please enter valid electricity cost');
			return false;
			
		}
		else if(isNumber(LocationInternetConnectivityCost, true, false))
		{
			alert('Please enter valid internet connectivity cost');
			return false;
		}
		
		
		$.ajax({
					  type: "POST",
					  url: "<?php echo FULL_BASE_URL.router::url('/',false); ?>locations/add2",
					  data: $('#locationaddfrm').serialize(),
					  success: function(data) {
						 	 	
 							 parent.updateFunction(data);
							   
                            }
						})
		
		return false;
	
}


function isNumber(s , checkFloat, checkNegative) { 
     var Found = false 
     var i; 
     var dCheck = false 
     for (i = 0; i < s.length; i++) 
     {    
         // Check that current character is number. 
         var c = s.charAt(i); 

         if((c == "-") && (i == 0) && (s.length > 0)) { 
           //check negative numbers 
           if(checkNegative == false) { 
             Found = true 
           } 
         } 
         else { 
           if( ((c == ".") && (checkFloat == true) && (dCheck == false))) 
           { 
     	     //pass . operator when checking decimal value 
             dCheck = true 
           }  
           else if (((c < "0") || (c > "9"))) 
           { 
               Found = true 
           } 
       } 
     } 
     if( s.length == 0) 
     { 
         Found = true 
     } 

     if(Found == true) 
     { 
     return true;
     } 
     else 
     { 
        	return false; 
	 } 
      
 }

</script>



<div class="display_row">
  <div class="table">
  <?php  echo $this->Form->create('Location',array('onsubmit'=>'return validate();','target'=>'_top','id'=>'locationaddfrm')); ?> 
  <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="right" valign="middle" width="35%"><span class="required">*</span>Site Name:</td>
          <td align="left" valign="top" width="64%"><?php echo $this->Form->input('site_name',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required">*</span>Address:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_address',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required">*</span>City:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('location_city',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required">*</span>State:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('location_state',array('label'=>'','options'=>$states,'type'=>'select','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required">*</span>Zip:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_zip',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Url:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_url',array('label'=>'','class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Phone:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_phone',array('label'=>'','class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required">*</span>Electricity Cost:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_electricity_cost',array('type'=>'text','label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required">*</span>Internet Connectivity Cost:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('internet_connectivity_cost',array('type'=>'text','label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Show Travel Directions:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_travel_direction',array('type'=>'textarea','label'=>'','class'=>'inputbox1'));?></td>
        </tr>
        <tr>
         <td align="right" valign="middle">&nbsp;</td>
          <td><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->end();?>
  </div>
</div>



