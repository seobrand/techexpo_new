<?php 
$pageName = (isset($pageName)) ? $pageName : 'home';
//Add Bread curmbs
echo $this->Html->addCrumb('Home', '/superadmin/adminusers/home');
switch($pageName) {
	case 'home' :
		break;
	case 'page' :
		echo $this->Html->addCrumb('Pages', '');
		break;
	case 'addpage' :
		echo $this->Html->addCrumb('Pages', '/superadmin/pages/');
		echo $this->Html->addCrumb('Add New Page', '');
		break;
	case 'editpage' :
		echo $this->Html->addCrumb('Pages', '/superadmin/pages/');
		echo $this->Html->addCrumb('Edit Page', '');
		break;	
     case 'viewpage' :
		echo $this->Html->addCrumb('Pages', '/superadmin/pages/');
		echo $this->Html->addCrumb('View Page Details', '');
		break; 
			
	 case 'setting' :
		echo $this->Html->addCrumb('Settings','');
		break;  
	case 'addsetting' :
		echo $this->Html->addCrumb('Settings', '/superadmin/settings/');
		echo $this->Html->addCrumb('Add New Setting', '');
		break;
	case 'editsetting' :
		echo $this->Html->addCrumb('Settings', '/superadmin/settings/');
		echo $this->Html->addCrumb('Edit Setting ', '');
		break;
	case 'viewsetting' :
		echo $this->Html->addCrumb('Settings', '/superadmin/settings/');
		echo $this->Html->addCrumb('View Setting Details ', '');
		break;        
	/* Breadcrub for admin users */	
	case 'adminuser' :
		echo $this->Html->addCrumb('User Profiles', '');
		break;
	case 'viewadminuser' :
		echo $this->Html->addCrumb('User Profiles', '/superadmin/adminusers/');
		echo $this->Html->addCrumb('View User Profile Details', '');
		break;
	case 'addadminuser' :
		echo $this->Html->addCrumb('User Profiles', '/superadmin/adminusers/');
		echo $this->Html->addCrumb('Add New User Profile', '');
		break;
	case 'editadminuser' :
		echo $this->Html->addCrumb('User Profiles', '/superadmin/adminusers/');
		echo $this->Html->addCrumb('Edit User Profile', '');
		break;
     /* Candidate manager */
	 case 'candidate' :
		echo $this->Html->addCrumb('Candidate List', '');
		break;
	case 'viewcandidate' :
		echo $this->Html->addCrumb('Candidates', '/superadmin/candidates/');
		echo $this->Html->addCrumb('View Candidate Details', '');
		break;
	case 'addcandidate' :
		echo $this->Html->addCrumb('Candidates', '/superadmin/candidates/');
		echo $this->Html->addCrumb('Add New Candidate', '');
		break;
	case 'editcandidate' :
		echo $this->Html->addCrumb('Candidates', '/superadmin/candidates/');
		echo $this->Html->addCrumb('Edit Candidate', '');
		break;
	case 'candidateMailReport':
		echo $this->Html->addCrumb('Candidates','/'.$redirectUrl);
		echo $this->Html->addCrumb('Reports','');
		break;												
     /* Client manager */
	 case 'adminclient' :
		echo $this->Html->addCrumb('Client List', '');
		break;
	case 'viewadminclient' :
		echo $this->Html->addCrumb('Clients', '/superadmin/adminclients/');
		echo $this->Html->addCrumb('View Client Details', '');
		break;
	case 'addadminclient' :
		echo $this->Html->addCrumb('Clients', '/superadmin/adminclients/');
		echo $this->Html->addCrumb('Add New Client', '');
		break;
	case 'editadminclient' :
		echo $this->Html->addCrumb('Clients', '/superadmin/adminclients/');
		echo $this->Html->addCrumb('Edit Client', '');
		break;					
	/* Breadcrub for admin roles */		
	case 'role' :
		echo $this->Html->addCrumb('User Groups', '');
		break;
	case 'viewrole' :
		echo $this->Html->addCrumb('User Groups', '/superadmin/roles/');
		echo $this->Html->addCrumb('View User Group Details ', '');
		break;
	case 'addrole' :
		echo $this->Html->addCrumb('User Groups', '/superadmin/roles/');
		echo $this->Html->addCrumb('Add New User Group', '');
		break;
	case 'editrole' :
		echo $this->Html->addCrumb('User Groups', '/superadmin/roles/');
		echo $this->Html->addCrumb('Edit User Group', '');
		break;
	/* Breadcrub for candidate registration form title */		
	case 'title' :
		echo $this->Html->addCrumb('Title List', '');
		break;
	case 'viewtitle' :
		echo $this->Html->addCrumb('Title', '/superadmin/titles/');
		echo $this->Html->addCrumb('View Title Details', '');
		break;
	case 'addtitle' :
		echo $this->Html->addCrumb('Title', '/superadmin/titles/');
		echo $this->Html->addCrumb('Add New Title', '');
		break;
	case 'edittitle':
		echo $this->Html->addCrumb('Titles', '/superadmin/titles/');
		echo $this->Html->addCrumb('Edit Title', '');
		break;
	
	/* Breadcrub for Code */	
	case 'code' :
		echo $this->Html->addCrumb('Code/Value', '');
		break;
	case 'viewCode' :
		echo $this->Html->addCrumb('Areas of Interest', '/superadmin/codes/');
		echo $this->Html->addCrumb('View Area of Interest Details ', '');
		break;
	
	case 'editCode':
		echo $this->Html->addCrumb('Code/Value', '/superadmin/codes/');
		echo $this->Html->addCrumb('Edit Code/Value', '');
		break;
            
    case 'addcode':
		echo $this->Html->addCrumb('Code','/superadmin/codes/');
		echo $this->Html->addCrumb('Add New Code','');
		break;	
		
	case 'emailtemplate' :
		echo $this->Html->addCrumb('Email Templates', '');
		break;
	case 'viewemailtemplate' :
		echo $this->Html->addCrumb('Email Templates', '/superadmin/email_templates/');
		echo $this->Html->addCrumb('View Email Template Details ', '');
		break;
	case 'addemailtemplate' :
		echo $this->Html->addCrumb('Email Templates', '/superadmin/email_templates/');
		echo $this->Html->addCrumb('Add New Email Template', '');
		break;
	case 'editemailtemplate':
		echo $this->Html->addCrumb('Email Templates', '/superadmin/email_templates/');
		echo $this->Html->addCrumb('Edit Email Template', '');
		break;	
	case 'ExportResume':
		echo $this->Html->addCrumb('Export Resume', '');
		break;
	case 'ExportResumeView':
		echo $this->Html->addCrumb('Export Resume', '/superadmin/ExportResumes/');
		echo $this->Html->addCrumb('Resume View', '');
		break;
            
            
            
            
       /* Breadcrumb for Locations */	
	case 'locationlist' :
		echo $this->Html->addCrumb('Locations List', '');
		break;	
	case 'addlocation' :
		echo $this->Html->addCrumb('Locations List', '/superadmin/locations/');
		echo $this->Html->addCrumb('Add New Location', '');
		break;
	case 'editlocation':
		echo $this->Html->addCrumb('Locations List', '/superadmin/locations/');
		echo $this->Html->addCrumb('Edit Location', '');
		break;    
	case 'viewlocation' :
		echo $this->Html->addCrumb('Locations List', '/superadmin/locations/');
		echo $this->Html->addCrumb('View Location', '');
		break;
		
		
	case 'setlist' :
		echo $this->Html->addCrumb('Locations List', '');
		break;	
	case 'addset' :
		echo $this->Html->addCrumb('Sets List', '/superadmin/sets/');
		echo $this->Html->addCrumb('Add Set', '');
		break;
	case 'editset':
		echo $this->Html->addCrumb('Sets List', '/superadmin/sets/');
		echo $this->Html->addCrumb('Edit Set', '');
		break; 	
		
		
		 /* Breadcrumb for Events/Shows */	
	case 'showlist' :
		echo $this->Html->addCrumb('Shows List', '');
		break;	
	case 'addshow' :
		echo $this->Html->addCrumb('Shows List', '/superadmin/shows/');
		echo $this->Html->addCrumb('Add New Show', '');
		break;
        case 'editshow':
		echo $this->Html->addCrumb('Shows List', '/superadmin/shows/');
		echo $this->Html->addCrumb('Edit Show', '');
		break;    
        case 'viewshow' :
		echo $this->Html->addCrumb('Locations List', '/superadmin/shows/');
		echo $this->Html->addCrumb('View Show', '');
		break;
   
   	 /* Breadcrumb for Banner */	
	case 'bannerlist' :
		echo $this->Html->addCrumb('Banners List', '');
		break;
	case 'addbanner' :
		echo $this->Html->addCrumb('Banners List', '/superadmin/banners/');
		echo $this->Html->addCrumb('Add New Banner', '');
		break;
    case 'editbanner':
		echo $this->Html->addCrumb('Banners List', '/superadmin/banners/');
		echo $this->Html->addCrumb('Edit Banner', '');
		break;    
            
             /* Breadcrumb for Events/Shows */	
	case 'ShowHome' :
		echo $this->Html->addCrumb('Homepage Shows', '');
		break;		
             /* Breadcrumb for Events/Shows */	
        case 'Pix' :
		echo $this->Html->addCrumb('Event Pictures', '');
		break;	
//////////////////
	 case 'MarketingExhibitor' :
		echo $this->Html->addCrumb('MarketingExhibitor', '');
		break;	
	case 'AddMarketingExhibitor' :
		echo $this->Html->addCrumb('MarketingExhibitor', '/superadmin/marketing_exhibitors/');
		echo $this->Html->addCrumb('Add Marketing Partner', '');
		break;	
	case 'EditMarketingExhibitor' :
		echo $this->Html->addCrumb('MarketingExhibitor', '/superadmin/marketing_exhibitors/');
		echo $this->Html->addCrumb('Edit Marketing Partner', '');
		break;				
/////////////////
	 case 'Exhibitor' :
		echo $this->Html->addCrumb('Exhibitor', '');
		break;	
	case 'AddExhibitor' :
		echo $this->Html->addCrumb('Exhibitor', '/superadmin/exhibitors/');
		echo $this->Html->addCrumb('Add Exhibitor', '');
		break;	
	case 'EditExhibitor' :
		echo $this->Html->addCrumb('Exhibitor', '/superadmin/exhibitors/');
		echo $this->Html->addCrumb('Edit Exhibitor', '');
		break;				
	case 'UploadPix' :
		echo $this->Html->addCrumb('Event Pictures', '/superadmin/pixes/');
		echo $this->Html->addCrumb('Upload Event Pictures', '');
		break;	
	
	case 'TestimonialList' :
		echo $this->Html->addCrumb('Testimonial Manage', '');
		break;
	
	case 'TestimonialAdd' :
		echo $this->Html->addCrumb('Testimonial Manage', '/superadmin/testimonials/');
		echo $this->Html->addCrumb('Add Testimonial', '');
		break;	
	case 'TestimonialEdit' :
		echo $this->Html->addCrumb('Testimonial Manage', '/superadmin/testimonials/');
		echo $this->Html->addCrumb('Edit Testimonial', '');
		break;		
	     
       
	  /* Breadcrumb for Training Schools */	
	case 'trainingschool' :
		echo $this->Html->addCrumb('Training Schools', '');
		break;	
	case 'addtrainingschool' :
		echo $this->Html->addCrumb('Training Schools', '/superadmin/training_schools/');
		echo $this->Html->addCrumb('Add New Training School', '');
		break;
        case 'edittrainingschool':
		echo $this->Html->addCrumb('Training Schools', '/superadmin/training_schools/');
		echo $this->Html->addCrumb('Edit Training School', '');
		break;   
            
            
            
          /* Breadcrumb for Home Page Messsages */	
	case 'homepagemessage' :
		echo $this->Html->addCrumb('Homepage Message', '');
		break;	
	case 'editHomepageMessage' :
		echo $this->Html->addCrumb('Homepage Message', '/superadmin/homepageMessages/');
		echo $this->Html->addCrumb('Edit Homepage Message', '');
		break;
            
        /* Breadcrumb for Home Page Dynamic Contents */	
	case 'homepagedynamic' :
		echo $this->Html->addCrumb('Homepage Team Message', '');
		break;	
	case 'editHomepagedynamic' :
		echo $this->Html->addCrumb('Homepage Team Message', '/superadmin/homepageDynamicContents/');
		echo $this->Html->addCrumb('Edit Homepage Team Message', '');
		break;
        case 'addHomepagedynamic' :
		echo $this->Html->addCrumb('Homepage Team Message', '/superadmin/homepageDynamicContents/');
		echo $this->Html->addCrumb('Add Homepage Team Message', '');
		break;
		
		  /* Breadcrumb for Home Page Dynamic Contents */	
	case 'PressRelease' :
		echo $this->Html->addCrumb('Press Release', '');
		break;	
	case 'addpressrelease' :
		echo $this->Html->addCrumb('Press Release', '/superadmin/pressReleases/');
		echo $this->Html->addCrumb('Add Press Release', '');
		break;
        case 'updatepressrelease' :
		echo $this->Html->addCrumb('Press Release', '/superadmin/pressReleases/');
		echo $this->Html->addCrumb('Edit Press Release', '');
		break;
		
		 /* Breadcrumb for Partners */	
	case 'Partner' :
		echo $this->Html->addCrumb('Partner', '');
		break;	
	case 'addpartner' :
		echo $this->Html->addCrumb('Partner', '/superadmin/partners/');
		echo $this->Html->addCrumb('Add Partner', '');
		break;
        case 'updatepartner' :
		echo $this->Html->addCrumb('Partner', '/superadmin/partners/');
		echo $this->Html->addCrumb('Edit Partner', '');
		break;
            
            
         /* Breadcrumb for Trial Accounts */	
        case 'trialAccounts' :
		echo $this->Html->addCrumb('Trial Accounts Tracker', '');
		break;	
            
         /* Breadcrumb for Employer Last Visit */	
        case 'lastVisit' :
		echo $this->Html->addCrumb('Employer Last Visit', '');
		break;	
            
		/******* Breadcrumb for Clients ***********/
		case 'clientmanager' :
		echo $this->Html->addCrumb('Clients', '');
		echo $this->Html->addCrumb('Client Manager', '');
		break;	
		
		 /* Breadcrumb for partner tracking */	
		case 'partnertracking' :
		echo $this->Html->addCrumb('Marketing', '/superadmin/marketings/index');
		echo $this->Html->addCrumb('Special Tracking Partner', '/superadmin/marketings/index');
		break;
		 
        case 'createtrackingpage' :
		echo $this->Html->addCrumb('Marketing', '/superadmin/marketings/partnertracking');
		echo $this->Html->addCrumb('Special Tracking Partner', '/superadmin/marketings/partnertracking');
		echo $this->Html->addCrumb('Create New Tracking Partner', '');
		break;
		
		case 'edittrackingpage' :
		echo $this->Html->addCrumb('Marketing', '/superadmin/marketings/partnertracking');
		echo $this->Html->addCrumb('Special Tracking Partner', '/superadmin/marketings/partnertracking');
		echo $this->Html->addCrumb('Update Tracking Partner', '');
		break;
		
		case 'siteusage' :
		echo $this->Html->addCrumb('Static', '');
		echo $this->Html->addCrumb('Employer Site Usage Stats', '/superadmin/EmployerSiteUsages');
		break;
		
		case 'trafficstat' :
		echo $this->Html->addCrumb('Static	', '/superadmin/DetailedTrafficStats');
		echo $this->Html->addCrumb('Detailed Traffic', '/superadmin/DetailedTrafficStats/index');
		break;
		
		case 'newsletter' :
		echo $this->Html->addCrumb('Newsletter','/superadmin/newsletters/');
		echo $this->Html->addCrumb('Newsletter Subscriber', '');
		break;
        case 'sendnewsletter' :
		echo $this->Html->addCrumb('Newsletter','/superadmin/newsletters/');
		echo $this->Html->addCrumb('Send Newsletter', '');
		break;
		case 'newsletter-list' :
		echo $this->Html->addCrumb('Newsletter','/superadmin/newsletters/list');
		echo $this->Html->addCrumb('Newsletter List', '');
		break;
		
		case 'orders' :
		echo $this->Html->addCrumb('Admin','/superadmin/orders/');
		echo $this->Html->addCrumb('Order Manager', '');
		break;
        case 'addjobplan' :
		echo $this->Html->addCrumb('Order Manager','/superadmin/orders/');
		echo $this->Html->addCrumb('Add Job Plan', '');
		break;
		case 'editjobplan' :
		echo $this->Html->addCrumb('Order Manager','/superadmin/orders/');
		echo $this->Html->addCrumb('Edit Job Plan', '');
		break;
		
		case 'orderhistory' :
		echo $this->Html->addCrumb('Order Management','');
		echo $this->Html->addCrumb('View Job Plan History', '');
		break;
		
		case 'users' :
		echo $this->Html->addCrumb(' Current Chat User', '');
		break;
		
		case 'chatgroup' :
		echo $this->Html->addCrumb(' Chat Group', '');
		break;
		
		case 'addgroup' :
		echo $this->Html->addCrumb(' Chat Group', '/superadmin/chats/chatgroup/');
		echo $this->Html->addCrumb(' Chat Group Add', '');
		break;
		
		case 'editgroup' :
		echo $this->Html->addCrumb(' Chat Group', '/superadmin/chats/chatgroup/');
		echo $this->Html->addCrumb(' Chat Group Edit', '');
		break;
		
		case 'chathistory' :
		echo $this->Html->addCrumb(' Chat History', '');
		break;
		
		case 'viewHistory' :
		echo $this->Html->addCrumb(' Chat History', '/superadmin/chats/chathistory/');
		echo $this->Html->addCrumb(' View History', '');
		break;
		
		case 'deleteHistory' :
		echo $this->Html->addCrumb(' Chat History', '/superadmin/chats/chathistory/');
		echo $this->Html->addCrumb(' Delete Chat history', '');
		break;
		
		case 'allnewclients' :
		echo $this->Html->addCrumb(' New Client', '/superadmin/clients/allnewclients/');
		echo $this->Html->addCrumb(' All New Clients', '');
		break;
		
		case 'privacyPolicy' :
			echo $this->Html->addCrumb('Content Management', '');
			echo $this->Html->addCrumb('Privacy Policy', '');
			break;
			
		case 'termsOfUse' :
			echo $this->Html->addCrumb('Content Management', '');
			echo $this->Html->addCrumb('Terms Of Use', '');
			break;
		case 'whyattend' :
		echo $this->Html->addCrumb('Content Management', '');
		echo $this->Html->addCrumb('Why Attend', '');
		break;
 }				 			
?>