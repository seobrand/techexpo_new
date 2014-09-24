<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div class="display_row">
  <div class="table"><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="New Search" name="assign">',array('controller'=>'clients','action'=>'clientmanager'),array('escape'=>false)); ?><br />
    <br />
	<?php if(isset($employers) && count($employers)>0){?>
	<?php foreach($employers as $key => $employer){?>
    <table cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <th valign="middle" align="left"><?php echo $employer['Employer']['employer_name'];?></th>
        </tr>
      </tbody>
      <tr>
        <td valign="middle" align="left"><table style="border:0">
            <tr>
              <td style="border:0" width="200"><?php echo $this->Html->link("Assign to event's", array('controller'=>'clients','action'=>'assignevent',$employer['Employer']['id']),array('target' => '_blank')); ?></td>
              <td style="border:0" width="200"><?php echo $this->Html->link("Assign resume to databases", array('controller'=>'clients','action'=>'assignresumedb',$employer['Employer']['id'],'y'),array('target' => '_blank')); ?></td>
              <td style="border:0" width="300"><?php echo $this->Html->link("Assign DB's - No e-mail", array('controller'=>'clients','action'=>'assignresumedb',$employer['Employer']['id'],'n'),array('target' => '_blank')); ?></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td valign="middle" align="left"><table style="border:0">
            <tr>
              <td style="border:0" width="200"><?php echo $this->Html->link("Edit company", array('controller'=>'clients','action'=>'editcompanyprofile',$employer['Employer']['id']),array('target' => '_blank')); ?></td>
              <td style="border:0" width="200"><?php echo $this->Html->link("Add / Edit recruiter info, username & password", array('controller'=>'clients','action'=>'editcompanycontact',$employer['Employer']['id'],$employer['EmployerContact']['id']),array('target' => '_blank')); ?></td>
              <td style="border:0" width="300"><?php echo $this->Html->link("Add/Update LOGO file", array('controller'=>'clients','action'=>'clientlogofile',$employer['Employer']['id']),array('target' => '_blank')); ?></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td valign="middle" align="left">
        <table style="border:0">
            <tr>
              <td style="border:0" width="200"><?php echo $this->Html->link("Delete Account", array('controller'=>'clients','action'=>'deleteaccount',$employer['Employer']['id'],$employer['EmployerContact']['id'])); ?></td>
              <td style="border:0" width="200"><?php echo $this->Html->link("Send Login", array('controller'=>'clients','action'=>'sendlogindetail',$employer['Employer']['id'],$employer['EmployerContact']['id']),array('target' => '_blank')); ?></td>
        <!--      <td style="border:0" width="300"><?php echo $this->Html->link("Set as featured client", array('controller'=>'clients','action'=>'setasfeaturedclient',$employer['Employer']['id']),array('target' => '_blank')); ?></td>-->
            </tr>
          </table>
          </td>
      </tr>
      <tr>
        <td>
            
            <table style="border:0">
            <tr>
              <td style="border:0" width="200">
			  
			  <?php // echo $this->Html->image("../upload/".$employer['Employer']['logo_file']);?>
              <?php if(!empty($employer['Employer']['logo_file'])) { ?>
               <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$employer['Employer']['logo_file'];?>&maxw=200&maxh=140"   />
               <?php } ?>
              </td>
              <td style="border:0" width="200"><p style="margin:0 0 0 8px">Contact: <?php echo $employer['EmployerContact']['contact_name'];?> &nbsp;&nbsp;&nbsp;City: <?php echo $employer['Employer']['city']; ?> &nbsp;&nbsp;&nbsp;State: <?php echo $employer['Employer']['state']; ?><br />E-mail: <?php echo strip_tags($employer['EmployerContact']['contact_email']);?><br />
			<?php $userInfo = $common->usernamePassword($employer['EmployerContact']['id']);
			if(isset($userInfo[0]) && isset($userInfo[1])) {
			 ?>
            Username: <?php echo $userInfo[0]; ?> &nbsp;&nbsp;&nbsp;Password: <?php echo $userInfo[1];?>
            <?php } ?>
            </p></td>
        
            </tr>
          </table>
            </td>
      </tr>
    </table>
    <br />
	<?php } ?>
    <?php }else{?>
	<table cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td valign="middle" align="center"><table style="border:0">
            <tr>
              <td style="border:0" colspan="3">Sorry no company found by this search criteria...</td>
            </tr>
          </table></td>
      </tr>
    </table>
	<br/>
	<?php } ?>
    <?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="New Search" name="assign">',array('controller'=>'clients','action'=>'clientmanager'),array('escape'=>false)); ?><br />
  </div>
</div>
<?php if(count($employers)):?>
<div style="clear:both;"> 
  <div class="title-pad"> <?php echo $this->element('cms-paging');?> </div>
</div>
<?php endif;?>
