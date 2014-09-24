<?php //pr($this->Session->read('Auth')); ?>
<div id="wrapper">
  <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Manage Account</h1>
          <div class="content">
            <?php /*?><div class="jobseeker_info">
              <p><strong><?php echo $this->Session->read('Auth.Client.employerContact.contact_name');?>'s Account Management Center </strong><br />
                <?php //echo date("l, d/m/Y - h:i A T");?>
				<?php 
					$date = new DateTime("@".time());
					$date->setTimezone(new DateTimeZone('UTC'));   
					echo $date->format("l, d/m/Y - h:i A T");  // Pacific time</p>
				?></p>
            </div><?php */?>
            <h2 class="mana_subheading"><?php echo $this->Html->link("Edit your company's profile",array('controller'=>'employers','action'=>'editprofile'));?></h2>
            <h2 class="mana_subheading"><?php echo $this->Html->link("Edit your personal contact info and your username and password",array('controller'=>'employers','action'=>'editpersonalinfo'));?></h2>
            <br />
            <p>Your account is set up for access to the following resume databases:</p>
            <br />
            <p><strong>TECHEXPO event databases: </strong>
            
            <?php if(count($selected_db) > 0 ){ ?>
			<a class="managedblins" href="<?php echo $this->Form->url(array('controller'=>'folders','action'=>'searchRegCandidate')); ?>"  >	
             <?php  
                foreach($selected_db as $selected_db)
                {
                    echo '<br/>'.$selected_db['ResumeSetRule']['short_desc'];
                }
			?>	
			</a>	
			<?			
			}
			else 
			{
			echo " no databases assigned";
			}
			?>
           
          <!--   Customized databases: no databases assigned--> </p>
            <br />
            <?php /*?><p><span class="instruction">Resume databases are available for each quarter of the year for each of the following territories: DC, VA, MD, CA and Soon Colorado! For more information or to order additional databases, e-mail <a href="mailto:BRand@techexpoUSA.com">BRand@techexpoUSA.com</a> or call us at 212.655.4505 ext 255.</span></p>
            <br />
            <p><strong><span class="instruction">Have you tried our CUSTOMIZED resume databases yet? E-mail <a href="mailto:jobs@techexpoUSA.com">jobs@techexpoUSA.com</a> or call us at 212.655.4505 ext 255 to find out how to get only resumes YOU want.</span></strong></p><?php */?>
            
            <p>
            To purchase additional databases, or to have a customized resume database created for you,<br/>
             call us at 212.655.4505 ext. 223 or email <a href="mailto:BRand@TechExpoUSA.com" > BRand@TechExpoUSA.com </a> .
            </p>
            
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?>
  </div>
</div>
