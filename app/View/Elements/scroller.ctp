<?php /*?><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>	<?php */?>


<?php echo $this->Html->css('jquery-ui-1.8.4.custom');?>
<?php echo $this->Html->css('base');?>
<?php echo $this->Html->script('jquery.fixheadertable.min');?>

<script type="text/javascript">  
	var popmsg = jQuery.noConflict();
			popmsg(document).ready(function() {  	

				popmsg('div.title').each(function(i){
					popmsg(this).prepend('<a name="ex_' + (i+1) + '" />');
					popmsg('#links').append('<a title="' + popmsg('span', this).html() + '" class="ui-state-default ui-corner-all" href="#ex_' + (i+1) + '"><span style="float: left; margin-right: 0.3em; margin-top : -2px;" class="ui-icon ui-icon-triangle-1-e"></span> Example #' + (i+1) + '</a>');
				});

				popmsg('<br/><a style="cursor : pointer">[ Show code ]</a>').insertBefore('pre').click(function(){
					if(popmsg(this).html() == "[ Show code ]"){
						popmsg(this).html("[ Hide code ]");
					}else{
						popmsg(this).html("[ Show code ]");
					}						
					popmsg(this).next('pre').toggle();
				});
				
				popmsg.ajax({						
					url: '<?php echo FULL_BASE_URL.router::url('/',false);?>/usertimesheets/data',					
					success: function(data) {
					popmsg('#0').html(data).fixheadertable({ 
							caption : 'Candidate Timesheet Status', 
							colratio : ["auto", "auto", "auto", "auto", "auto", "auto"], 
							height : 190, 
							width : "100%", 
							zebra : true, 
							sortable : false,
							sortedColId : 1, 
							resizeCol : true,
							pager : false,
							rowsPerPage	 : 10,
							sortType : ['integer', 'string', 'string', 'string', 'string', 'date'],
							dateFormat : 'm/d/Y'
						});
					}
				});
				
				function buildtable(id, data) {
					popmsg(id).html(data);					
					if(id == "#1")
						popmsg('#1').fixheadertable({ height : 200, zebra : true });
					if(id == "#2")
						popmsg('#2').fixheadertable({ caption : 'My employees', height : 200, width : "100%" });
					if(id == "#3")
						popmsg('#3').fixheadertable({ caption : 'My employees', height : 200, width : "100%", minWidth : 1000 });
					if(id == "#4")
						popmsg('#4').fixheadertable({ caption : 'My employees', colratio : ["auto", "auto", "auto", "auto", "auto", "auto"], height : 200, width : "100%", zebra : true, resizeCol : true, minColWidth : 50 });
					if(id == "#5")
						popmsg('#5').fixheadertable({ caption : 'My employees', colratio : ["auto", "auto", "auto", "auto", "auto", "auto"], height : 200, width : "100%", zebra : true, sortable : false, sortedColId : 0, 
							   sortType    : ['integer', 'string', 'string', 'string', 'string', 'date'],
							   dateFormat  : 'm/d/Y' });
					if(id == "#6")
						popmsg('#6').fixheadertable({ 
							//caption : 'My employees', 
							colratio : ["auto", "auto", "auto", "auto", "auto", "auto"], 
							height : 200, 
							width : "100%", 
							zebra : true, 
							sortable : false, 
							sortedColId : 2, 
							sortType : ['integer', 'string', 'string', 'string', 'string', 'date'],
							dateFormat : 'm/d/Y',
							pager : false,
							rowsPerPage	 : 10
						});
					if(id == "#7")
						popmsg('#7').fixheadertable({ 
							caption : 'My employees', 
							colratio : ["auto", "auto", "auto", "auto", "auto", "auto"], 
							height : 200, 
							width : "100%", 
							zebra : true, 
							sortable : false, 
							sortedColId : 3, 
							sortType : ['integer', 'string', 'string', 'string', 'string', 'date'],
							dateFormat : 'm/d/Y',
							pager : false,
							rowsPerPage	 : 10,
							resizeCol : true
						});
				};
				
				popmsg("button").button();
				popmsg("button.loadexample").click(function(){
					var button = this;
					if(popmsg(button).attr('pass')) return;
					popmsg('span', this).append('<span class="text">loading...</span>');
					popmsg.ajax({						
						url: 'data.php',						
						success: function(data) {
							buildtable(popmsg(button).attr('num'), data);
							popmsg('span.text', button).remove();
							popmsg('span.ui-button-text', button).html('Example loaded !');
							popmsg(button).attr('pass', 'pass');
						}
					});
				});
				//popmsg("#lightness").click(function() { popmsg('#link').attr('href', 'jquery-ui/css/ui-lightness/jquery-ui-1.8.4.custom.css'); });
				//popmsg("#flick").click(function() { popmsg('#link').attr('href', 'jquery-ui/css/flick/jquery-ui-1.8.4.custom.css'); });
				//popmsg("#redmond").click(function() { popmsg('#link').attr('href', 'jquery-ui/css/redmond/jquery-ui-1.8.4.custom.css'); });
				//popmsg("#smoothness").click(function() { popmsg('#link').attr('href', 'jquery-ui/css/smoothness/jquery-ui-1.8.4.custom.css'); });
			});
		</script>
		
		
		 
		
<style type="text/css">		
 			
			pre {				
				padding		: 5px;	
				font-size	: 11px;
 				width		: 100%;
				display		: none;
				font:11px Verdana, Arial, Helvetica, sans-serif;
				color:#000;
				 
			}
			
			.javascript  .comment {
				color : green; 
			}
			
			.javascript  .string {
				color : maroon;
			}
			
			.javascript  .keywords {
				font-weight : bold;
			}
			
			.javascript  .global {
				color : blue;
				font-weight : bolder;
			}
			
			.javascript  .brackets {
				color : Gray;
			}
			
			.javascript  .thing {
				font-size : 10px;
			}			
			
			span.text {
				font-weight : normal;
				font-style	: italic;
				margin-left : 10px;			
			}		
			
			div.title {
				font-size	: 18px;
				padding 	: 15px 0;
				font-weight : bold;
			}
			
			div.title span {
				font-weight : normal;
			}
			
			div.themes {
				overflow	: hidden;
    			width		: 150px;
    			position	: fixed;
    			top			: 180px;
    			left		: 10px;
			}
			
			div.themes button {
				width		: 120px;
				margin-bottom : 5px;
			}
			
			div.themes a {
			    display			: block;
			    font-size		: 1.1em;
			    margin-bottom	: 5px;
			    text-decoration	: none;
			    padding 		: 3px;
			    width			: 120px;
			}
			
			div.themes a:focus {
				outline : none;
			}
			
			div.themes a.top {
				color : black;
			}
			
			div.themes a.top:hover {
				text-decoration : underline;
			}
				
			#content div.box table {
			font:11px Verdana, Arial, Helvetica, sans-serif;
			color:#000;
			}
			
			


		</style>
<table class="resultset" id="0" style="width:100%;">			
</table>