<?php
/*
  $Id: define_homepage_images.php@author: hardik@focusindia.com
  osCommerce, Open Source E-Commerce Solutions
  
*/
  require('includes/application_top.php');
$categoryNameArray = array(
      'A' => 'Assortment',
      'C' => 'Cut & Polished Crystals',
      'J' => 'Crystal Jewelry',
      'N' => 'Natural Crystals & Minerals',
      'NQ' => 'Quartz Crystals',
      'T' => 'Tumbled Stones / Gemstones',
      'V' => 'Other / Accessories'
    );
$categoryFolderArray = array(
      'A' => 'Assortments',
      'C' => 'Cut&Polished',
      'J' => 'Jewelry',
      'N' => 'Natural',
      'NQ' => 'Quartz',
      'T' => 'Tumbled',
      'V' => 'Accessories'
    );	
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

$category_array = array();
foreach ($categoryNameArray as $letter => $name) {
		$category_array[] = array('id' => $letter,'text' => $name);
}
if($HTTP_GET_VARS['cat'] == '')$HTTP_GET_VARS['cat'] = 'A';
 $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
   
    if (tep_not_null($action)) {

    switch ($action) {
	
      case 'insert':
      case 'save':
	    if (isset($HTTP_GET_VARS['homepage_images_id'])) $homepage_images_id = tep_db_prepare_input($HTTP_GET_VARS['homepage_images_id']);
        $category_letter = tep_db_prepare_input($HTTP_POST_VARS['category_letter']);
		$sort_order = tep_db_prepare_input($HTTP_POST_VARS['sort_order']);
		
			if($_FILES["image_url"]['name'] != ''){
				 move_uploaded_file($_FILES["image_url"]["tmp_name"], "../images/homepage/" . $categoryFolderArray[$HTTP_GET_VARS['cat']] . '/' . $_FILES["image_url"]["name"]);
				// move_uploaded_file($_FILES["image_url"]["tmp_name"], "../images/homepage/" . $_FILES["image_url"]["name"]);				
			}
			$image_url = tep_db_prepare_input($HTTP_POST_VARS['image_url']);
			if(is_file("../images/homepage/" . $categoryFolderArray[$HTTP_GET_VARS['cat']] . '/' . $_FILES["image_url"]["name"])){
				
				$image_url = "images/homepage/" . $categoryFolderArray[$HTTP_GET_VARS['cat']] . '/' . $_FILES["image_url"]["name"];
				add_water_mark($image_url);
			}
			if($image_url == ''){
				$image_url = tep_db_prepare_input($HTTP_POST_VARS['old_image_url']);
			}
				
        $sql_data_array = array('category_letter' => $HTTP_GET_VARS['cat'],
        						'image_url' => $image_url,
								'sort_order' => $sort_order);
								       
		
		if ($action == 'insert') {
		  tep_db_perform('homepage_images', $sql_data_array);
          $homepage_images_id = tep_db_insert_id();
        
		} elseif ($action == 'save') {  
        	
        tep_db_perform('homepage_images', $sql_data_array, 'update', "homepage_images_id = '" . (int)$homepage_images_id . "'");       
		}
        
        tep_redirect(tep_href_link('define_homepage_images.php', (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'homepage_images_id=' . $homepage_images_id . '&cat=' . $HTTP_GET_VARS['cat']));
        break;	 
		 
      case 'deleteconfirm':
        $homepage_images_id = tep_db_prepare_input($HTTP_GET_VARS['homepage_images_id']);
        tep_db_query("delete from homepage_images where homepage_images_id = '" . (int)$homepage_images_id . "'");		tep_redirect(tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page']));				
	    break;
	  
	  default:
	    if(isset($HTTP_GET_VARS['homepage_images_id']) && $HTTP_GET_VARS['homepage_images_id'] > 0){
			$homepage_images = array();
			$homepage_images_query = tep_db_query("select * from homepage_images where homepage_images_id='" . $HTTP_GET_VARS['homepage_images_id'] . "'");
    
			$homepage_images = tep_db_fetch_array($homepage_images_query);

      		$bInfo = new objectInfo($homepage_images);   
		}
		break;
    }
  }
   define('MAX_DISPLAY_PR_RESULTS' ,'50');
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
	<td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">Category Images</td>
            <td class="pageHeading" align="right">&nbsp;</td>
          </tr>
		  <tr>
            <td class="pageHeading" colspan="2" align="right">
				<?php echo tep_draw_pull_down_menu('cat', $category_array, $HTTP_GET_VARS['cat'], 'onchange="location.href=\'' . tep_href_link('define_homepage_images.php', tep_get_all_get_params(array('cat')) . 'cat=') . '\'+this.value;"'); ?>
			</td>
		  </tr>
        </table></td>
      </tr>
      <tr>
<?php   

?>
<?php if($action == 'edit'){ 
$heading_edit[] = array('text' => '<b>Edit Category Image</b>');
      

      $contents_edit = array('form' => tep_draw_form('homepage_images', 'define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->homepage_images_id . '&action=save' . '&cat=' . $HTTP_GET_VARS['cat'], 'post', 'enctype="multipart/form-data"'));		      
	  //$contents_edit[] = array('text' => 'Category Name: <br>' .  tep_draw_input_field('category_letter',$bInfo->category_letter,' size="75"'));
	  
	  $contents_edit[] = array('text' => '<br>Category Image:	<br>' .  tep_draw_file_field('image_url') . tep_draw_hidden_field('old_image_url',$bInfo->image_url) .'<br>' );
	   
	  
	  if(isset($bInfo->image_url)){
	  $contents_edit[] = array('text' => '<br>Current Image:	<br>' . tep_image('../'.$bInfo->image_url,'Background Image' ,150,150));
	  }
	  $contents_edit[] = array('text' => 'Sort Order: <br>' .  tep_draw_input_field('sort_order',$bInfo->sort_order,''));
	  
           
      $contents_edit[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->homepage_images_id . '&cat=' . $HTTP_GET_VARS['cat']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a></form>');

	  if ( (tep_not_null($heading_edit)) && (tep_not_null($contents_edit)) ) {
		echo '<td valign="top" width="100%">' ;
		$box = new box;
		echo $box->infoBox($heading_edit, $contents_edit);
		echo '</td>' ;
  	  }
?>
<?php } elseif($action == 'new'){ 
		
      $heading_new[] = array('text' => '<b>New Category Image</b>');

      $contents_new = array('form' => tep_draw_form('homepage_images', 'define_homepage_images.php', 'action=insert' . '&cat=' . $HTTP_GET_VARS['cat'], 'post', 'enctype="multipart/form-data"'));
	  //$contents_new[] = array('text' => '<br>Category Name:<br>' . tep_draw_input_field('category_letter', '', ' size="75"'));      
	    
	  $contents_new[] = array('text' => '<br>Category Image:	<br>' .  tep_draw_file_field('image_url') . '<br>' );  
	  $contents_new[] = array('text' => 'Sort Order: <br>' .  tep_draw_input_field('sort_order',$bInfo->sort_order,''));
	  $contents_new[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $HTTP_GET_VARS['homepage_images_id'] . '&cat=' . $HTTP_GET_VARS['cat']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a></form>');
	  if ( (tep_not_null($heading_new)) && (tep_not_null($contents_new)) ) {
    	echo '<td valign="top" width="100%">' ;
    	$box = new box;
		echo $box->infoBox($heading_new, $contents_new);
    	echo '</td>' ;
  	  }

?>


<?php } else{ ?>
    <!--<td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">Category Images</td>
            <td class="pageHeading" align="right">&nbsp;</td>
          </tr>
		  <tr>
            <td class="pageHeading">
				<?php //echo tep_draw_pull_down_menu('cat', $category_array, $HTTP_GET_VARS['cat'], 'onchange="location.href=\'' . tep_href_link('define_homepage_images.php', tep_get_all_get_params(array('cat')) . 'cat=') . '\'+this.value;"'); ?>
			</td>
		  </tr>
        </table></td>
      </tr>
      <tr>-->
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="2">
              <tr class="dataTableHeadingRow">
               <?php //if($HTTP_GET_VARS['sort'] == 'ASC'){$new_sort = 'DESC';}else{$new_sort = 'ASC';}?>
                
                <td class="dataTableHeadingContent"><?php echo 'Category Image'; ?></td>
				<td class="dataTableHeadingContent"><?php echo 'Sort Order'; ?></td>
				<td class="dataTableHeadingContent" align="right">Action&nbsp;</td>               
              </tr>
<?php
/*if(isset($HTTP_GET_VARS['orderby'])) $orderby = tep_db_prepare_input($HTTP_GET_VARS['orderby']);
if(isset($HTTP_GET_VARS['sort'])) $sort = tep_db_prepare_input($HTTP_GET_VARS['sort']);
if(!$orderby) $orderby = 'date_added';
if(!$sort) $sort = 'DESC';
if($orderby == 'category_letter') {
	$db_orderby = 'category_letter ' . $sort;
} elseif($orderby == 'date_added') {
	$db_orderby = 'date_added ' . $sort;
}*/
  $homepage_images_query_raw = "select * from homepage_images where category_letter = '" . $HTTP_GET_VARS['cat'] . "' order by homepage_images_id";
  $homepage_images_split = new splitPageResults($HTTP_GET_VARS['page'], 50,$homepage_images_query_raw, $homepage_images_query_numrows);
  
  $homepage_images_query = tep_db_query($homepage_images_query_raw);
  while($homepage_images = tep_db_fetch_array($homepage_images_query))
  {  
     if ((!isset($HTTP_GET_VARS['homepage_images_id']) || (isset($HTTP_GET_VARS['homepage_images_id']) && ($HTTP_GET_VARS['homepage_images_id'] == $homepage_images['homepage_images_id']))) && !isset($bInfo) && (substr($action, 0, 3) != 'new')) {
      $bInfo = new objectInfo($homepage_images);
    }
	
	
    if (isset($HTTP_GET_VARS['homepage_images_id']) && ($homepage_images['homepage_images_id'] == $HTTP_GET_VARS['homepage_images_id'])) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $homepage_images['homepage_images_id'] . '&cat=' . $HTTP_GET_VARS['cat']) . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $homepage_images['homepage_images_id'] . '&cat=' . $HTTP_GET_VARS['cat']) . '\'">' . "\n";
    }
?>
                
				<td class="dataTableContent">
					<?php echo tep_image('../'.$homepage_images['image_url'],'Category Image' ,50,50);
					 ?>
				</td>
				<td class="dataTableContent">
					<?php echo $homepage_images['sort_order']; ?>
				</td>
				<td class="dataTableContent" align="right"><?php if (isset($bInfo) && is_object($bInfo) && ($homepage_images['homepage_images_id'] == $bInfo->homepage_images_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $homepage_images['homepage_images_id'] . '&cat=' . $HTTP_GET_VARS['cat']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
				
<?php
  
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top" colspan="3"><?php echo $homepage_images_split->display_count($homepage_images_query_numrows, 50, $HTTP_GET_VARS['page'], 'Displaying %d to %d (of %d results)'); ?></td>
                <td class="smallText" align="right" colspan="2"><?php echo $homepage_images_split->display_links($homepage_images_query_numrows, MAX_DISPLAY_PR_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page'))); ?>&nbsp;</td>
					
					
                  </tr>
                </table></td>
              </tr>

            </table></td>
          </tr>
        <!--</table></td>
      </tr>-->
	  <?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo '<a href="' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->homepage_images_id . '&cat=' . $HTTP_GET_VARS['cat'] . '&action=new') . '">' . tep_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
              </tr>
<?php
  }
?>
    </table></td>
	<?php } ?>
<!-- body_text_eof //-->
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
	case 'new':
      break;
	  
    case 'edit':
      
      break;
	  
    case 'delete':
      $heading[] = array('text' => '<b>Delete Category Image</b>');

      $contents = array('form' => tep_draw_form('homepage_images', 'define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->homepage_images_id . '&action=deleteconfirm' . '&cat=' . $HTTP_GET_VARS['cat']));
      $contents[] = array('text' => 'Are you sure, you want to delete following category image.');
      //$contents[] = array('text' => '<br><b>' . $bInfo->category_letter . '</b>');
	  $contents[] = array('text' => '<br>Current Image:	<br>' . tep_image('../'.$bInfo->image_url,'Category Image' ,150,150));     
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->homepage_images_id . '&cat=' . $HTTP_GET_VARS['cat']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
	  
    default:
      if (isset($bInfo) && is_object($bInfo)) {
	  	
        //$heading[] = array('text' => '<b>' . $bInfo->category_letter . '</b>');        
		
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->homepage_images_id . '&action=edit' . '&cat=' . $HTTP_GET_VARS['cat']) . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link('define_homepage_images.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->homepage_images_id . '&action=delete' . '&cat=' . $HTTP_GET_VARS['cat']) . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
		
		 //$contents[] = array('text' => '<b>' . $bInfo->category_letter . '</b>');
		if(isset($bInfo->image_url)){
	 	  $contents[] = array('text' => '<br>Current Image:	<br>' . tep_image('../'.$bInfo->image_url,'Category Image' ,150,150));
	    }
	    
      }
      break;
  }

  
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
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>