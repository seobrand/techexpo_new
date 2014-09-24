<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'updatepartner')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Update Partner</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('Partner',array('action'=>'edit','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
           
            <tr>
              <td width="25%" align="right" valign="middle">Partner Name: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('partner_name',array('class'=>'inputbox1','type'=>'text'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle"> Marketing Partner: </td>
              <td align="left" valign="top">
			  <?php //echo $this->Form->input('employer_id',array('type'=>'select','options'=>$clientList,'empty'=>'-Select Partner-','lable'=>false,'div'=>'false')); ?>
              <?php echo $this->Form->input('marketing_exhibitor_id',array('type'=>'select','options'=>$clientList,'empty'=>'-Select Partner-','lable'=>false,'div'=>'false')); ?>
              </td>
            </tr> 
            <tr>
              <td align="right" valign="middle"> Site URL: </td>
              <td align="left" valign="top">
			  <?php //echo $this->Form->input('employer_id',array('type'=>'select','options'=>$clientList,'empty'=>'-Select Partner-','lable'=>false,'div'=>'false')); ?>
              <?php echo $this->Form->input('site_url',array('class'=>'inputbox1','lable'=>false,'div'=>'false')); ?>
             <br/> Ex : http://techexpousa.com
              </td>
            </tr>  
            <?php /*?><tr>
              <td align="right" valign="middle"><b>Preview:</b> </td>
              <td align="left" valign="top">  
			  <?php if(isset($this->request->data['Employer']['logo_file'])) {  ?>         
				<?php  echo $this->Html->image('../upload/'.$this->request->data['Employer']['logo_file'],array('align'=>'absmiddle')); ?>
			<?php }else{?>
				<?php  echo $this->Html->image('../upload/'.$this->request->data['Partner']['curr_logo'],array('align'=>'absmiddle')); ?>
			<?php } ?>
             </td>
            </tr><?php */?>

            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Update Partner',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo "&nbsp;&nbsp;";
                echo $this->Form->hidden('id');
			/*	if(isset($this->request->data['Employer']['logo_file']))
                echo $this->Form->hidden('curr_logo',array('value'=>$this->request->data['Employer']['logo_file']));
				else
				echo $this->Form->hidden('curr_logo',array('value'=>$this->request->data['Partner']['curr_logo']));*/
                echo $this->Form->end();
                echo $this->Form->postLink('Delete Partner',array('action'=>'delete',$this->data['Partner']['id']),array('confirm'=>'Are you sure want to delete?','class'=>'a-state-default'));                
              ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
 </div>
        <!-- end table --> 
      </div>

