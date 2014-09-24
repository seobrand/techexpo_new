<?php  	echo $this->Html->script('front_js/chat/jquery-1.4.2.min.js');
//echo $this->Html->script('front_js/chat/jquery-ui-1.8.5.custom.min.js');
echo $this->Html->script('front_js/chat/jquery.scrollTo-min.js');
//echo $this->Html->script('front_js/chat/jquery.sort.js');
echo $this->Html->script('front_js/chat/chatfunctions2.js');
//pr($this->Session->read('Auth.Clients.id'));

 ?>
 <script type="text/javascript">
$(document).ready(function(){
			
			
			<?php  $sessroom_id = $this->Session->read('Chat.room_id');
			 if(isset($sessroom_id) && !empty($sessroom_id) ){ ?>
			
					$('#content').html(' ');
					var room_id = <?php echo $this->Session->read('Chat.room_id'); ?>;
					$.ajax({
					  type: "POST",
					  url: "<?php echo $this->webroot; ?>chats/enteruser",
					  data: { room_id: room_id },
					  success: function(data) {
						  if(data)
						 $('#content').append(data);
						 
						  }
						})
 				   
			
			<?php } ?>
			
				$("#groupchat_id").change(function(){
					$('#content').html(' ');
					var room_id =$("#groupchat_id").val();
					$.ajax({
					  type: "POST",
					  url: "<?php echo $this->webroot; ?>chats/enteruser",
					  data: { room_id: room_id },
					  success: function(data) {
						  if(data)
						 $('#content').append(data);
						  }
						})
 				   });
				
				});
				
			
				
		</script> 
       
  <div class="topic_list">
          <div class="topic_panel">
            <ul>
              <li>
                <div class="topic_title">
                <div id="roomlistdrodown">
                 <?php   $chatRoomList = $common->chatRoomList();
					 echo $this->Form->input('room_id',array('label'=>'','options'=>$chatRoomList,'selected'=>$sessroom_id,'type'=>'select','empty'=>'Select Chat Group','error'=>false,'div'=>false,'label'=>false,'id'=>'groupchat_id','style'=>'width:225px;'));
					   ?></div>
            <!--    </div>
                <div class="joinBtn"><a href=""></a></div>-->
              </li>
         <!--     <li>
                <div class="topic_title">Software Engineer</div>
                <div class="joinBtn"><a href=""></a></div>
              </li>
              <li>
                <div class="topic_title">Core Java</div>
                <div class="joinBtn"><a href=""></a></div>
              </li>-->
            </ul>
        <!--    <div class="createNew_btn">
              <img src="<?php echo $this->webroot;?>img/images/create_new.jpg" />
            </div>-->
          </div>
        </div>
        <div class="line"></div>
       <!--  <p class="dis_title">Core Java</p>-->
        <div class="chat_list" id="content" style="margin:7px 0 10px 35px;height:200px;overflow:scroll;width:300px;">
         
     
        </div>
         <div class="chat_field">
         <form action="#" id="form_send" method="post">
         <input type="hidden" name="user_id" id="user_id" value="<?php  echo $this->Session->read('Auth.Clients.id'); ?>" /> 
          <!--   <input type="text" size="10" maxlength="255" class="chat_fld" name="message" id="message" /> -->
             <textarea maxlength="255" class="chat_fld" name="message" id="message"></textarea>
             <button type="submit" value="Send">Send</button>
            </form>
          </div>
      </div>
    