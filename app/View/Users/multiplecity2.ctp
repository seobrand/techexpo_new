<div class="checkbox_div checkbox_large_div"  style="height:100px;width:275px;">
  <div class="checkbox_list" style="height:100px;width:262px;">
    <?php 
							 echo $this->Form->input('location_city',array('type'=>'select','multiple'=>'checkbox','options'=>$cityList,'label'=>false,'div'=>false,'hiddenField' => false)); 
						   ?>
  </div>
</div>
