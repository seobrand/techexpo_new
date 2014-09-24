<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">
Testimonial's  For Approval</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th width="30%" align="left" valign="middle"> Name </th>
          <th align="left" valign="middle">Description </th>
         
         <th align="left" valign="middle"> Image </th>
      
          <th align="left" valign="middle">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($testimonials as $tetimonial){?>
        <tr>
          <td width="25%"  align="left"><?php echo $tetimonial['Testimonial']['name'];?> </td>
          <td align="left"> <?php echo $this->Text->truncate($tetimonial['Testimonial']['text'],50);?>...</td>
         
          <td align="left"><img src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/testimonial/<?php echo $tetimonial['Testimonial']['logo_file'];?>" width="100" height="80"/> </td>
       
          <td align="left">
		  
		  <?php if($tetimonial['Testimonial']['aprov']=='0')
		  { 
		  
		  echo $this->Form->postLink('Approve',array('controller'=>'testimonials','action'=>'testimonailApproval',$tetimonial['Testimonial']['id']),
		  							array('confirm'=>'Are you sure want to Approve this testimonial?','class'=>'a-state-default'));
			}?>
          
          </td>
        </tr>
        <?php } ?>
		<?php if(count($testimonials)==0){?>
		<tr>
          <td colspan="5" align="center">There is no Testimonial..</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
