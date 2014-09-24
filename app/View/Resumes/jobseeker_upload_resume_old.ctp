<?php echo $this->Html->script("tiny_mce/tiny_mce.js"); ?>
<script type="text/javascript">
function checkTotalResume(total)
{
	var totalResume=total;
	if(total>=3)
	{
		alert('Do not have a rights to upload more than 3 resume');
		return false;
	}else
	{
		return true;
	}
}
</script>
<script language="javascript" type="text/javascript">
	<?php 
	if($preset = "basic")
	{
		$options = '
		mode : "textareas",
		elements : "ajaxfilemanager",
		theme : "advanced",
		editor_deselector : "mceNoEditor",
		plugins : "advimage,advlink,table,media,contextmenu",    
		theme_advanced_buttons1 : "bold,italic,underline,separator,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,outdent,indent,image,code,cut,copy,paste",
		theme_advanced_buttons2 : "fontselect,fontsizeselect,forecolor,backcolor,cleanup,removeformat",
		theme_advanced_buttons3 : "tablecontrols",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		file_browser_callback : "ajaxfilemanager",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		content_css : "/css/'.$this->layout.'.css"    
		';
	}
	?>

		tinyMCE.init({<?php echo($options); ?>});
		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "<?php echo FULL_BASE_URL.Router::url('/', false);?>js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
            tinyMCE.activeEditor.windowManager.open({
                url: "<?php echo FULL_BASE_URL.Router::url('/', false);?>js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
                width: 752,
                height: 500,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
            
		}

</script>

<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container"> <?php echo $this->Form->create('Resume',array('action'=>'upload_resume', 'enctype'=>'multipart/form-data')); ?>
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Submit/Edit Resume</h1>
          <div class="error-message"><?php echo $topError;?></div>
          <div class="content"> <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
            <p><strong>Submit your resume. You can submit up to a total of 3 resumes if you wish.</strong></p>
            <br />
            <h2 class="mana_subheading">1. Please enter a Title for your Resume &amp; Provide a Short Career summary (2-3 lines)</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Resume Title:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Resume.resume_title',array('class'=>'big237_textfield','label'=>false,'div'=>''));?> <br />
                    <strong>Example:</strong><span class="instruction"> "Experienced Database Administrator. Oracle certified."</span></div>
                </li>
                <li>
                  <label>My professional profile can be summarized as:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Resume.resume_summary',array('class'=>'textarea_237 smallTextB mceNoEditor','type'=>'textarea','label'=>false,'div'=>''));?> <br />
                    <strong>Example: </strong><span class="instruction">"A database professional with over 10 years of strong design, administration &amp; optimization experience. Expert with SQL Server and Oracle systems."</span></div>
                </li>
              </ul>
            </div>
            <br />
            <br />
            <h2 class="mana_subheading">2. Please provide keywords to attach to your resume. Keywords should represent your CORE or main skills.</h2>
            <p><strong>Please fill out your keyword information carefully.</strong></p>
            <ul class="listing_arrow">
              <li> This is very important for the job matching and automatic scoring process.</li>
              <li>You can enter 1-5 keywords.</li>
              <li>If you wish to see skills added to the list or have comments about this form, <a href="mailto:brand@techexpousa.com,mweiser@techexpousa.com">click here</a>. </li>
            </ul>
            <table class="tableWhd" width="640px" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="640px" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="195" style="text-align:left">Keyword</th>
                      <th width="140" style="text-align:center">Years of Exp.</th>
                      <th width="139" style="text-align:center">Last Used</th>
                      <th width="114" style="text-align:center">Level</th>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="table_row border_bottom"><table width="640px" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="195" style="text-align:left"><div class="dropdown_resume1">
                          <?php 
                        echo $this->Form->input('ResumeSkill.0.skill_id',array('type'=>'select','empty'=>'-Select Keyword-','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="140" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                          <?php 
                        echo $this->Form->input('ResumeSkill.0.experience_code',array('type'=>'select','empty'=>'-Select Year of Exp.-','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                          <?php 
                        echo $this->Form->input('ResumeSkill.0.last_used_code',array('type'=>'select','empty'=>'-Select Last Time -','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                          <?php 
                        echo $this->Form->input('ResumeSkill.0.level_code',array('type'=>'select','empty'=>'-Select Level-','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="195" style="text-align:left"><div class="dropdown_resume1">
                          <?php 
                        echo $this->Form->input('ResumeSkill.1.skill_id',array('type'=>'select','empty'=>'-Select Keyword-','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="140" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                          <?php 
                        echo $this->Form->input('ResumeSkill.1.experience_code',array('type'=>'select','empty'=>'-Select Year of Exp.-','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                          <?php 
                        echo $this->Form->input('ResumeSkill.1.last_used_code',array('type'=>'select','empty'=>'-Select Last Time -','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                          <?php 
                        echo $this->Form->input('ResumeSkill.1.level_code',array('type'=>'select','empty'=>'-Select Level-','empty'=>'-Select Last Time -','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="195" style="text-align:left"><div class="dropdown_resume1">
                          <?php 
                        echo $this->Form->input('ResumeSkill.2.skill_id',array('type'=>'select','empty'=>'-Select Keyword-','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="140" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                          <?php 
                        echo $this->Form->input('ResumeSkill.2.experience_code',array('type'=>'select','empty'=>'-Select Year of Exp.-','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                          <?php 
                        echo $this->Form->input('ResumeSkill.2.last_used_code',array('type'=>'select','empty'=>'-Select Last Time -','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                          <?php 
                        echo $this->Form->input('ResumeSkill.2.level_code',array('type'=>'select','empty'=>'-Select Level-','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="195" style="text-align:left"><div class="dropdown_resume1">
                          <?php 
                        echo $this->Form->input('ResumeSkill.3.skill_id',array('type'=>'select','empty'=>'-Select Keyword-','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="140" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                          <?php 
                        echo $this->Form->input('ResumeSkill.3.experience_code',array('type'=>'select','empty'=>'-Select Year of Exp.-','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                          <?php 
                        echo $this->Form->input('ResumeSkill.3.last_used_code',array('type'=>'select','empty'=>'-Select Last Time -','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                          <?php 
                        echo $this->Form->input('ResumeSkill.3.level_code',array('type'=>'select','empty'=>'-Select Level-','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="195" style="text-align:left"><div class="dropdown_resume1">
                          <?php 
                        echo $this->Form->input('ResumeSkill.4.skill_id',array('type'=>'select','empty'=>'-Select Keyword-','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="140" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                          <?php 
                        echo $this->Form->input('ResumeSkill.4.experience_code',array('type'=>'select','empty'=>'-Select Year of Exp.-','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                          <?php 
                        echo $this->Form->input('ResumeSkill.4.last_used_code',array('type'=>'select','empty'=>'-Select Last Time -','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                          <?php 
                        echo $this->Form->input('ResumeSkill.4.level_code',array('type'=>'select','empty'=>'-Select Level-','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <br />
            <br />
            <h2 class="mana_subheading">3. Please paste your resume in the text area below.</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid"> <?php echo $this->Form->input('Resume.resume_content',array('class'=>'big_textarea','type'=>'textarea','label'=>false,'div'=>''));?>
           <br />
           <h2 class="mana_subheading">3. Upload Resume.</h2>
            <div class="gray_full_top"></div>
             <?php echo $this->Form->input('Resume.filename',array('class'=>'textarea_237','type'=>'file','label'=>'','border'=>'none','div'=>''));?> <br />
            <br /><br /><br />
           
             <div class="man_resume_footer padding_right_none">
                <p>Please enter text as shown in image below:</p>
                <ul>
                  <li class="last">
                    <?php // echo $this->Form->submit('Delete',array('name'=>'Delete','value'=>'Delete','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
                  </li>
                  <li> <?php echo $this->Form->input('Resume.captcha',array('autocomplete'=>'off','value'=>'','label'=>false,'class'=>'security_txt','div'=>'')); ?> <br />
                    <div class="error-message"><?php echo $securityerror;?></div>
                  </li>
                  <li > <?php echo $this->Html->image($this->Html->url(array('action'=>'captcha','Jobseeker'=>false), true),array('style'=>'','vspace'=>2)); ?> </li>
                </ul>
                <div class="clear"></div>
                <div class="align_right">
                  <?php 
				  
				  echo $this->Form->hidden('Update',array('value'=>'update','div'=>false,'label'=>false));
				  
				  echo $this->Form->submit('images/update.png',array('name'=>'Update','value'=>'Update','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
                  
                  
                   </div>
                  
                  
                 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo  $this->Form->end();?>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
