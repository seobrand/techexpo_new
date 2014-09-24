<?php 
class Resume extends AppModel {
	var $name="resume";
	
	var $hasMany  = 'ResumeSkill'; 
	
	
	public $belongsTo = array( 
        
		 'Candidate' => array(
            'foreignKey'   => 'candidate_id'
        )
    );
	
function resumeUpload() 
	{
	 
		$validate1 = array(
			'resume_title'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter resume title',
						'last'=>true)
					),
			'resume_content'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> "Please enter resume content",
						'last'=>true),
					'noBlank' => array(
        				 'rule' => array('minLength', '500'),
        				 'message' => 'The text version of your resume can be no less than 500 characters'
   								 ),	
					)/*,
			'filename' => array(
							'rule' => array(
									'extension', array('pdf', 'doc', 'docx')
							),
							'on' => 'create',
							'message' => 'Please upload your resume in a PDF or Word format.'
						),*/
			);
			
			$this->validate=$validate1;
			return $this->validates();
		
	}

}
?>