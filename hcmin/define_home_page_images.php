<?php
/*
  $Id: define_homepage_images.php@author: hardik@focusindia.com
  osCommerce, Open Source E-Commerce Solutions
  
*/
  require('includes/application_top.php');

function add_water_mark($image_name){
	//$image_width 		= 400;//considered as fixed
	//$image_height 		= 400;//considered as fixed 
	$bg_height			= 30;//height of the background that will be applied on formatted image
	$osc_images_dir 	= DIR_FS_DOCUMENT_ROOT ;//path to osc images dir
	//$amazon_images_dir 	= DIR_FS_DOCUMENT_ROOT . DIR_WS_IMAGES . 'amazon/'; //path to amazon images dir	
	if (file_exists(DIR_FS_DOCUMENT_ROOT . $image_name)){
		$split_vals 		= explode('.', $image_name);//last index's value will be used to determine image's file extension
		switch (strtolower($split_vals[count($split_vals)-1])){
			case 'jpg':
			case 'jpeg':
				$src_image 	= imagecreatefromjpeg($osc_images_dir . $image_name);
				break;
			case 'gif':
				$src_image 	= imagecreatefromgif($osc_images_dir . $image_name);
				break;
			case 'png':
				$src_image 	= imagecreatefrompng($osc_images_dir . $image_name);
				break;
		}
		if ($src_image){//continue only if image's resource is properly set
			//if (!file_exists($osc_images_dir . $image_name)){ //continue only if image does not exists in osc images folder			
				$size = getimagesize($amazon_images_dir . $image_name);
				$dest_image = imagecreatetruecolor($size[0], $size[1]);
				//$bg_color 	= imagecolorallocate($dest_image, 25, 37, 63);
				$font_color = imagecolorallocate($dest_image, 140, 146, 159);
				imagecopy($dest_image, $src_image, 0, 0, 0, 0, $size[0], $size[1]);
				//imagefilledrectangle($dest_image, 0, 0, $image_width, $bg_height, $bg_color);
				imagefttext($dest_image, 15, 0, 9, 25, $font_color, 'arialbd.ttf', 'www.HealingCrystals.com');
				echo 'aaaa' . $font_color;
				switch (strtolower($split_vals[count($split_vals)-1])){
					case 'jpg':
					case 'jpeg':
						imagejpeg($dest_image, $osc_images_dir . $image_name);
						break;
					case 'gif':
						imagegif($dest_image, $osc_images_dir . $image_name);
						break;
					case 'png':
						imagepng($dest_image, $osc_images_dir . $image_name);
						break;
				}
			//}
		}
	}
}



 $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
   
    if (tep_not_null($action)) {

    switch ($action) {
	
     
      case 'save':
          //for template version#1
         //echo '<pre>';
        //print_r($_POST);
      //exit();
      $version1 = $_POST['template_version1'];
      $version2 = $_POST['template_version2'];        
      $version3 = $_POST['template_version3'];
      $today = $_POST['today_selection'];
      if($today == 'v1'){
          $templateSet = 'v1:'.$version1.',v2:'.$version2.',v3:'.$version3;
          $todayTemplate = 'v1:'.$version1;
          $prevDayTemplate = 'v3:'.$version3;
      }elseif($today == 'v2'){
          $templateSet = 'v2:'.$version2.',v3:'.$version3.',v1:'.$version1;
          $todayTemplate = 'v2:'.$version2;
          $prevDayTemplate = 'v1:'.$version1;
      }elseif($today == 'v3'){
          $templateSet = 'v3:'.$version3.',v1:'.$version1.',v2:'.$version2;
          $todayTemplate = 'v3:'.$version3;
          $prevDayTemplate = 'v2:'.$version2; 
      }
      
      foreach($_POST['home_page_image'] as $version => $val){
            foreach($_POST['home_page_image'][$version] as $key => $img){
		$image = $img;
                if($_FILES["image"]['name'][$version][$key] != ''){
                    $_FILES["image"]['name'][$version][$key] = str_replace(' ','-',$_FILES["image"]['name'][$version][$key] );
                    move_uploaded_file($_FILES["image"]["tmp_name"][$version][$key], "../images/home_page/" . $_FILES["image"]['name'][$version][$key]);				
                    $image = tep_db_prepare_input($_FILES["image"]["name"][$version][$key]);
                    if(is_file("../images/home_page/" . $_FILES["image"]["name"][$version][$key])){
                        $image = "images/home_page/" . $_FILES["image"]["name"][$version][$key];
                    }
                }
                $url = tep_db_prepare_input($_POST['home_page_url'][$version][$key]);
                $caption1 = tep_db_prepare_input($_POST['home_page_caption'][$version][$key]);
             //  $template = tep_db_prepare_input($_POST['template_version'][$version][$key]);
                if($version == 'v1'){
                    $template_id = $version1;
                }elseif($version == 'v2'){
                    $template_id = $version2;
                }elseif($version == 'v3'){
                    $template_id = $version3;
                }
                tep_db_query("update homepage_template set template_id = '".$template_id."', image_url = '".$url."',text_caption ='".$caption1."', image = '".$image."' where image_no = 'img".$key."' and version_id = '".$version."'");
			
            }
        }
        tep_db_query("UPDATE `configuration` SET `configuration_value`= '".$templateSet."', `last_modified`= now() WHERE  `configuration_key` = 'HOMEPAGE_TEMPLATE_ACTIVE'");
        tep_db_query("UPDATE `configuration` SET `configuration_value`= '".$todayTemplate."', `last_modified`= now() WHERE  `configuration_key` = 'HOMEPAGE_TEMPLATE_CURR_DAY'");
        tep_db_query("UPDATE `configuration` SET `configuration_value`= '".$prevDayTemplate."', `last_modified`= now() WHERE  `configuration_key` = 'HOMEPAGE_TEMPLATE_PREV_DAY'");
        tep_redirect(tep_href_link('define_home_page_images.php'));
        break;	 
		 
      
    }
  }
   define('MAX_DISPLAY_PR_RESULTS' ,'50');
   $version_array = array();
   $template_array = array();
  $getdataquery = tep_db_query("SELECT *  FROM `homepage_template` ");
  while($getdata = tep_db_fetch_array($getdataquery)){
      $template_array[$getdata['version_id']] = $getdata['template_id'];
      if($getdata['image_no'] == 'img1')
      $version_array[$getdata['version_id']]['1'] = array('img'=>$getdata['image'],'url'=>$getdata['image_url'],'text'=> $getdata['text_caption']);
      if($getdata['image_no'] == 'img2')
      $version_array[$getdata['version_id']]['2'] = array('img'=>$getdata['image'],'url'=>$getdata['image_url'],'text'=>$getdata['text_caption']);
      if($getdata['image_no'] == 'img3')
      $version_array[$getdata['version_id']]['3'] = array('img'=>$getdata['image'],'url'=>$getdata['image_url'],'text'=>$getdata['text_caption']);
      if($getdata['image_no'] == 'img4')
      $version_array[$getdata['version_id']]['4'] = array('img'=>$getdata['image'],'url'=>$getdata['image_url'],'text'=>$getdata['text_caption']);
        
     }
  
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
	<td width="100%" valign="top"><form name="home_page_images" method="post" enctype="multipart/form-data" action="<?php echo tep_href_link('define_home_page_images.php','action=save');?>"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">Define Home Page Images</td>
            
          </tr>
		 <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>  
        </table></td>
      </tr>
      <tr>
          
                <td>
                  Template #1   
                </td>
      </tr>
       <tr>
                <td>
                   <table width="100%"><tr><td width="10%">
                   <img src="images/thumbnail2.jpg"> </td><td>
                   <table  width="50%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td  class="main"><b>Name (Width x Height)</b></td>  
                        </tr>
                        <tr>
                            <td  class="main">Image 1 (420x530)</td>                         
                        </tr>
                        <tr>
                            <td  class="main">Image 2 (380x160)</td>                          
                        </tr>
                        <tr>
                            <td  class="main">Image 3 (380x160)</td>                         
                        </tr>
                        <tr>
                            <td  class="main">Image 4 (380x160)</td>                          
                        </tr>
                    </table></td></tr></table>
                </td>
                
            </tr> 
             <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
       <tr>
          
                <td >
                  Template #2   
                </td>
      </tr>
       <tr>
                <td>
                   <table width="100%"><tr><td width="10%">
                   <img src="images/thumbnail1.jpg"> 
                   </td><td>
                    <table width="50%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="main" ><b>Name (Width x Height)</b></td>
                        </tr>
                        <tr>
                            <td class="main" >Image 1 (800x280)</td>
                        </tr>
                        <tr>
                            <td class="main" >Image 2 (260x220)</td>
                        </tr>
                        <tr>
                            <td class="main" >Image 3 (260x220)</td>   
                        </tr>
                        <tr>
                            <td class="main" >Image 4 (260x220)</td>
                        </tr>
                    </table></td></tr></table>
                </td> 
                
            </tr>    
       <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
       <tr><td><table>
       <tr width="100%">
           <td><b>TEMPLATE VERSION #1</b>&nbsp;&nbsp;
               <?php 
               $Versiontempalte = explode(':', HOMEPAGE_TEMPLATE_CURR_DAY);
               $version = $Versiontempalte[0];
               
               $t1v1checked = '';
               $t2v1checked = '';    
               if($template_array['v1'] == 't2'){
                   $t2v1checked = ' checked ';
               }else{
                   $t1v1checked = ' checked ';
               }
               ?>
           <input type="radio" name="template_version1" value="t1" <?php echo $t1v1checked; ?> > Template #1  or
           <input type="radio" name="template_version1" value="t2" <?php echo $t2v1checked; ?> > Template #2  
           <input type="radio" name="today_selection" value="v1" <?php echo ($version == 'v1' ?' checked ':''); ?> > Today 
               </td>
       </tr>
      <tr>
<td width="100%">
    
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="main"><?php echo 'Image #1 Filename:'; ?>
                </td>
                <td class="main"><input type="text" value="<?php echo $version_array['v1']['1']['img']; ?>" id="home_page_image_1" size="80" name="home_page_image[v1][1]"><input type="file" name="image[v1][1]"></td>
            </tr>
            <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #1 Text Caption'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v1']['1']['text']; ?>"  type="text" id="home_page_caption_1" size="80" name="home_page_caption[v1][1]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #1 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v1']['1']['url']; ?>"  type="text" id="home_page_url_1" size="80" name="home_page_url[v1][1]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #2 Filename:'; ?></td>
                  <td class="main"><input type="text" value="<?php echo $version_array['v1']['2']['img']; ?>"  id="home_page_image_2" size="80" name="home_page_image[v1][2]"><input type="file" name="image[v1][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr> 
              <tr>
                  <td class="main"><?php echo 'Image #2 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v1']['2']['text']; ?>"  type="text" id="home_page_caption_2" size="80" name="home_page_caption[v1][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #2 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v1']['2']['url']; ?>"  type="text" id="home_page_url_2" size="80" name="home_page_url[v1][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 Filename:'; ?></td>
                  <td class="main"><input type="text"  value="<?php echo $version_array['v1']['3']['img']; ?>" id="home_page_image_3" size="80" name="home_page_image[v1][3]"><input type="file" name="image[v1][3]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v1']['3']['text'];?>"  type="text" id="home_page_caption_3" size="80" name="home_page_caption[v1][3]"></td>          
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v1']['3']['url'];?>"  type="text" id="home_page_url_3" size="80" name="home_page_url[v1][3]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #4 Filename:'; ?></td>
                  <td class="main"><input type="text"  value="<?php echo $version_array['v1']['4']['img']; ?>" id="home_page_image_4" size="80" name="home_page_image[v1][4]"><input type="file" name="image[v1][4]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr>
              <tr>
                  <td class="main"><?php echo 'Image #4 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v1']['4']['text']; ?>"  type="text" id="home_page_caption_4" size="80" name="home_page_caption[v1][4]"></td>          
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #4 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v1']['4']['url']; ?>"  type="text" id="home_page_url_4" size="80" name="home_page_url[v1][4]"></td>
              </tr>            
            </table>
        </td>
      </tr>
    </table>
</td>
</tr>
       <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
       <tr><td><table>
       <tr>
           <td><b>TEMPLATE VERSION #2</b>&nbsp;&nbsp;
               <?php 
               $t1v2checked = '';
               $t2v2checked = '';    
               if($template_array['v2'] == 't2'){
                   $t2v2checked = ' checked ';
               }else{
                   $t1v2checked = ' checked ';
               }
               ?>
                <input type="radio" name="template_version2" value="t1" <?php echo $t1v2checked; ?> > Template #1  or
                <input type="radio" name="template_version2" value="t2" <?php echo $t2v2checked; ?> > Template #2 
                <input type="radio" name="today_selection" value="v2" <?php echo ($version=='v2'?' checked ':''); ?> > Today
            </td>
       </tr>
      <tr>
<td width="100%">
    
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="main"><?php echo 'Image #1 Filename:'; ?>
                </td>
                <td class="main"><input type="text" value="<?php echo $version_array['v2']['1']['img']; ?>" id="home_page_image_1" size="80" name="home_page_image[v2][1]"><input type="file" name="image[v2][1]"></td>
            </tr>
            <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #1 Text Caption'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v2']['1']['text']; ?>"  type="text" id="home_page_caption_1" size="80" name="home_page_caption[v2][1]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #1 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v2']['1']['url']; ?>"  type="text" id="home_page_url_1" size="80" name="home_page_url[v2][1]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #2 Filename:'; ?></td>
                  <td class="main"><input type="text" value="<?php echo $version_array['v2']['2']['img']; ?>"  id="home_page_image_2" size="80" name="home_page_image[v2][2]"><input type="file" name="image[v2][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr> 
              <tr>
                  <td class="main"><?php echo 'Image #2 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v2']['2']['text']; ?>"  type="text" id="home_page_caption_2" size="80" name="home_page_caption[v2][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #2 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v2']['2']['url']; ?>"  type="text" id="home_page_url_2" size="80" name="home_page_url[v2][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 Filename:'; ?></td>
                  <td class="main"><input type="text"  value="<?php echo $version_array['v2']['3']['img']; ?>" id="home_page_image_3" size="80" name="home_page_image[v2][3]"><input type="file" name="image[v2][3]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v2']['3']['text']; ?>"  type="text" id="home_page_caption_3" size="80" name="home_page_caption[v2][3]"></td>          
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v2']['3']['url']; ?>"  type="text" id="home_page_url_3" size="80" name="home_page_url[v2][3]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #4 Filename:'; ?></td>
                  <td class="main"><input type="text"  value="<?php echo $version_array['v2']['4']['img']; ?>" id="home_page_image_4" size="80" name="home_page_image[v2][4]"><input type="file" name="image[v2][4]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr>
              <tr>
                  <td class="main"><?php echo 'Image #4 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v2']['4']['text'];?>"  type="text" id="home_page_caption_4" size="80" name="home_page_caption[v2][4]"></td> 
                  <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
                  <tr>
                  <td class="main"><?php echo 'Image #4 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v2']['4']['url']; ?>"  type="text" id="home_page_url_4" size="80" name="home_page_url[v2][4]"></td>
              </tr>
              
              
                </table>
</td>
      </tr>
               </table></td></tr>
       <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
       <tr><td><table>
       <tr>
           <td><b>TEMPLATE VERSION #3</b>&nbsp;&nbsp;
                <?php 
               $t1v3checked = '';
               $t2v3checked = '';    
               if($template_array['v3'] == 't2'){
                   $t2v3checked = ' checked ';
               }else{
                   $t1v3checked = ' checked ';
               }
               ?>
           <input type="radio" name="template_version3" value="t1" <?php echo $t1v3checked; ?> > Template #1  or
           <input type="radio" name="template_version3" value="t2" <?php echo $t2v3checked; ?> > Template #2 
           <input type="radio" name="today_selection" value="v3" <?php echo ($version=='v3'?' checked ':''); ?> > Today
               </td>
       </tr>
      <tr>
<td width="100%">
    
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="main"><?php echo 'Image #1 Filename:'; ?>
                </td>
                <td class="main"><input type="text" value="<?php echo $version_array['v3']['1']['img']; ?>" id="home_page_image_1" size="80" name="home_page_image[v3][1]"><input type="file" name="image[v3][1]"></td>
            </tr>
            <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #1 Text Caption'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v3']['1']['text'];?>"  type="text" id="home_page_caption_1" size="80" name="home_page_caption[v3][1]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #1 URL'; ?></td>
              <td class="main"><input value="<?php echo $version_array['v3']['1']['url'];?>"  type="text" id="home_page_url_1" size="80" name="home_page_url[v3][1]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #2 Filename:'; ?></td>
                  <td class="main"><input type="text" value="<?php echo $version_array['v3']['2']['img']; ?>"  id="home_page_image_2" size="80" name="home_page_image[v3][2]"><input type="file" name="image[v3][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr> 
              <tr>
                  <td class="main"><?php echo 'Image #2 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v3']['2']['text']; ?>"  type="text" id="home_page_caption_2" size="80" name="home_page_caption[v3][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #2 URL'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v3']['2']['url'];?>"  type="text" id="home_page_url_2" size="80" name="home_page_url[v3][2]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 Filename:'; ?></td>
                  <td class="main"><input type="text"  value="<?php echo $version_array['v3']['3']['img']; ?>" id="home_page_image_3" size="80" name="home_page_image[v3][3]"><input type="file" name="image[v3][3]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v3']['3']['text']; ?>"  type="text" id="home_page_caption_3" size="80" name="home_page_caption[v3][3]"></td>          
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #3 URL'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v3']['3']['url']; ?>"  type="text" id="home_page_url_3" size="80" name="home_page_url[v3][3]"></td>          
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #4 Filename:'; ?></td>
                  <td class="main"><input type="text"  value="<?php echo $version_array['v3']['4']['img']; ?>" id="home_page_image_4" size="80" name="home_page_image[v3][4]"><input type="file" name="image[v3][4]"></td>
              </tr>
              <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td></tr>
              <tr>
                  <td class="main"><?php echo 'Image #4 Text Caption'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v3']['4']['text']; ?>"  type="text" id="home_page_caption_4" size="80" name="home_page_caption[v3][4]"></td>          
              </tr>
               <tr><td colspan="2"><img width="1" border="0" height="10" alt="" src="images/pixel_trans.gif">
                  </td> </tr>
              <tr>
                  <td class="main"><?php echo 'Image #4 URL'; ?></td>
                  <td class="main"><input value="<?php echo $version_array['v3']['4']['url'];?>"  type="text" id="home_page_url_4" size="80" name="home_page_url[v3][4]"></td>          
              </tr>
             
                </table>
</td>
      </tr>
               </table></td></tr>
      <tr>

                <td align="right"><?php echo tep_image_submit('button_save.gif', IMAGE_SAVE).'&nbsp;'. ' <a href="' . tep_href_link('define_home_page_images.php').'">'. tep_image_button('button_cancel.gif', IMAGE_CANCEL);?></a></td>
               
              </tr>
            </table> </form></td>
          </tr>
        
	  
    </table></td>
	

<?php
  $heading = array();
  $contents = array();

  
  
?>
<?php
            if ( (tep_not_null($heading)) || (tep_not_null($contents)) ) {
    echo '            <td valign="top">' ;


    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' ;
  }
            ?>
			</table></td>
      </tr>
  </tr>
  
</table>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>