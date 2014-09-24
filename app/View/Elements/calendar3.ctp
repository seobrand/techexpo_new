<?php  
     
      define('CALENDAR_DATE_FORMAT','dd-mm-yyyy');
      $defaultDate  = isset($defaultDate) ? $defaultDate : '';
	  $dateN = isset($dateName) ? $dateName : $dateId;
	  $label = isset($label) ? $label : false;
	  $style = isset($style) ? $style : 'width:195px;height:18px;';
	  echo $this->Form->input($dateN, array('label'=>$label,'type'=>'text','id'=>$dateId,'div'=>false,'value'=>$defaultDate,'style'=>$style,'class'=>'input_01','onblur'=>'convert_date1()','error'=>false));
		?>
		<?php echo $this->Html->image('calendar_icon.jpg',array('alt'=>'Cal','align'=>'absmiddle','onclick'=>"displayCalendar(document.getElementById('".$dateId."'),'".CALENDAR_DATE_FORMAT."',this)",'div'=>false));		
		?>
<script type="text/javascript">
function convert_date1() {
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