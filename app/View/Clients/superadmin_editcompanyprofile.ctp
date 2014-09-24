<script type="text/javascript">
	function isNumericKey(e)
	{
		if (window.event) { var charCode = window.event.keyCode; }
		else if (e) { var charCode = e.which; }
		else { return true; }
		if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; }
		return true;
	}
	</script>
    <div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Company Profile</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<!-- box / title -->
<div class="display_row">
  <div class="table">
  <?php echo $this->Form->create("Employer",array('name'=>'empProfile','id'=>'empProfile'));?>
    <table cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td valign="middle" colspan="2">
            <h2><?php echo $common->getEmployerName($this->request->data['Employer']['id']); ?></h2></td>
        </tr>
        <tr>
          <td colspan="2"><p>Edit a Company's information and profile.</p></td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Company Name:</td>
          <td valign="middle" align="left" width="74%"><?php echo $this->Form->input('Employer.employer_name',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">MAIN Phone:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.main_phone',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>18,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Address:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.address',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>80,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">City:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.city',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>50,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">State:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.state',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>2,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Zip:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.zip',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>5,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Web URL:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.url',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>128,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">LinkedIn / Corporate Profile:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.linkedin',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>128,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Company Facebook:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.facebook',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>128,'error'=>false));?>
          </td>
        </tr>
        
        <tr>
          <td width="25%" valign="middle" height="2"  align="right"> Fax: </td>
          <td valign="middle" height="2" align="left"><?php echo $this->Form->input('Employer.fax',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>10,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Stock Symbol: </td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.stock_symbol',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>128,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Annual Revenue: </td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.annual_revenue',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>9,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Number of Employees: </td>
          <td><?php echo $this->Form->input('Employer.number_of_employees',array('label'=>false,'div'=>false,'class'=>'inputbox1','onkeypress'=>'return isNumericKey(event);','maxlength'=>128,'error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Max number of jobs: </td>
          <td><?php echo $this->Form->input('Employer.max_jobs',array('label'=>false,'div'=>false,'class'=>'inputbox1','maxlength'=>3,'onkeypress'=>'return isNumericKey(event);','error'=>false));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle"  align="right">Do you occasionally sponsor H1-B visas ? </td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.visa_status',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>false,'div'=>false));?>
          </td>
        </tr>
        <tr>
          <td valign="middle"  align="right">Industry: </td>
          <td valign="middle" align="left">
<?php // echo $this->Form->input('Employer.employer_type_code',array('type'=>'select','options'=>$industryList,'label'=>false,'div'=>false));?>
          <div class="checkbox_div checkbox_list" style="height:100px;width:400px !important;">
           <?php 
		   if(isset($this->request->data['Employer']['employer_type_code']))
		   $selected = explode(',',$this->request->data['Employer']['employer_type_code']);
		   else
		   $selected = '';
		     echo $this->Form->input('Employer.employer_type_code',array('type'=>'select','multiple'=>'checkbox','options'=>$industryList,'label'=>false,'div'=>false,'hiddenField' => false,'class'=>'big237_textfield', 'selected' => $selected)); 
						   ?>
           </div>                
           <div style="clear:both;"></div>
           <br/>
           To see an industry added to the list, <a href="mailto:webmaster@techexpousa.com?subject=Please add an industry to your list.">click here.</a></td>
        </tr>
        
        
        <tr>
          <td width="25%" valign="middle"  align="right">Enter your Company Description</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('Employer.description',array('type'=>'textarea','label'=>false,'div'=>false,'rows'=>10,'cols'=>65));?>
          </td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td align="left"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
          </td>
        </tr>
      </tbody>
    </table>
   <?php echo $this->Form->input('Employer.id',array('type'=>'hidden','value'=>$this->request->data['Employer']['id']));?>
   <?php echo $this->Form->end();?>
  </div>
</div>
