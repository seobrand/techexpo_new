<div class="side_box">
  <div class="news_head">Testimonials</div>
  <div class="side_mid">
    <div class="side_bottom padding_1px">
      <div class="qunt_main">
        <div class="qunt_box">
          <ul id="menu1" class="menu1">
            <li ><a href="#jobseekers"><span>Job Seekers</span></a></li>
            <li class="active"><a href="#employers"><span>Employers</span></a></li>
          </ul>
          <div class="clear"></div>
          <div class="qunt_in_bx">
            <div id="jobseekers" class="content_products">
              <ul class="news_list">
                <?php $count_job = count($testimonials_job); $i ='1'; 
					 foreach($testimonials_job as $testi_job ){ ?>
                <li <?php if($count_job==$i) echo "class='last'"; ?> >
                  <?php
				  
				$user_id=$testi_job['Testimonial']['user_id'];
				if($user_id){
				 $profileImage=$common->get_candidate_profileimage($user_id);
				 }else{
				$profileImage='';
				}
				  
				  
				  if($profileImage && file_exists('upload/150x80_'.$profileImage)){
				  
				 //  if(file_exists(TESTIMONIAL.$testi_job['Testimonial']['logo_file'])) {
					 // echo $this->Html->image('testimonial/resized_'.$testi_job['Testimonial']['logo_file']);
					 ?>
                     
                <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$profileImage;?>&maxw=59&maxh=100"/>   
                     
             
                  <?php }
				  
				  else if(!empty($testi_job['Testimonial']['logo_file']) && file_exists('img/testimonial/'.$testi_job['Testimonial']['logo_file'])){ ?>
                            
							  <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'img/testimonial/'.$testi_job['Testimonial']['logo_file'];?>&maxw=59&maxh=100"   alt=""/>  <?php
						}
					  else
					  echo $this->Html->image('testimonial/no_image.jpg');
					   ?>
                  <div class="special_desc">
                  <span style="font-weight:normal;">
				    <?php 
				   	echo $this->Text->truncate(
							$testi_job['Testimonial']['text'],
							80,
							array(
								'ellipsis' => '...',
								'exact' => false
							)
						);
				     ?></span> <br/>
				  <strong><?php echo $testi_job['Testimonial']['name'];  ?> <?php echo $this->Html->link('Click Here',array('controller'=>'testimonials','action'=>'index','c'));?></strong></div>
                  <div class="clear"></div>
                </li>
                <?php $i++; } ?>
              </ul>
              <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <div id="employers" class="content_products">
              <ul class="news_list">
                <?php
					$count_emp = count($testimonials_emp); $i ='1';
					 foreach($testimonials_emp as $testi_emp ){ ?>
                <li <?php if($count_job==$i) echo "class='last'"; ?> >
                  <?php
				  
				 
				  $user_id=$testi_emp['Testimonial']['user_id'];
				if($user_id){
				 $profileImage=$common->get_employeer_profileimage($user_id);
				 }else{
				$profileImage='';
				}
				  
				  
				  
				  
				   if($profileImage && file_exists('upload/150x80_'.$profileImage))
					{
					  		?>
                            <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$profileImage;?>&maxw=59&maxh=100"  />
                            <?php
						}
						else if(!empty($testi_emp['Testimonial']['logo_file']) && file_exists('img/testimonial/'.$testi_emp['Testimonial']['logo_file'])){ ?>
                            
							  <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'img/testimonial/'.$testi_emp['Testimonial']['logo_file'];?>&maxw=59&maxh=100"   alt=""/>  <?php
						}
					  	else
						{
					  		echo $this->Html->image('testimonial/no_image.jpg');
						}
					   ?>
                  <div class="special_desc">
                  <span style="font-weight:normal;">
				   <?php 
				   	echo $this->Text->truncate(
							$testi_emp['Testimonial']['text'],
							80,
							array(
								'ellipsis' => '...',
								'exact' => false
							)
						);
				     ?></span> <br/>
				  <strong><?php echo $testi_emp['Testimonial']['name'];  ?> <?php echo $this->Html->link('Click Here',array('controller'=>'testimonials','action'=>''));?></strong></div>
                  <div class="clear"></div>
                </li>
                <?php $i++; } ?>
              </ul>
              <div class="clear"></div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
