<div id="wrapper">
  <?php 
	if($this->Session->read('Auth.Client.Candidate.id')!='')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
	}
	
	if($this->Session->read('Auth.Client.employerContact.id')!='')
	{
		 echo $this->element('employer_tabs');
	}
 ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Marketing Partners</h1>
          <div class="content">
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list2">
              
              	<?php foreach($exhibitorLists as $exhibitorList){  ?>
                
                <li>
                  <label> 
                
                  <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'marketing_exhibitors/'.$exhibitorList['MarketingExhibitor']['image'];?>&maxw=186&maxh=140" />
                  </label>
                  <div class="form_rt_col2">
                  <strong><?php  echo $exhibitorList['MarketingExhibitor']['title'] ?></strong><br />
               
                    <?php  echo $exhibitorList['MarketingExhibitor']['description'] ?>
                  </div>
                </li>
                
                <?php } ?>
              
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    <div class="clear"></div>
    <?php echo $this->element('partners'); //$this->element('scroll_panel');?>
    
  </div>
</div>
