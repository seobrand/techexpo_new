<?php
  $keywordArray['addNewSkill']='Add New Skill';
	$keywordArray=$keywordArray + $common->getKeywordList();
echo $this->Form->input('ResumeSkill.'.$number.'.skill_id',array('type'=>'select','empty'=>'-Select Keyword-','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>'','onChange'=>'addkeyword(this.value,this.name,'.$number.')'));
?>