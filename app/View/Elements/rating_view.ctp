<?php 
$rating = isset($rating) ? $rating : ''; 
switch($rating) {
  case 4 :
    echo $html->image('smile-simily.png',array('alt'=>'Suitable','title'=>'Suitable')); //Suitable
	break;
  case 3 :
    echo $html->image('straight-simily.png',array('alt'=>'May be','title'=>'May be')); //May be
	break;
  case 2 :
    echo $html->image('down-simily.png',array('alt'=>'No','title'=>'No')); //No
	break;
  default :
    echo $html->image('white-simily.png',array('alt'=>'New','title'=>'New')); //New
	break;		
}
?>