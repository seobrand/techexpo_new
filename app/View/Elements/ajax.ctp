<script language="javascript" type="text/javascript">
function ajaxPost(url,div)
{
			$.ajax({
               type:"POST",
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>Jobseeker/candidates/addSkill?name="+skill+"&number="+number,
               success : function(data) {
            	//alert("skillDropdown"+number);
				document.getElementById("skillDropdown"+number).innerHTML=data
				document.getElementById("succMSG").innerHTML='New Keyword has been added successfully'
				
				setTimeout(function() {
      									  $("#cboxClose").click()
  						 			 }, 1200);
			   },
               error : function() {
			   alert('error')
               },
           })
}

function onChangeAjaxGet(url,value,updateDiv)
{			$.ajax({
               type:"GET",
               url:url+''+value,
               success : function(data) {
            	document.getElementById(updateDiv).innerHTML=data
				
				},
               error : function() {
			   
               },
           })
}
</script>