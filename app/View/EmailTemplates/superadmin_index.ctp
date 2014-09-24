<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'emailtemplate')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Email Templates</div>
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
  

  <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="left" valign="middle"><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add Template" name="assign">',array('controller'=>'emailTemplates','action'=>'add'),array('escape'=>false)); ?></td>

      </tr>
      <td>      
            <ul class="bullet_list">
                <?php if(is_array($emailTemplate) && count($emailTemplate)):?>
				<?php foreach ($emailTemplate as $emailTemplate): ?>
					<ul class="bullet_list">         
						<li><?php echo $this->Html->link($emailTemplate['EmailTemplate']['title'],array('controller'=>'emailTemplates','action'=>'edit',$emailTemplate['EmailTemplate']['id']),array('escape'=>false)); ?></li>
					</ul>
				<?php endforeach; ?>
			  <?php else:?>
				No Template list is available.
			  <?php endif;?>
            </ul>         
         </td></tr>
      
      </tbody>
    </table>
  </div>
</div>
   </div>
        <!-- end table --> 
</div>
<?php if(count($emailTemplate)):?>
<div style="clear:both; margin: 5px 0px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>