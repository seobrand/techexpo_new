<?php  
      $defaultDate  = (isset($defaultDate) && $defaultDate !='') ? $defaultDate : 'DD-MM-YYYY';
	  $dateN = isset($dateName) ? $dateName : $dateId;
	  $label = isset($label) ? $label : false;
	  $style = isset($style) ? $style : 'width:220px;height:13px;';
	  
	  //echo $form->input($dateN, array('label'=>$label,'id'=>$dateId,'div'=>false,'value'=>$defaultDate,'style'=>$style,'class'=>'input_01','onblur'=>"convertString('$dateId',this.value)"));
	  echo $form->input($dateN, array('label'=>$label,'id'=>$dateId,'div'=>false,'value'=>$defaultDate,'style'=>$style,'class'=>'input_01','onblur'=>'convert_date()','onclick'=>'if(this.value=="DD-MM-YYYY") {this.value="";}'));
		?>
		<?php echo $html->image('calendar_icon.jpg',array('alt'=>'Cal','align'=>'absmiddle','onclick'=>"displayCalendar(document.getElementById('".$dateId."'),'".CALENDAR_DATE_FORMAT."',this)",'div'=>false,'onmouseover'=>'delete_date();'));		
?>
<script type="text/javascript">
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
function delete_date() {
	if(document.getElementById('<?php echo $dateId;?>').value.length!=10) {
		document.getElementById('<?php echo $dateId;?>').value='';
	}
}
</script>