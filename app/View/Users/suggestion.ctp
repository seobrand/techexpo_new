<script type="text/javascript">
	function validationCheck()
	{
		var validation='';
		var sendername = document.getElementById("sendername").value;
		var senderemail = document.getElementById("senderemail").value;
		var emailMessage = document.getElementById("emailMessage").value;

		if(sendername=='')
		{	
			validation +='Please Enter Your Name\n';
		}
	
		if(senderemail=='')
		{	
			validation +='Please Enter Your E-mail Address\n';
		}else
		{	
				filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (filter.test(senderemail)) 
					{
					}
				  else
				  	{
						validation +='Please Enter Your Valid E-mail Address\n';
					}
		}
		
		if(document.getElementById("emailMessage").value==''){
			validation +="Please Enter Message\n";
		}
		
		  var d = document.getElementById('BotBootInput').value;
		  if(!d) validation +="Please Enter Captcha\n"; 
		  else
       		 if (d != c) validation +="Please Enter correct captcha\n";        
			
		
		if(validation)
		{
			alert(validation);
			return false;
		}

		
	}
</script>
<script type="text/javascript">
    var a = Math.ceil(Math.random() * 10);
    var b = Math.ceil(Math.random() * 10);       
    var c = a + b
    function DrawBotBoot()
    {
       
			$("#captcha1").html("What is "+ a + " + " + b +"? ");
		 $("#captcha").html("<input id='BotBootInput' type='text' maxlength='2' size='2' class='input_208'/>");
    }    
    function ValidBotBoot(){
      
        
    }
    </script>

<table  style="text-align:center;" >
  <tr>
    <td style="color:#003300" align="center"></td>
  </tr>
  <tr>
    <td align="center" class="content"><form action="<?php echo FULL_BASE_URL.router::url('/',false);?>users/suggestion" method="post">
        <table >
          <tr>
            <td align="right" width="500px"> To </td>
            <td width="30px">:</td>
            <td align="left"><strong style="font-size:14px;"> Bradford Rand, President/CEO TECHEXPO </strong>
              <input type="text" name="adminemail" id="adminemail" class="input_208"   value="Bradford@techexpousa.com" style="display:none"/>
            </td>
          </tr>
          <tr>
            <td colspan="3" height="5"></td>
          </tr>
          <tr>
            <td align="right"> Your Name </td>
            <td>:</td>
            <td  align="left"><input type="text" name="sendername" id="sendername" class="input_208" />
            </td>
          </tr>
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          <tr>
            <td align="right"> Your Email </td>
            <td >:</td>
            <td  align="left"><input type="text" name="senderemail" id="senderemail" class="input_208" />
            </td>
          </tr>
          <tr>
            <td colspan="3" height="10"></td>
          </tr>
          <tr>
            <td align="right"> Your Message/Comment </td>
            <td>:</td>
            <td class="form_rt_col1" align="left"><textarea name="emailMessage"  class="textarea_237 smallTextB" id="emailMessage"></textarea>
            </td>
          </tr>
          <tr>
            <td colspan="3" height="5"></td>
          </tr>
          <tr>
            <td align="right">Security Question</td>
            <td>:</td>
            <td class="form_rt_col1" align="left"><div id="captcha1"></div>
              <div id="captcha"></div>
              <script type="text/javascript">DrawBotBoot()</script>
            </td>
          </tr>
           <tr>
            <td colspan="3" height="10"></td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td>
            <input type="text" value="" class="extrafields" name="checkuser"  />
            <input type="hidden" name="SUBMIT" value="SUBMIT" />
              <input type="image" name="SUBMIT" value="SUBMIT" onclick="return validationCheck();" src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/send.jpg"/>
            </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
