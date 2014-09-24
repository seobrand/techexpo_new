<script src="<?php echo FULL_BASE_URL.router::url('/',false)?>/js/front_js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script>
	jQuery(function($){
   $("#date").mask("99/99/9999");
   $("#phone").mask("(999) 999-9999");
   $("#tin").mask("99-9999999");
   $("#mobilenumber").mask("999-999-9999");
   $("#phonenumber").mask("999-999-9999",{completed:function(){/*alert("You typed the following: "+this.val());*/}});
});


</script>
