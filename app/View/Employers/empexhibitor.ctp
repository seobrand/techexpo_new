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
          <h1 class="bluecolor">Exhibitor Resources</h1>
          <div class="content">
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list">
              
              	<?php foreach($exhibitorLists as $exhibitorList){  ?>
                
                <li>
                  <label> <strong><?php  echo $exhibitorList['Exhibitor']['title'] ?></strong><br />
                  <br />
                 <img src="<?php echo FULL_BASE_URL.router::url('/',false).'exhibitors/'.$exhibitorList['Exhibitor']['image']; ?>"  />
                  </label>
                  <div class="form_rt_col">
                    <?php  echo $exhibitorList['Exhibitor']['description'] ?>
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
