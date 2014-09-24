<table border="0" cellpadding="2" cellspacing="2" align="center"  class="pagingview">
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
	<td width="25%" align="right">
	<?php $default = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : 15;
	echo 'View&nbsp;'.$this->Form->input('per_page_record',array('options'=>array('1'=>'1','15'=>'15','30'=>'30','45'=>'45','60'=>'60','75'=>'75','90'=>'90','100'=>'100'),'label'=>'','div'=>false,'onchange'=>'javascript:precord(this.value)','id'=>'page','default'=>$default)).'&nbsp;per page&nbsp;&nbsp;';?>
	</td>
  </tr>
</table>	

<?php if($this->params['controller'] == 'clients') {?>  
		<span id="record" style="display:none;"><?php echo FULL_BASE_URL.router::url('/',false).'superadmin/'.$this->params['controller'].'/'.$this->Session->read('action').'/';?></span>
		<span id="record1" style="display:none;"><?php echo FULL_BASE_URL.router::url('/',false).'superadmin/'.$this->params['controller'].'/'.$this->Session->read('action').'/page:';?></span>
		
<?php } else { ?>
		<span id="record" style="display:none;"><?php echo FULL_BASE_URL.router::url('/',false).'superadmin/'.$this->params['controller'].'/index/';?></span>
		<span id="record1" style="display:none;"><?php echo FULL_BASE_URL.router::url('/',false).'superadmin/'.$this->params['controller'].'/index/page:';?></span>
		<?php } ?>
		<span id="record2" style="display:none;"><?php 
		//search
		if($this->Session->read('param_search.search')) {
			$search = '/search:'.$this->Session->read('param_search.search');
		}
		else if($this->Session->read('data_search.search')) {
			$search = '/search:'.$this->Session->read('data_search.search');
		}
		else {
			$search = '';
		}
		//filter by
		if($this->Session->read('param_search.act')) {
			$act = '/act:'.$this->Session->read('param_search.act');
		}
		else if($this->Session->read('data_search.act')) {
			$act = '/act:'.$this->Session->read('data_search.act');
		}
		else {
			$act = '';
		}
		//active
		if($this->Session->read('param_search.active')) {
			$active = '/active:'.$this->Session->read('param_search.active');
		}
		else if($this->Session->read('data_search.active')) {
			$active = '/active:'.$this->Session->read('data_search.active');
		}
		else {
			$active = '';
		}
		//type
		if($this->Session->read('param_search.job_type')) {
			$job_type = '/job_type:'.$this->Session->read('param_search.job_type');
		}
		else if($this->Session->read('data_search.job_type')) {
			$job_type = '/job_type:'.$this->Session->read('data_search.job_type');
		}
		else {
			$job_type = '';
		}
		
		//params parameter
		if(isset($this->params['named']['page']) && $this->params['named']['page']!='') {
			$pageno = 'page:'.$this->params['named']['page'];
		}
		else {
			$pageno = '';
		}
		if(isset($this->params['named']['sort']) && $this->params['named']['sort']!='') {
			$sortingtype = '/sort:'.$this->params['named']['sort'];
		}
		else {
			$sortingtype = '';
		}
		if(isset($this->params['named']['direction']) && $this->params['named']['direction']!='') {
			$dirct = '/direction:'.$this->params['named']['direction'];
		}
		else {
			$dirct = '';
		}						
		
		?></span>
	<span id="search" style="display:none;"><?php echo $search;?></span>
	<span id="act" style="display:none;"><?php echo $act;?></span>
	<span id="active" style="display:none;"><?php echo $active;?></span>		
	<span id="job_type" style="display:none;"><?php echo $job_type;?></span>
	<span id="pageno" style="display:none;"><?php echo $pageno;?></span>
	<span id="sortingtype" style="display:none;"><?php echo $sortingtype;?></span>		
	<span id="dirct" style="display:none;"><?php echo $dirct;?></span>
<script type="text/javascript">
function precord(val) {
var a = document.getElementById('record').innerHTML;
var pageno = document.getElementById('pageno').innerHTML;
var sortingtype = document.getElementById('sortingtype').innerHTML;
var dirct = document.getElementById('dirct').innerHTML;
location.href=a+''+val+'/page_record/'+pageno+''+sortingtype+''+dirct;
}
function pindex(val) {
var a = document.getElementById('record1').innerHTML;
var srch = document.getElementById('search').innerHTML;
var act = document.getElementById('act').innerHTML;
var active = document.getElementById('active').innerHTML;
var type = document.getElementById('job_type').innerHTML;
var pageno = document.getElementById('pageno').innerHTML;
var sortingtype = document.getElementById('sortingtype').innerHTML;
var dirct = document.getElementById('dirct').innerHTML;
location.href=a+''+val+''+srch+''+act+''+active+''+type+''+sortingtype+''+dirct;
}
function checkEnter(val,evt)
{
	if(evt.keyCode == 13)  {
		// set up the url separators
		  newUrl = '';
		  // get the current url
		  var url = window.location.href;
		  // check if the specified key already exists
		  var exists = url.indexOf('page');

		  var parameterExists = url.indexOf('?');
		  // if it does
		  if (exists > -1) {
				// replace the value of limit
				var newUrl = url.replace(/(page:)\d+/g, '$1' + val);
		  }else{
				// append limit to new url
				var newUrl = url + '/page:'+val
		  }
		  // set the url
		  window.location.href = newUrl;
	}
} 


</script>