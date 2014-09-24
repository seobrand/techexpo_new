
<?php
echo $this->Form->input('JobPosting.skill'.$number,array('type'=>'select','options'=>$skills,'label'=>false,'div'=>false,
														'empty'=>'Please select skill','onChange'=>'addkeyword(this.value,this.name,'.$number.')','onChange'=>'addkeyword(this.value,this.name,'.$number.')'));
?>