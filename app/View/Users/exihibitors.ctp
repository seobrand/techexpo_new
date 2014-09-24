<script type="text/javascript">
function viewLogo()
{
if(document.getElementById('EXElogo').style.display=='none') {
	
	
	
	document.getElementById('viewText').style.display='block'; 
	document.getElementById('viewlogo').style.display='none'; 
	
	document.getElementById('links').style.display='none'; 
	document.getElementById('EXElogo').style.display='block'; 
	}else
	{
	
	document.getElementById('viewlogo').style.display='block'; 
	document.getElementById('viewText').style.display='none'; 
	
	document.getElementById('links').style.display='block'; 
	document.getElementById('EXElogo').style.display='none'; 
	}
	
	
}

$(function(){
	
	$( ".event_partner_list li div:contains('www.baltimorejobsolution.com')" ).css({'word-wrap':'break-word','display':'table-caption','margin-top':'32px'});
	$( ".event_partner_list li div:contains('PriceWaterhouseCoopers')" ).css({'word-wrap':'break-word','display':'table-caption','margin-top':'32px'});
	$( ".event_partner_list li div:contains('PwC - PricewaterhouseCoopers')" ).css({'word-wrap':'break-word','display':'table-caption','margin-top':'32px'});
	$( ".event_partner_list li div:contains('AeroIndustryJobs.com')" ).css({'word-wrap':'break-word','display':'table-caption','margin-top':'32px'});
	
	});

</script>

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
  <div class="inner_banner">
  
  <?php // echo $this->Html->image('images/exhibitors.jpg');?>
       <?php $bannerDt = $common->getbannerImage('7');   ?>
 <div class="static_inner_banner">
   <div class="static_title_bar">
  <p><?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?></p>
  </div>
  <?php // echo $this->Html->image("images/banner_job.jpg");  ?>
  <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  />
  </div>
  
  
    <?php ?>
  </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">TECHEXPO CLIENTS</h1>
          <div class="content">
          <div>
            <div style="float:right">
            <?php echo $this->Html->image('images/view_logo_btn.jpg',array('onClick'=>'viewLogo()','id'=>'viewlogo')); ?> 
             <?php echo $this->Html->image('images/viewasLIst_btn.jpg',array('onClick'=>'viewLogo()','id'=>'viewText','style'=>'display:none;')); ?> 
             </div>
             </div>
            <h2 class="mana_subheading">You may also visit our <?php echo $this->Html->link("TESTIMONIALS PAGE",array('controller'=>'testimonials','action'=>'index')); ?> </h2>
            <br/><br/>
            <div id="links" >
              <div class="equal_col_new">
                <ul class="list_new">
                
                  <?php foreach($exhibitor as $exhibitorList){?>
                  <li>
				   	<a href=" <?php echo $this->Html->url(array(    "controller" => "Jobseeker",    "action" => "candidates/employeDetail",$exhibitorList['ShowEmployer']['employerID']));?>" target="_blank" >
				  <?php echo $exhibitorList['Employer']['employer_name'];?>
                  </a>
                  </li>
                  <?php }?>
                </ul>
              </div>
            </div>
            <div id="EXElogo" style="display:none" >
              <ul class="event_partner_list inner_event">
                <?php  foreach($exhibitor as $exhibitorList){?>
                <?php if($exhibitorList['Employer']['logo_file']!=''){?>
                <li>
				<?php // echo $this->Html->image('../upload/150x80_'.$exhibitorList['Employer']['logo_file'],array('width'=>'166px','height'=>'102px','title'=>$exhibitorList['Employer']['employer_name'])); ?>
                <div style="height:102px;display:table-cell;  vertical-align:middle;">
              <div style="text-align:center;width:166px;">
             
              	<a href=" <?php echo $this->Html->url(array("controller" => "Jobseeker",    "action" => "candidates/employeDetail",$exhibitorList['ShowEmployer']['employerID']));?>" target="_blank" >
                 <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$exhibitorList['Employer']['logo_file'];?>&maxw=166&maxh=102" title="<?php echo $exhibitorList['Employer']['employer_name']; ?>" />
                 </a>
                </div></div>
                </li>
                <?php }else{ ?>
                <li>	<a href=" <?php echo $this->Html->url(array("controller" => "Jobseeker",    "action" => "candidates/employeDetail",$exhibitorList['ShowEmployer']['employerID']));?>" target="_blank" >
				<?php // echo $this->Html->image('no_logo_thumb.jpg',array('title'=>$exhibitorList['Employer']['employer_name'])); ?> 
                 <div class="exihibitors_noimage" ><?php echo $this->Text->truncate($exhibitorList['Employer']['employer_name'], 65);    ?></div>
                 </a></li>
                <?php } ?>
                <?php }?>
              </ul>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="rt_col_inner">
      <?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
