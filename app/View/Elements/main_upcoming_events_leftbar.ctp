<?php $upcomingEvent=$common->upcomingevent(); 

?>

<div class="side_box">
    <div class="sideprofile_head">
      <h3 class="upcoming_ico">Upcoming Events </h3>
    </div>
    <div class="sidenews_mid industrynews1">
      <div class="sidenews_bottom industrynews1">
        <ul class="dash_ev_list sidebar_upcoming">
        	<?php
			
			 if(count($upcomingEvent)>0)
			{
			
			
			  	foreach($upcomingEvent as $key => $upcomingEvent){
			  ?>
          <li>
           
            <p> 
            <span>
			<a href="<?php echo $this->Html->url(array('controller'=>'shows','action'=>'view',$upcomingEvent['Show']['id'])) ; ?>" >
			<?php  if(!empty($upcomingEvent['ShowsHome']['display_name'])) echo $upcomingEvent['ShowsHome']['display_name']; else  echo $upcomingEvent['Show']['show_name'];?>
            </a>
            </span>
            <br/>
            <?php  /*$upcomingEvent['Location']['site_address'].','.$upcomingEvent['Location']['site_name'].'<br/>'.*/ echo $upcomingEvent['Location']['location_city'].','.$upcomingEvent['Location']['location_state'];?><br/>
			
            <?php if(!empty($upcomingEvent['ShowsHome']['special_message'])) echo $upcomingEvent['ShowsHome']['special_message']; else { ?>
        
        	 Security Clearance <?php     if($upcomingEvent['Show']['sec_clearance_req']=='n') echo "<strong>Not</strong>";  ?> REQUIRED</p>
             <?php } ?>
                <div class="date_event">
                <div class="dt_lf">
                <div class="dt_rt">  <?php echo  date('M d, Y', strtotime($upcomingEvent['Show']['show_dt'])) ?></div>
                </div>
                </div>
                <?php echo $this->Html->link('view more',array('controller'=>'shows','action'=>'view',$upcomingEvent['Show']['id']),array('class'=>'viewMore'));?>
            
              <p class="employer_profile_action">  
             </p>
     <!--       <p class="employer_profile_action"> <a href="" class="regi_not">Not Registered</a><a href="" class="sold_out">SOLD OUT</a>&nbsp;&nbsp;</p>-->
           
            
          <br/>
           
           
          	</li>
   			<?php  }} // endoreach
			  else
			  {
				?>
				<tr>
                <td class="table_row" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="6"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">There is no upcoming event in our database.</font></td>
                    </tr>
                  </table></td>
              </tr>
			<?php } ?>
        </ul>
      </div>
    </div>
  </div>