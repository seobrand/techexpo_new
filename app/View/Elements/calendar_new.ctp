<?php  
      $defaultDate  = isset($defaultDate) ? $defaultDate : '';
	  $dateN = isset($dateName) ? $dateName : $dateId;
	  $label = isset($label) ? $label : false;
	  $style = isset($style) ? $style : 'width:225px;height:13px; margin-right:2px;';
	  echo $form->input($dateN, array('label'=>$label,'id'=>$dateId,'div'=>false,'value'=>$defaultDate,'style'=>$style,'class'=>'input_t01','onblur'=>"convertString('$dateId',this.value)",'div'=>false));
		 echo $html->image('calendar_icon.jpg',array('alt'=>'Cal','align'=>'absmiddle','onclick'=>"NewCssCal('".$dateId."','ddmmmyyyy')",'div'=>false));		
?>