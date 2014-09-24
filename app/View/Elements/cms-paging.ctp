<?php //echo $record; ?>
<?php $limit = (isset($this->request->query['limit']) && $this->request->query['limit']!='') ? $this->request->query['limit'] : 15; ?>
<table border="0" cellpadding="2" cellspacing="2" align="center"  class="pagingview" width="100%">
  <tr> 
  	<td width="25%" align="left">
    	<?php echo '&nbsp;&nbsp;Page&nbsp;'.$this->Paginator->prev($this->Html->image('previous.gif',array('alt'=>'Previous','title'=>'Previous','align'=>'absmiddle')), array('class' => 'disabled','escape'=>false));?>		
	<?php echo $this->Form->input('name',array('label'=>'','div'=>false,'value'=>$this->Paginator->counter(array('format' => '%page%')),'style'=>'width:23px;','div'=>false,'onkeydown'=>'javascript:checkEnter(this.value,event)','id'=>'page1','readonly'=>'readonly'));?>		
    <?php echo $this->Paginator->next($this->Html->image('next.gif',array('alt'=>'Next','title'=>'Next','align'=>'absmiddle')), array('class' => 'disabled','escape'=>false));?>
	<?php echo 'of '.$this->Paginator->counter(array('format' => '%pages% ')).' pages'; ?>
	</td>
	<td width="50%" align="center">
	<?php echo $this->Paginator->counter(array('format' =>'Total %count% records.&nbsp;&nbsp;')); ?>
	<?php 
	if(isset($active_record)) {
	echo 'Active&nbsp;'.$active_record.'&nbsp;&nbsp;&nbsp;Inactive&nbsp;'.$inactive_record; 
	}?>
	</td>
	<td width="25%" align="left">Shows
	<select onchange="setURL('limit', this.value)">
		<option value="1"<?php echo ($limit == '1') ? ' selected="selected"' : ''?>>1</option>
        <option value="15"<?php echo ($limit == '15') ? ' selected="selected"' : ''?>>15</option>
        <option value="30"<?php echo ($limit == '30') ? ' selected="selected"' : ''?>>30</option>
		<option value="45"<?php echo ($limit == '45') ? ' selected="selected"' : ''?>>45</option>
		<option value="60"<?php echo ($limit == '60') ? ' selected="selected"' : ''?>>60</option>
		<option value="75"<?php echo ($limit == '75') ? ' selected="selected"' : ''?>>75</option>
		<option value="90"<?php echo ($limit == '90') ? ' selected="selected"' : ''?>>90</option>
		<option value="100"<?php echo ($limit == '100') ? ' selected="selected"' : ''?>>100</option>
	</select> Per Page
	</td>	
  </tr>
</table>	
<script type="text/javascript">
/**
 * setURL
 *
 * Modifies the current URL and redirects the browser
 *
 * @param string key The name of the parameter to set
 * @param mixed value The value to set the parameter to
 * @return void
 * @author Dom Hastings
 */
function setURL(key, value) {
  // set up the url separators
  newUrl = '';
  // get the current url
  var url = window.location.href;
  // check if the specified key already exists
  var exists = url.indexOf('limit');
  var parameterExists = url.indexOf('?');
  // if it does
  if (exists > -1) {
  		// replace the value of limit
   		var newUrl = url.replace(/(limit=)[^\&]+/, '$1' + value);
  }else if(parameterExists > -1){
    	// append limit to new url
		var newUrl = url + '&limit='+value
  }else{
      	// append limit to new url
		var newUrl = url + '?limit='+value
  }
 
  // set the url
  window.location.href = newUrl;
}</script>