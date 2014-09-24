<?php //pr($regEventInfo);?>
<div id="wrapper"> <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor"><?php echo $regEventInfo['Show']['show_name'];?></h1>
          <div class="content">
              <p>
			  <font face="Verdana, Arial, Helvetica, sans-serif" size="5" color="#005EC5"><b>
			  <font size="4"><b>
			  <?php if($regEventInfo['Show']['show_end_dt']!=''):?>
				<?php echo date("F d, Y",strtotime($regEventInfo['Show']['show_dt']));?> - <?php echo date("M d, Y",strtotime($regEventInfo['Show']['show_end_dt']));?>
			<?php else: ?>
				<?php echo date("F d, Y",strtotime($regEventInfo['Show']['show_dt']));?>
			<?php endif;?>
			</b>
			<br/>
			<?php echo $regEventInfo['Location']['site_name'];?><br/>
			<font size="2"> <b>
			<?php echo $regEventInfo['Location']['site_address'];?><br/>
			<?php echo $regEventInfo['Location']['location_city'].", ".$regEventInfo['Location']['location_state']." ".$regEventInfo['Location']['site_zip'];?><br/><?php if($regEventInfo['Location']['site_phone']!=''):?><p><strong> Phone:</strong> <span><?php echo $regEventInfo['Location']['site_phone']?>
			</span> </p><?php endif;?>
			</b> </font></font></b></font>
			</p>
            <br/>
			<?php echo $regEventInfo['Show']['show_travel_dir'];?>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('scroll_panel');?> </div>
</div>
