
  <div id="wrapper">

  <div class="inner_banner">
  		  <?php echo $this->Html->image("images/eve_regis_banner.jpg",array('alt'=>''));?>
   </div>
    <div id="container">
   
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Event Registration Center</h1>
            <div class="content">
              
            <p>By clicking on the "my interviews" graphic (under the "Interview list" column heading), you can view the list of employers (if any) that have requested interviews with you for a given event. Please print this list before heading to the event and be sure to visit the employers that have requested interviews with you. </p><br />


<p>You are currently registered for the following upcoming TECHEXPO events:</p><br />



           <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th width="100" style="text-align:left">Event Info</th>
                        <th width="100" style="text-align:left">Date/Time</th>
                      
                        <th width="120" style="text-align:left">Address</th>
                        <th width="100" style="text-align:left">Requirements</th>
                     
                      </tr>
                    </table></td>
                </tr>
                
                <?php foreach( $shows as $show ) {  ?>
                <tr>
                  <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  width="100" style="text-align:left">
                       
                        <?php echo $this->Html->link($show['Show']['show_name'], array('controller'=>'shows','action'=>'view',$show['Show']['id']),array('escape'=>false)); ?>
                        
                        </td>
                        <td  width="100" class="normalfont" style="text-align:left"><?php echo $show['Show']['show_dt'];   ?><br />
<?php echo $show['Show']['show_hours'];   ?></td>
                      <?php  	$theComponent = new commonComponent(new ComponentCollection());
							$location_city = $theComponent->getLocationInfo('location_city',$show['Show']['location_id']);
							$location_state = $theComponent->getLocationInfo('location_state',$show['Show']['location_id']);
							$location_address = $theComponent->getLocationInfo('site_address',$show['Show']['location_id']);
				?>
                        <td  width="120" class="normalfont" style="text-align:left"><strong><a href="http://maps.google.com/maps?saddr=start&daddr=<?php echo  $location_address.','.$location_city.'&nbsp;'.$location_state; ?>" target="_blank"><?php echo $location_city;  ?></a></strong><br />
                            <?php echo $location_address;  ?></td>
                        <td  width="100" class="normalfont" style="text-align:left">US Citizenship</td>
                        
                      </tr>
                    </table></td>
                </tr>
                <?php } ?>
                
            
             
              </table><br />

          <!--   	<div class="man_resume_footer">
             <a href="event-registration-user.html"> <input name="" src="images/register_event.jpg" type="image" /></a>
              </div>-->
 
            </div>
          </div>
        </div>
      </div>
      
<div class="rt_col_inner">
          <?php echo $this->element('static_left_job_panel', array('cache' => true)); ?>
               <?php echo $this->element('left_upcoming_events', array('cache' => true)); ?>
      </div>


      <div class="clear"></div>
       <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>