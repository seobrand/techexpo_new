<?php
App::uses('AppModel', 'Model');
/**
 * ShowsHome Model
 *
 */
class ShowsHome extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
 
	 var $name = 'ShowsHome';  
	 
	 var $hasOne  = array(    
	    'Show' => array(   
	    'className'     => 'Show',     
		'foreignKey'    => 'id', 
		'fields'        =>'location_id,show_dt,show_name,id,ics_file,show_end_dt',  
		'order'    => 'Show.show_dt ASC',
		 ) ); 
		  
	public $useTable = 'shows_home';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'show_id';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'show_id';
        
       function showName($id = null){           
           return ClassRegistry::init('ShowsHome')->find("first",array('conditions'=>array('show_id'=>$id)));
       }
       
       
}
