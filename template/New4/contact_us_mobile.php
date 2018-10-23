<?php
/*
  $Id: contact_us.php,v 1.2 2003/09/24 15:34:26 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/


#  9/8/08 edit by Bob <http://www.site-webmaster.com>: removed capatcha anti spam code

  require('includes/application_top_mobile.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONTACT_US);
  
  
function error_bool ($err, $field) { 

         if( $err[$field] ) { 
         
             print('<td class="mainCO" style="color:red;">'); 
         } else { 
         
            print('<td class="mainCO">'); 
            
        } 
    } 

# new include to login to php list database:

require_once ( './includes/contact_us_configuration.php');

$white_listed_flag = FALSE;
 
if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'send')) {


	$name = tep_db_prepare_input($HTTP_POST_VARS['name']);
	$email_address = tep_db_prepare_input($HTTP_POST_VARS['email']);
	$enquiry = tep_db_prepare_input($HTTP_POST_VARS['enquiry']);
	
	$error = false;
	
	if (!$email_address) {
		$error = true;
		$err['email'] = true; 
		
		$messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);

	} else {	# no error on addy
		addKayakoTicket($name,$email_address,$enquiry);
	
		$error_email = false;

		$customer_email_query = tep_db_query("SELECT customers_id 
		FROM customers 
		WHERE customers_email_address
		= '" . $email_address  ."'");
				
		$customer_email_array = tep_db_fetch_array($customer_email_query);
		
		$customer_id = $customer_email_array['customers_id'];

		if($customer_id != ''){	# whitelisted so no more tests
		
			$white_listed_flag = TRUE;
			
			//add_user_to_newsletter_list( $email_address );
			
			send_the_message( $enquiry, $name, $email_address );
			
		} else {	# not in customer dbase, keep checking

			# now check the PHP list database, need to change server info here:
			//echo 'DATABASE_HOST='.DATABASE_HOST.'DATABASE_USER='.DATABASE_USER.'DATABASE_PASSWORD='.DATABASE_PASSWORD;
			//$list_dbase_link = mysql_connect( DATABASE_HOST , DATABASE_USER , DATABASE_PASSWORD, TRUE ) or die( 'cant connect');
			$list_dbase_link = mysql_connect( DB_SERVER , DB_LIST_USERNAME , DB_LIST_PASSWORD, TRUE ) or die( 'cant connect');
			
			$php_list_query_string = "SELECT email
			FROM " . DATABASE_NAME . ".phplist_user_user
			WHERE 
			blacklisted = 0
			AND
			email = '" . $email_address  ."'";
			
			
			$php_list_query_result = mysql_query ( $php_list_query_string, $list_dbase_link );
			
			
			# 12/28/08 edit by Bob <www.site-webmaster.com>: kill whitelisting newsletter signups
			# they are signing up to spam:
			
			if ( FALSE  ){	# blobk whitelisted
			
# 			if ( mysql_num_rows (  $php_list_query_result ) > 0  ){	# in list dbase so whitelisted
			        
				reset_to_osc_dbase( $list_dbase_link );
			        			
				$white_listed_flag = TRUE;
				
				send_the_message( $enquiry, $name, $email_address );
				# already in newsletter dbase so no add needed
							        
			}else{ # else not white listed for list
			
				reset_to_osc_dbase( $list_dbase_link );
				
			    if ( !$white_listed_flag ){	# not whitelisted, test for spammy links
			            
			            if ( has_spammy_link ( $enquiry ) ){
			                    			                    
								$error = true;
								$err['links'] = true; 
								
								$messageStack->add('contact', nl2br (LINK_SPAM_BLOCKED_EXPLANATION) );
			                    
			            }else{ # else no spammy links or other problems
			            
							add_user_to_newsletter_list( $email_address );
							
							send_the_message( $enquiry, $name, $email_address );
			            }  # end if test spammy links
			            
			    }else{ # else is whitelisted
			    
					add_user_to_newsletter_list( $email_address );
					
					send_the_message( $enquiry, $name, $email_address );
			    }  # end if  not whitelisted
			       
			}  # end if white listed for list
			 
		} # end if no customer id	
	
	} # end if valid email		
		
}	# end if send action


$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CONTACT_US));

$content = 'contact_us_mobile';

require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');



/*======================================================================*\
Function:	send_the_message
Purpose:	sends the mssg after all tests are OK
Input:		form comments (enquiry), name, email addy
Output:		mail to store owner
Author:		Bob <www.site-webmaster.com>
Revised:	12/18/08
\*======================================================================*/

function send_the_message( $enquiry, $name, $email_address ){
	
	
//	tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_SUBJECT, $enquiry, $name, $email_address);
tep_mail(STORE_OWNER, SEND_CONTACT_EMAILS_TO, EMAIL_SUBJECT, $enquiry, $name, $email_address);
	
	tep_redirect(tep_href_link('contact_us_mobile.php', 'action=success', 'SSL'));
	
}     # End send_the_message

  
/*======================================================================*\
	Function:	has_spammy_link
	Purpose:	tests for spammy looking links
	Input:		string to test - body text
	Output:		TRUE if it has spammy link, FALSE if not
	Author:		Bob <www.site-webmaster.com>
	Revised:	12/18/08
\*======================================================================*/

function has_spammy_link( $text_to_check ){
	
	$ok_domain = 'healingcrystals.com';	# if this is in the link it is OK
	
	$spam_pattern_any_url = "/(http:|www|https:).+\W/im";
	
	# first test if it has any links:

	if ( preg_match_all  ( $spam_pattern_any_url  , strtolower ( $text_to_check ) , $arr_all_urls  ) > 0 ){
			
			foreach ( $arr_all_urls[0] as $found_url ){
				
				if ( strpos( $found_url, $ok_domain ) === FALSE ){	# a link to some bad domain
				        
				        return TRUE;	# spam so end it
				      				    
				}  # end if ok domain found
				
			}   // end foreach url found
			
			
	}else{ # else no links, OK
	
		return FALSE;
		
	}  # end if any links
		
}     # End has_spammy_link

/*======================================================================*\
	Function:	add_user_to_newsletter_list
	Purpose:	add user addy to php list if they aren't in that database
				and they submitted a non spammy messwage which was sent
	Input:		user's email addy
	Output:		to dbase
	Author:		Bob <www.site-webmaster.com>
	Revised:	12/19/08
\*======================================================================*/

function add_user_to_newsletter_list( $email_address ){
	
	
	//$list_dbase_link = mysql_connect( DATABASE_HOST , DATABASE_USER , DATABASE_PASSWORD, TRUE ) or die( 'cant connect');
	$list_dbase_link = mysql_connect( DB_SERVER , DB_LIST_USERNAME , DB_LIST_PASSWORD, TRUE ) or die( 'cant connect');
	
	# check only for existance so we don't overwrite a setting:
	$php_list_query_string = "SELECT email
	FROM " . DATABASE_NAME . ".phplist_user_user
	WHERE 
	email = '" . $email_address  ."'";
	
	
	$php_list_query_result = mysql_query ( $php_list_query_string, $list_dbase_link );
	
	if ( mysql_num_rows (  $php_list_query_result ) == 0  ){	# no in list dbase so add them
				
								
		$php_list_insert_string = "INSERT
		INTO " . DATABASE_NAME . ".phplist_user_user
		SET 
		entered = NOW(),
		email = '" . $email_address  ."'";
		
		$php_list_query_result = mysql_query ( $php_list_insert_string, $list_dbase_link );
						
	}	# end if not in dbase
	
	reset_to_osc_dbase( $list_dbase_link );
			
}     # End add_user_to_newsletter_list


/*======================================================================*\
	Function:	reset_to_osc_dbase
	Purpose:	reset to usual osc database instead of PHP list
	Input:		link ID for the open php list dbase
	Output:		none
	Author:		Bob <www.site-webmaster.com>
	Revised:	12/19/08
\*======================================================================*/

function reset_to_osc_dbase( $list_dbase_link ){
	
				
	mysql_close( $list_dbase_link );
	
	# connect & select the dbase too public_html/includes/functions/database.php:
	tep_db_connect ();
	
}     # End reset_to_osc_dbase


# ==================================================================
?>