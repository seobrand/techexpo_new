<?php  
      $defaultDate  = isset($defaultDate) ? $defaultDate : '01-01-1995';
	  $dateN = isset($dateName) ? $dateName : $dateId;
	  $label = isset($label) ? $label : false;
	  $style = isset($style) ? $style : 'width:195px;height:18px;color:white;';
	  echo $form->input($dateN, array('label'=>$label,'id'=>$dateId,'div'=>false,'value'=>$defaultDate,'style'=>$style,'class'=>'input_01','onblur'=>'convert_date()'));
		?>
		<?php echo $html->image('calendar_icon.jpg',array('alt'=>'Cal','align'=>'absmiddle','onclick'=>"displayCalendar(document.getElementById('".$dateId."'),'".CALENDAR_DATE_FORMAT."',this)",'div'=>false,'onmouseout'=>'cleanyear()'));		
		?>
<script type="text/javascript">

function cleanyear() {
	if(document.getElementById('<?php echo $dateId;?>').value=='01-01-1995') {
		document.getElementById('<?php echo $dateId;?>').value = '';
		document.getElementById('<?php echo $dateId;?>').style.color = 'black';
	}
}
function convert_date() {
var dvalue = document.getElementById('<?php echo $dateId;?>').value;
var dateStr3	= dvalue.split('.');
if(dateStr3.length != 1) {
	//alert(dateStr3[2]);
var conv = dateStr3[0]+'-'+dateStr3[1]+'-'+dateStr3[2];
} 
else {
	var conv = dvalue;
}
var dateStr2	= conv.split('/');
if(dateStr2.length != 1) {
	//alert('abc');
var conv1 = dateStr2[0]+'-'+dateStr2[1]+'-'+dateStr2[2];
} 
else {
	var	conv1 = conv;
}
document.getElementById('<?php echo $dateId;?>').value = conv1;
}
</script>