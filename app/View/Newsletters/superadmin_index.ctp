<?php //  echo $this->element('admin-breadcrumbs',array('pageName'=>'newsletter')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Download Email Subscriptions</div>
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
          <td align="left" valign="middle">
	<?php /*?>	  <?php echo $this->Form->postLink(
						'Unsubscribe All',
						array('action' => 'unsubscribe','all'),
						array('confirm' => 'Are you sure to unsubscribe all email?','class'=>'a-state-default'));
					?>
				&nbsp;
		  <?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Send Newsletter to All" name="assign">',array('controller'=>'newsletters','action'=>'sendnewsletter','all'),array('escape'=>false)); ?>
          
          &nbsp;<?php */?>
		  <?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Export All Emails" name="assign">',array('controller'=>'newsletters','action'=>'exportall'),array('escape'=>false)); ?>
          
		  </td>

      </tr>
      <td>      
            <ul class="bullet_list">
                <?php if(is_array($subscriber) && count($subscriber)):?>
				<?php foreach ($subscriber as $subscriber): ?>
					<ul class="bullet_list">         
						<li>
						<?php // echo $this->Html->link($subscriber['NewsletterSubscriber']['subscriber_email'],array('controller'=>'newsletters','action'=>'sendnewsletter',$subscriber['NewsletterSubscriber']['id']),array('escape'=>false)); ?>
						<?php echo $subscriber['NewsletterSubscriber']['subscriber_email']; ?>
                        </li>
					</ul>
				<?php endforeach; ?>
			  <?php else:?>
				No Subscriber is available.
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
<?php if(count($subscriber)):?>
<div style="clear:both; margin: 5px 0px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>