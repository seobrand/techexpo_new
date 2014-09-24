<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'edittrackingpage')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Special Partner Tracking Pages</div>
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
    <p>This interface allows you to create special tracking pages when setting up barter or marketing deals with diferent organizations. When you pick a 3 letter abbreviation for a company, a special tracking page is created and is name "index_x ", where x is replaced by the 3 letter abbreviation you pick. For example, if you pick abc, the file will be named "index_abc ". When you give the partner the link for our web site, it will be of the form "http://www.techexpoUSA.com/index_abc ". Then, when you access the detailed statistics report on this admin site, these various tracking pages will be listed with the numbers of visitors they each brought, allowing you to see what partners are working best.</p>
   	<?php echo $this->Form->create("TrackingPage",array('type'=>'post'));?>
	<table border="0" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td valign="middle" align="right" width="25%"> Organization being tracked: </td>
          <td valign="top" align="left" width="74%"><?php echo $this->Form->input("organization",array('div'=>false,'label'=>false,'error'=>false,'class'=>'inputbox1','maxlength'=>100));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right"> 3 letter abbreviation: </td>
          <td valign="top" align="left"><?php echo $this->Form->input("page_name",array('div'=>false,'label'=>false,'error'=>false,'maxlength'=>3,'size'=>4));?></td>
        </tr>
		<tr>
          <td valign="middle" align="right"> Contact Email: </td>
          <td valign="top" align="left"><?php echo $this->Form->input("contact_email",array('div'=>false,'label'=>false,'error'=>false,'maxlength'=>100,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Test Link: </td>
          <td valign="top" align="left"><a href="http://www.techexpoUSA.com/index_<?php echo $this->request->data['TrackingPage']['curr_page']; ?>" target="_blank"> http://www.techexpoUSA.com/index_<?php echo $this->request->data['TrackingPage']['curr_page']; ?> </a> </td>
        </tr>
        <tr>
          <td></td>
          <td ><?php echo $this->Form->input('page_id', array('type' => 'hidden'));?>
		  <?php echo $this->Form->input('curr_page', array('type' => 'hidden','value'=>$this->request->data['TrackingPage']['curr_page']));?>
            <?php echo $this->Form->submit('Update',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
			<?php echo $this->Form->end();?>

            <?php echo $this->Form->postLink(
						'Delete',
						array('action' => 'deletepartner',$this->request->data['TrackingPage']['page_id']),
						array('confirm' => 'Are you sure to delete?','class'=>'a-state-default'));
					?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
