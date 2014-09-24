<div class="side_box sidesearch_box">
          <div class="gray_side_head"></div>
          <div class="gray_side_mid">
            <div class="gray_side_bottom">
              <ul class="gray_action_list">
                <li class="aligncenter">
                  <h1>JOB SEEKERS</h1>
                  <a href="create-new-account.html">
                  <?php echo $this->Html->link($this->Html->image('images/side_submitresume.jpg'),array('controller'=>'candidates','action'=>'register'));?>
                 
                  </a> </li>
                <li class="aligncenter">
                  <h1>EMPLOYERS</h1>
                  <a href="employer-progress.html">
                  
                  <?php echo $this->Html->image('images/side_post.jpg');?>
                  </a> </li>
                <li class="last aligncenter">
                  <h1>RECRUIT WITH US</h1>
                  <a href="employer-progress.html">
                
                  <?php echo $this->Html->image('images/side_become_btn.jpg');?>
                  </a> </li>
              </ul>
            </div>
          </div>
 </div>

<div class="side_box">
    <div class="sideprofile_head">
      <h3 class="upcoming_ico">Upcoming Events </h3>
    </div>
    <div class="sidenews_mid industrynews1">
      <div class="sidenews_bottom industrynews1">
        <ul class="dash_ev_list sidebar_upcoming">
        	<?php if(count($upcomingEvents)>0):
			  	foreach($upcomingEvents as $key => $upcomingEvent){
			  ?>
          <li>
            <div class="date_event">
              <div class="dt_lf">
                <div class="dt_rt">  <?php echo  date('M t,Y', strtotime($upcomingEvent['Show']['show_dt'])) ?></div>
              </div>
            </div>
           
            <?php echo $this->Html->link('view more',array('controller'=>'shows','action'=>'view',$upcomingEvent['Show']['id']),array('class'=>'viewMore'));?>
            <div class="clear"></div>
            <p><?php echo $upcomingEvent['Show']['show_name'];?> <br/>
			 Security Clearance <?php     if($upcomingEvent['Show']['sec_clearance_req']=='n') echo "<strong>Not</strong>";  ?> REQUIRED</p>
              <p class="employer_profile_action">  
             </p>
     <!--       <p class="employer_profile_action"> <a href="" class="regi_not">Not Registered</a><a href="" class="sold_out">SOLD OUT</a>&nbsp;&nbsp;</p>-->
            <div class="clear"></div>
          	</li>
   			<?php  } // endoreach
			  else: 
				?>
				<tr>
                <td class="table_row" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="6"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">There is no upcoming event in our database.</font></td>
                    </tr>
                  </table></td>
              </tr>
			<?php endif;?>
        </ul>
      </div>
    </div>
  </div>