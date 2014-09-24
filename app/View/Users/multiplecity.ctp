<div class="checkbox_div checkbox_large_div"  style="height:100px;width:100%; padding:0px;">
  <div class="checkbox_list checkbox_list_home" style="height:100px;width:100%;">
    <?php 
							 echo $this->Form->input('location_city',array('type'=>'select','multiple'=>'checkbox','options'=>$cityList,'label'=>false,'div'=>false,'hiddenField' => false)); 
						   ?>
  </div>
</div>
