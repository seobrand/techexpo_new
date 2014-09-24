<script src="<?php echo FULL_BASE_URL.router::url('/',false);?>js/jquery.textareaCounter.plugin.js" type="text/javascript"></script>
<script type="text/javascript">
			var info;
			$(document).ready(function(){
				var options2 = {
						'maxCharacterSize': 250,
						'originalStyle': 'originalTextareaInfo',
						'warningStyle' : 'warningTextareaInfo',
						'warningNumber': 40,
						'displayFormat' : '#input/#max | #words words'
				};
				$('#resume_summary').textareaCount(options2);
				
				var options2 = {
						'maxCharacterSize': 70,
						'originalStyle': 'originalTextareaInfo',
						'warningStyle' : 'warningTextareaInfo',
						'warningNumber': 40,
						'displayFormat' : '#input/#max | #words words'
				};
				$('#resume_title').textareaCount(options2);
				
				});
		</script>
		