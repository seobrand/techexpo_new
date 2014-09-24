<script type="text/javascript">
	function validationCheck()
	{
		var validation='';
		var password = document.getElementById("password").value;
		var cpassword = document.getElementById("cpassword").value;
	
	
		if(!$.trim(password))
		{
			validation +='Please enter new password\n';
		}
		if(!$.trim(cpassword))
		{
			validation +='Please enter confirm new password\n';
		}
		
		else if($.trim(password)!=$.trim(cpassword))
		{	
			validation +='Password does not match\n';
				
		}
		
		
		
		if(validation)
		{
			alert(validation);
			return false;
		}

		
	}
</script>

<table  style="width:500px;text-align:center;height:160px;" >
	<tr>
    	<td style="color:#003300" align="center">
       
        </td>
    </tr>
	<tr>
    	<td align="center" class="content">
  
        
        	 <form action="<?php echo FULL_BASE_URL.router::url('/',false);?>employers/changepassword" method="post">
                  
                  <div style="margin:0 auto; width:400px; overflow:hidden;">
                  <table class="popup_textexpo" height="100" width="400" >
                   <tr>
                        <td align="center" colspan="3">
                        	<strong>Please change your password</strong>
                        </td>
                        
                    </tr>
                    <tr>
                    	<td colspan="3" height="8px;"></td>
                    </tr>
                    <tr>
                        <td align="right">
                        	New Password
                        </td>
                        <td width="20">:</td>
                        <td align="left">
                        	<input  name="password" id="password" class="input_208" type="password" />
                         </td>
                    </tr>
                    <tr>
                    	<td colspan="3" height="8px;"></td>
                    </tr>
                    <tr>
                        <td align="right">
                        	Confirm New Password
                        </td>
                        <td width="20">:</td>
                        <td align="left">
                        	<input  name="cpassword" id="cpassword" class="input_208" type="password" />
                         </td>
                    </tr>
                    <tr>
                    	<td colspan="3" height="8px;"></td>
                    </tr>
                   
                    <tr>
                    	<td colspan="2" height="8px;"></td>
                    	<td> <input type="hidden" name="SUBMIT" value="SUBMIT" />
                        	
                        <input type="image" name="SUBMIT" value="SUBMIT" onclick="return validationCheck();" src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/submit_button.jpg" style="float:left !important;left:0px;"/></td>
                    	
                    </tr>
                </table>
                </div>
      		 </form>
        </td>
    </tr>
</table>