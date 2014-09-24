<div class="rt_col">
      <?php if($this->Session->read('Auth.Client.User.id')==''){ ?>
      <div class="side_box">
        <div class="side_head">Log In</div>   
        <div class="side_mid">
          <div class="side_bottom"> <?php echo $this->Form->create('User',array('controller'=>'users','action'=>'login')); ?>
            <ul class="login_panel">
              <li style="color:#FF0000"> <?php echo $this->Session->flash(); ?> </li>
              <li> <?php echo $this->Form->input('User.username',array('class'=>'login_txt','type'=>'text','placeholder'=>'User Name','div'=>'','label'=>''));?> </li>
              <li>
                <?php  echo $this->Form->input('User.password',array('class'=>'login_txt','type'=>'password','placeholder'=>'Password','div'=>'','label'=>'')); ?>
              </li>
              <li>
                <?php 
                	 echo $this->Form->input('User.LOGIN',array('type'=>'hidden','value'=>'LOGIN'));
               		 echo $this->Form->submit('images/submit.jpg',array('style'=>'float:right;margin-right:40px;'));
                 ?>
                <label>
                <?php 
				 echo $this->Form->input('User.Login',array('type'=>'hidden','value'=>'LOGIN'));
				 
				 ?>
                <!--	 <a href="javascript:void(0);" onclick="showRegisterPopup()">Register Now</a>  /-->
                <?php echo $this->Html->link('Forgot Password',array('controller'=>'users','action'=>'forgotpassword'));?></label>
                <div class="clear"></div>
              </li>
            </ul>
            <?php echo  $this->Form->end(); ?></div>
        </div>
      </div>
      <?php } ?>
      <div class="side_box">
        <div class="side_head">Featured Employer:</div>
        <div class="side_mid">
          <div class="side_bottom">
            <div class="featured_logo" >
              <?php $banners = $common->showBanner();?>
              <?php if(count($banners)>0){?>
              <?php $location = "http://".$_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI'];?>
              <?php $common->addBannerPerformance($banners[0]['Banner']['id'],$location); ?>
              <?php // echo $this->Html->link($this->Html->image('../Banner/'.$banners[0]['Banner']['filename'],array('width'=>'321px','height'=>'76px','title'=>$banners[0]['Banner']['name'],'alt'=>$banners[0]['Banner']['alt'])), array('controller'=>'users', 'action' => 'banneronclick',$banners[0]['Banner']['id']), array('escape' => false, 'target'=>'_blank')); ?>
              <a href="users/banneronclick/<?php echo $banners[0]['Banner']['id']; ?>" target="_blank"> <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$banners[0]['Banner']['filename'];?>&maxw=321&maxh=105"  /> </a>
              <?php }else{?>
              <?php echo $this->Html->image('no_logo_thumb.jpg',array('title'=>'No Banner Available')); ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
        <?php $adBanner = $common->adBanner(1);
		if(!empty( $adBanner)) {
		?>
       <div class="side_box">
      
        <?php if($adBanner['Banner']['href']!=""){ ?>
          <a href="<?php echo $adBanner['Banner']['href']; ?>" <?php if($adBanner['Banner']['link_type']=='external'){?>target="_blank"<?php }?>><img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$adBanner['Banner']['filename'];?>&maxw=333&maxh=200"  /> </a>
        <?php }else{?>
        	<img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$adBanner['Banner']['filename'];?>&maxw=333&maxh=200"  /> 
        <?php } ?>  
      </div>
      <?php } ?>
   
      <div class="side_box">
      <div class="side_head">Stay Informed</div>
        <div class="white_head"></div>
        <div class="white_mid1" style="height:125px!important;">
          <div class="white_bottom1">
            <div class="newsletter_header" style="border-bottom:20px #E6F0FB solid"> <?php echo $this->Html->image('images/email_icon.jpg'); ?>
              <h4>Join our mailing list</h4>
              <p>Sign up and be informed for upcoming events. </p>
              <div class="clear"></div>
              <?php echo $this->Form->create('User',array('controller'=>'users','action'=>'listSignup','name'=>'Login')); ?>
              <ul class="newsletter_panel">
                <li>
                  <input name="data[MASSEMAIL][list_email]" type="text" value="Enter your email address" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Enter your email address':this.value;" class="newsletter_txt" id='newLatter' />
                   <input type="text" value="" class="extrafields" name="newslatter_status"  />
                </li>
                <li> <?php echo $this->Form->submit('images/newsletter_button.jpg',array('style'=>'float:right','class'=>'newsletter_submit','onclick'=>'return checkvalidation()'));
				 echo $this->Form->input('MASSEMAIL.NEWSLETTER',array('type'=>'hidden','value'=>'NEWSLETTER'));
				?> </li>
              </ul>
              <?php echo  $this->Form->end(); ?>
              <div class="clear"></div>
            </div>
            
            
           
          </div>
        </div>
      </div>
      
      <div class="side_box">
        <div class="side_head">Tell A Friend</div>
        
        <div class="newsletter_header bordernone" style="padding-top:10px !important">
            
            <?php echo $this->Html->link($this->Html->image('images/emai2_icon.jpg',array('class'=>'newsletter_submit')), array('controller'=>'users','action'=>'tellaFriend'),array('class'=>'ajax','escape'=>false)); ?> 
            
              <h4 class="newsletter_subheading" style="padding-top:0px !important"> <?php echo $this->Html->link("Tell a Friend About Us", array('controller'=>'users','action'=>'tellaFriend'),array('class'=>'ajax','style'=>'color:#007AFF','escape'=>false)); ?>
              </h4>
               <p>Alert your friends, family and colleagues about TechExpo.</p>
              <div class="clear"></div>
              <!--<ul class="newsletter_panel" style="float:right;margin-right:15px;">
                <li> <?php echo $this->Html->link($this->Html->image("images/clickhere.gif",array('class'=>'newsletter_submit')), array('controller'=>'users','action'=>'tellaFriend'),array('class'=>'ajax','escape'=>false)); ?> </li>
              </ul>-->
              <div class="clear"></div>
            </div>
        
      </div>
      
      <div class="side_box">
        <div class="side_head">LinkedIn</div>
        
        <div class="sidenews_front_mid" style="width:333px!important;vertical-align:middle;text-align:center;padding:25px 0 25px 0;">
           <?php echo $this->Html->link($this->Html->image('images/join-group.jpg'),'http://www.linkedin.com/groups?gid=113669',array('escape'=>false,'target'=>'_blank'));?>
        </div>
        
      </div>
      
      <?php echo $this->element('testimonials', array('cache' => true)); ?>
      <!-- -------------------------- Linked in -------------------------------------------------->
     	
        
       
      
      <div class="side_box">
        <div class="side_head">Suggestions/Comments</div>
        
        <div class="newsletter_header bordernone" style="padding-top:10px !important">
            
            <?php echo $this->Html->link($this->Html->image('images/emai2_icon.jpg',array('class'=>'newsletter_submit')), array('controller'=>'users','action'=>'suggestion'),array('class'=>'ajax','escape'=>false)); ?> 
            
              <h4 class="newsletter_subheading" style="padding-top:0px !important"><?php echo $this->Html->link("Contact the President/CEO", array('controller'=>'users','action'=>'suggestion'),array('class'=>'ajax','style'=>'color:#007AFF','escape'=>false)); ?>
              </h4>
               <p class="home_suggestion">Send your suggestions or comments to Bradford Rand, President/CEO.</p>
              <div class="clear"></div>
          
              <div class="clear"></div>
            </div>
        
      </div>
     
      <!--<div class="side_box">
        <div class="side_head">Discussions</div>
        <?php if($this->Session->read('Auth.Client.User.id')!='' or $this->Session->read('Auth.Client.employer.id')!=''){ ?>
        <div class="sidenews_front_mid discussion_board" style="width:333px!important;" id="discussion_board">
          <div class="sidenews_bottom discussion_board" style="width:333px!important;" >
            <div class="topic_list">
              <div class="topic_panel">
                <ul>
                  <li style="width:257px!important;">
                    <div class="topic_front_title">
                    <div id="roomlistdrodown">
                      <?php $chatRoomList = $common->chatRoomList();
				 		if($this->Session->read('Auth.Client.User.id')!='')
					 	echo $this->Form->input('room_id',array('label'=>'','options'=>$chatRoomList,'selected'=>$sessroom_id,'type'=>'select','empty'=>'Select Chat Group','error'=>false,'div'=>false,'label'=>false,'id'=>'groupchat_id','style'=>'width:250px;'));
					   ?>
                    </div>
                       </div> 
                       
                  </li>
                </ul>
                
              </div>
            </div>
            <div id="content1">
              <div class="line"></div>
              <div class="chat_list" id="content" style="margin:7px 0 10px 12px;height:224px;overflow:scroll;width:277px;"> </div>
              <div class="chat_field">
                <form action="#" id="form_send" method="post">
                  <input type="hidden" name="user_id" id="user_id" value="<?php  echo $this->Session->read('Auth.Clients.id'); ?>" />
                  
                  <?php if($this->Session->read('Auth.Client.User.id')!='' or $this->Session->read('Auth.Client.employer.id')!=''){ ?>
                  <input type="text" size="10" width="230" maxlength="255" class="chat_front_field" name="message" id="message" />
                  <?php echo $this->Form->submit('images/send.jpg');
			  } ?>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php }else{ ?>
        <div class="sidenews_front_mid discussion_board" style="width:333px!important;height:100px!important;padding:40px 0 0 0px;text-align:center;"> <a style="text-align:center;" href="javascript:void(0);" onclick="showRegisterPopup()"> <?php echo $this->Html->image("images/register_btn.jpg",array('style'=>'')); ?> </a> </div>
        <?php } ?>
      </div>-->
      <!-- -------------------------- chat discussion -------------------------------------------------->
    </div>