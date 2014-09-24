<?php $limit = (isset($this->request->query['limit']) && $this->request->query['limit']!='') ? $this->request->query['limit'] : 10; ?>


<table border="0" cellpadding="2" cellspacing="2" align="center"  class="pagingview" width="100%">
  <tr> 
<!--  	<td width="29%" align="left">
    	<?php echo $this->Paginator->numbers(array('first' => 'First page'));?>
	</td>-->
	<td width="71%" align="left">

    Jobs per page
    
	<select onchange="setURL('limit', this.value)">
		<option value="1"<?php echo ($limit == '1') ? ' selected="selected"' : ''?>>1</option>
        <option value="10"<?php echo ($limit == '10') ? ' selected="selected"' : ''?>>10</option>
        <option value="25"<?php echo ($limit == '25') ? ' selected="selected"' : ''?>>25</option>
        <option value="50"<?php echo ($limit == '50') ? ' selected="selected"' : ''?>>50</option>
		<option value="100"<?php echo ($limit == '100') ? ' selected="selected"' : ''?>>100</option>
		<option value="200"<?php echo ($limit == '200') ? ' selected="selected"' : ''?>>200</option>
		<option value="500"<?php echo ($limit == '500') ? ' selected="selected"' : ''?>>500</option>
		<option value="1000"<?php echo ($limit == '1000') ? ' selected="selected"' : ''?>>1000</option>
	</select> 
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