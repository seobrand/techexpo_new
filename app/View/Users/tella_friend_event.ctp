<script type="text/javascript">
	function validationCheck()
	{
		var validation='';
		var fname = document.getElementById("fname").value;
		var lname = document.getElementById("lname").value;
		var email = document.getElementById("email").value;
		var email1 = document.getElementById("email1").value;
	
	
		if(!$.trim(fname))
		{
			validation +='Please Enter First Name\n';
		}
		if(!$.trim(lname))
		{
			validation +='Please Enter Last Name\n';
		}
		
		if(email=='')
		{	
			validation +='Please Enter Your E-mail Address\n';
				
		}else
		{	
			
				filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (filter.test(email)) 
					{
 					
					}
				  else
				  	{
						validation +='Please Enter Your Valid E-mail Address\n';
					}
	
				
		}
		
		
		if(email1=='')
		{	
			validation +="Please Enter Friend's E-mail Address\n";
				
		}else
		{	
				filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (filter.test(email1)) 
					{
 					
					}
				  else
				  	{
						validation +="Please Enter Friends Valid E-mail Address\n";
					}
		}
		if(document.getElementById("emailMessage").value==''){
			validation +="Please Enter Message\n";
		}
		
		if(validation)
		{
			alert(validation);
			return false;
		}

		
	}
</script>

<table  style="width:500px;text-align:center;height:300px;" >
  <tr>
    <td style="color:#003300" align="center"></td>
  </tr>
  <tr>
    <td align="center" class="content"><form action="<?php echo FULL_BASE_URL.router::url('/',false);?>users/tellaFriendEvent" method="post">
        <table class="popup_textexpo" height="200px" width="400">
          <tr>
            <td align="right"> First Name </td>
            <td width="20">:</td>
            <td align="left"><input type="text" name="fname" id="fname" class="input_208" />
            </td>
          </tr>
          <tr>
            <td colspan="3" height="8px;"></td>
          </tr>
          <tr>
            <td align="right"> Last Name </td>
            <td width="20">:</td>
            <td align="left"><input type="text" name="lname" id="lname" class="input_208" />
            </td>
          </tr>
          <tr>
            <td colspan="3" height="8px;"></td>
          </tr>
          <tr>
            <td align="right"> Your Email </td>
            <td width="20">:</td>
            <td align="left"><input type="text" name="email" id="email" class="input_208" />
            </td>
          </tr>
          <tr>
            <td colspan="3" height="8px;"></td>
          </tr>
          <tr>
            <td align="right"> Your Friends Email </td>
            <td width="20">:</td>
            <td align="left"><input type="text" name="friendemail" id="email1" class="input_208" />
            </td>
          </tr>
          <tr>
            <td colspan="3" height="8px"></td>
          </tr>
          <tr>
            <td align="right"> Your Message </td>
            <td width="20">:</td>
            <td class="form_rt_col1" align="left"><textarea name="message"  class="textarea_237 smallTextB" id="emailMessage"></textarea>
            </td>
          </tr>
          <tr>
            <td colspan="3" height="8px;"></td>
          </tr>
          <tr>
            <td colspan="2" height="8px;"></td>
            <td><input type="hidden" name="SUBMIT" value="SUBMIT" />
            <input type="hidden" name="event" value="event" />
              <input type="image" name="SUBMIT" value="SUBMIT" onclick="return validationCheck();" src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/send.jpg" style="float:left !important;left:0px;"/></td>
          </tr>
        </table>
        </div>
      </form></td>
  </tr>
</table>
