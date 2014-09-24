<script type="text/javascript">

$(document).ready(function() {





// $(".checkbox input:checkbox").attr("disabled", true);
 });
   
function disabledchk()
{
	
	var checked = $("#ChkIsbsTxn").attr("checked");
	
	if(checked){
	   $("input:checkbox[id^='RegistrationShowId']").attr("disabled", true);
	}else{
		$("input:checkbox[id^='RegistrationShowId']").attr("disabled", false);
	}
	
}


</script> <div id="wrapper">
  <div class="inner_banner">
    <?php $bannerDt = $common->getbannerImage('3');   ?>
    <div class="static_inner_banner">
      <div class="static_title_bar">
        <p><?php echo $bannerDt['OtherBanner']['name']; ?></p>
      </div>
      <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  /> </div>
  </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Event Registration </h1>
          <div class="content">
            <div class="tab_panel_41 tab_panel_43">
              <ul>
                <li class="firstTab"><a> Create <br />New Profile
                 </a></li>
                <li class="secondTab"><a>Post <br />
                  Your Resume</a></li>
                <li class="thirdTab"><a>Register <br />
                  For an Event</a></li>
                <li class="fourthTab"><a>Thank You</a></li>
              </ul>
              <div class="clear"></div>
            </div>
            <div class="gray_full_top"></div>
            <?php echo $this->Form->create('Show',array('action'=>'eventregistration', 'enctype' => 'multipart/form-data')); ?>
            <div class="gray_full_mid">
             <label>Select which TECHEXPO event you
                  would like to pre-register for:</label> <br/><br/>
              <ul class="form_list manage_resume_form">
                <li>
                 
                  <div class="form_rt_col1">
                    <div >
                      <p >
                      <div class="checkbox_div checkbox_large_div"  style="height:100px;width:500px;">
                        <div class="checkbox_list" style="height:100px">
                          <?php 
							 echo $this->Form->input('Registration.show_id',array('type'=>'select','multiple'=>'checkbox','options'=>$showListArray,'label'=>false,'div'=>false,'hiddenField' => false)); 
						   ?>
                        </div>
                      </div>
                      <?php //  echo $this->Registration->rror('show_id');   ?> 
                      <?php 
						// echo $this->Form->input('Registration.show_id',array('type'=>'select','multiple'=>'multiple','options'=>$showListArray,'empty'=>'- Select Event -','label'=>false,'div'=>false,'style'=>'padding-bottom:5px;')); 
					   ?>
                      </p>
                    </div>
                  </div>
                </li>
                <li>
                    <label style="width:252px !important;">How did you hear about this event? </label>
                    <div class="form_rt_col1" style="width:268px !important;">
                      <div class="even_reg_dropdown15">
                                                
                         <?php 
                        echo $this->Form->input('Registration.hear_about',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'padding-bottom:5px;'));
                        ?>
                      </div>
                      </div>
                  </li>
                <li>
                  <h2 class="mana_subheading blueralternative" style="margin-left:100px;">
                    <input name="ChkIsbsTxn" id="ChkIsbsTxn" onclick="disabledchk();" type="checkbox" value="true" />
                    &nbsp;&nbsp;I would  like to register at a later date</h2> 
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Registration.Submit',array('type'=>'hidden','div'=>false,'label'=>false,'value'=>'Register')); ?> <?php echo $this->Form->input('Registration.candidate_id',array('type'=>'hidden','div'=>false,'label'=>false)); ?> <?php echo $this->Form->submit('images/continue.jpg');?> </div>
                </li>
              </ul>
            </div>
            <?php echo $this->Form->end();?> </div>
        </div>
      </div>
    </div>
    <div class="rt_col_inner">
       <?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    </div>
    <div class="clear"></div>
     <?php echo $this->element('partners', array('cache' => true)); ?> 
  </div>
</div>