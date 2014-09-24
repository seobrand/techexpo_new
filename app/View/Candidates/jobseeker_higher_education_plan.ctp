<div id="wrapper">
   
<?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>

    <div id="container">
    
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Continuing Education</h1>
            <div class="content">
              <table class="border_table" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <?php foreach( $trainingschools as $ts ){ ?>
                  <tr valign="top" align="center">
                    <td><a target="_blank" href="<?php echo $ts['TrainingSchool']['ts_web']; ?>">
					<?php if(file_exists(TS.$ts['TrainingSchool']['ts_logo_path'])) 
					 	 echo $this->Html->image('TrainingSchools/'.$ts['TrainingSchool']['ts_logo_path']);
					  else
					  	echo $this->Html->image('TrainingSchools/no_image.jpg');
					   ?></a><br>
                     <?php echo  $ts['TrainingSchool']['ts_profile'];  ?>
                     </td>
                  </tr>
                  <tr>
                  <td  class="noborder" height="15px">
                  </td>
                  </tr>
                 <?php } ?> 
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

		<?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
      <div class="clear"></div>
         <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>