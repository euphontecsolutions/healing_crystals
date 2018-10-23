<?php
/*
  $Id: intro_slider.php@author: Euphontec
  osCommerce, Open Source E-Commerce Solutions
  
*/
  require('includes/application_top.php');
  require_once('fckeditor/fckeditor.php');


 $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
   
    if (tep_not_null($action)) {

    switch ($action) {
	
      case 'insert':
      case 'save':
	    if (isset($HTTP_GET_VARS['homepage_images_id'])) $homepage_images_id = tep_db_prepare_input($HTTP_GET_VARS['homepage_images_id']);

		$sort_order  = tep_db_prepare_input($HTTP_POST_VARS['sort_order']);
		$slider_text = tep_db_prepare_input($HTTP_POST_VARS['slider_text']);
/*			if($_FILES["image_url"]['name'] != ''){
				 move_uploaded_file($_FILES["image_url"]["tmp_name"], "../images_heal_new/homepage/" . $_FILES["image_url"]["name"]);
			}
			$image_url = tep_db_prepare_input($HTTP_POST_VARS['image_url']);
			if(is_file("../images_heal_new/homepage/" . $_FILES["image_url"]["name"])){
				
				$image_url = "images_heal_new/homepage/"  . $_FILES["image_url"]["name"];
			}
			if($image_url == ''){
				$image_url = tep_db_prepare_input($HTTP_POST_VARS['old_image_url']);
			}*/
				
        $sql_data_array = array(
						'is_sort'  => $sort_order,
						'is_text' => $slider_text
					);
								       

		if ($action == 'insert') {
		  tep_db_perform('intro_slider', $sql_data_array);
          $homepage_images_id = tep_db_insert_id();

          $sql_data_next_array = array(
            'master_is_id' => $homepage_images_id,
            'is_sort'  => $sort_order,
            'is_text' => $slider_text,
            'version_number' => 0,
            'user'=>$_SESSION['login_first_name']
          );
      tep_db_perform('intro_slider_version', $sql_data_next_array);

		} elseif ($action == 'save') {  
        	
        tep_db_perform('intro_slider', $sql_data_array, 'update', "is_id = '" . (int)$homepage_images_id . "'");
        $version = tep_db_query("select version_number from intro_slider_version where master_is_id='" . $HTTP_GET_VARS['homepage_images_id'] . "'");
        $largest = 0;
        while($data=mysqli_fetch_array($version)) {
          if($data['version_number'] > $largest) {
            $largest = $data['version_number'];
          }
        }
        $largest += 1; 
          $sql_data_next_array = array(
            'master_is_id' => $homepage_images_id,
            'is_sort'  => $sort_order,
            'is_text' => $slider_text,
            'version_number' => $largest,
            'user'=>$_SESSION['login_first_name']
          );
         tep_db_perform('intro_slider_version', $sql_data_next_array);
		}
        
        tep_redirect(tep_href_link('intro_slider.php', (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'homepage_images_id=' . $homepage_images_id));
        break;	 
		 
      case 'deleteconfirm':
        $homepage_images_id = tep_db_prepare_input($HTTP_GET_VARS['homepage_images_id']);
        tep_db_query("delete from intro_slider where is_id = '" . (int)$homepage_images_id . "'");
        tep_db_query("delete from intro_slider_version where master_is_id = '" . (int)$homepage_images_id . "'");
        	tep_redirect(tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page']));				
	    break;
	  
	  default:
	    if(isset($HTTP_GET_VARS['homepage_images_id']) && $HTTP_GET_VARS['homepage_images_id'] > 0){
			$homepage_images = array();
			$homepage_images_query = tep_db_query("select * from intro_slider where is_id='" . $HTTP_GET_VARS['homepage_images_id'] . "'");
    
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
<style>
/*	.infoBoxContent{
	font-family: Verdana, Arial, sans-serif;
    font-size: 12px;
    color: #000000;
    background-color: #F8F8F9;
    width: 100%;
	}*/



	input[type="number"] {
	width: 60px;
    border-radius: 4px;
    border:1px solid #6d6262;
     
	}

	input[type="image"] {
		margin-top: initial;
		margin-left: inherit;
		margin-bottom: inherit;
	}

	.new {
		margin-left: 10vw;

	}
</style>

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
            <td class="pageHeading">Intro Slider</td>

            <td class="pageHeading" align="right">&nbsp;</td>
          </tr>
          <tr><?php  if ($action=='edit') { ?>
			<td>
			<?= "<br/>Slider Revisions:";?>
			</td>
			<?php } ?>
          </tr>
		 <!--  <tr> -->
<!--             <td class="pageHeading" colspan="2" align="right">
				<?php echo tep_draw_pull_down_menu('onchange="location.href=\'' . tep_href_link('intro_slider.php')); ?>
			</td> -->
		<!--   </tr> -->

        </table></td>
      </tr>

      <tr>
<?php   

?>
<?php if($action == 'edit'){ 
$heading_edit[] = array('text' => '<b>Edit Slider</b>');
	

    $slider_images_query = tep_db_query("select * from intro_slider_version where master_is_id='" . $HTTP_GET_VARS['homepage_images_id'] . "'" );
    $slider_images  = tep_db_fetch_array($slider_images_query);
    $cInfo          = new objectInfo($slider_images);  
    $versions       = tep_db_query("select * from intro_slider_version where master_is_id='" . $HTTP_GET_VARS['homepage_images_id'] . "'");
    $num_rows = mysqli_num_rows($versions);
    

  if($HTTP_GET_VARS['show']!= 'all_rev' && $num_rows>=5) {

    echo '<tr><td class="main" style="padding:5px;"><a style="text-decoration:underline;color:#0000ff" href="'. tep_href_link('intro_slider.php', tep_get_all_get_params(). 'show=all_rev') .'">See Older Versions</a></td></tr>';

    while($row = mysqli_fetch_array($versions)) {
      $version_num =  $row['version_number'];
      $version_num += 1;
        if($row['version_number'] >= 4) {
      echo '<tr><td class="main"><input type="radio" name="loadRevision" onclick="document.getElementById(\'editor1\').innerHTML=\''.callback(htmlspecialchars($row['is_text'])).'\';CKEDITOR.instances.editor1.setData(\''.callback(htmlspecialchars($row['is_text'])).'\')"/>Version# '.$version_num.' saved by '.$row['user'] .' on '.  $row['is_date'].'</td></tr>';
        
        }
      }     


    }
	else if ($HTTP_GET_VARS['show'] == 'all_rev' || $num_rows < 5) {
		while($row = mysqli_fetch_array($versions)) {
      $version_num =  $row['version_number'];
      $version_num += 1;
			echo '<tr><td class="main"><input type="radio" name="loadRevision" onclick="document.getElementById(\'editor1\').innerHTML=\''.callback(htmlspecialchars($row['is_text'])).'\';CKEDITOR.instances.editor1.setData(\''.callback(htmlspecialchars($row['is_text'])).'\')"/>Version# '.$version_num.' saved by '.$row['user'] .' on '.  $row['is_date'].'</td></tr>';
			
			
		}
	}
    $version = $_GET['version'];
    if(isset($version)){
      $slider_images_query = tep_db_query("select * from intro_slider_version where master_is_id='" . $HTTP_GET_VARS['homepage_images_id'] . "' and version_number = '".$version."'" );

      $slider_images = tep_db_fetch_array($slider_images_query);

      $cInfo = new objectInfo($slider_images);
      $bInfo->is_sort  = $cInfo->is_sort;
      $bInfo->is_text = $cInfo->is_text;

    }

    


    $contents_edit = array('form' => tep_draw_form('intro_slider', 'intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->is_id . '&action=save' , 'post'));		      
	  //$contents_edit[] = array('text' => 'Category Name: <br>' .  tep_draw_input_field('category_letter',$bInfo->category_letter,' size="75"'));
	  

    $contents_edit[] = array('text' => '<h3>Text Area:</h3>' . '<textarea id="editor1" class="ckeditor" name="slider_text">'.$bInfo->is_text.'</textarea>');
	  

	  $contents_edit[] = array('text' => '<h3>Sort Order: </h3>' .  '<input class="new" id="numeral" type="number" min="0" name="sort_order" value="'.$bInfo->is_sort.'">');
	  
           
      $contents_edit[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->is_id ) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a></form>');

	  if ( (tep_not_null($heading_edit)) && (tep_not_null($contents_edit)) ) {
		echo '<td valign="top" width="100%">' ;
		$box = new box;
		echo $box->infoBox($heading_edit, $contents_edit);
		echo '</td>' ;
  	  }

?>
<?php } elseif($action == 'new'){ 
		
      $heading_new[] = array('text' => '<b>New Slider Image</b>');

      $contents_new = array('form' => tep_draw_form('intro_slider', 'intro_slider.php', 'action=insert' , 'post'));
	  $contents_new[] = array('text' => '<h3>Text Area:</h3>' . '<textarea id="editor1" class="ckeditor new" name="slider_text"></textarea>');
	    
/* 	  $contents_new[] = array('text' => '<h3>Slider Image:</h3>	' .  '<input class="new" type="file" name="image_url">' . '' );  */ 
	  $contents_new[] = array('text' => '<h3>Sort Order:</h3> ' .  '<input class="new" type="number" min="0" name="sort_order" value="0">');
	  $contents_new[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $HTTP_GET_VARS['homepage_images_id']) . '&action=edit">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a></form>');
	  if ( (tep_not_null($heading_new)) && (tep_not_null($contents_new)) ) {
    	echo '<td valign="top" width="100%">' ;
    	$box = new box;
		echo $box->infoBox($heading_new, $contents_new);
    	echo '</td>';
  	  }

?>


<?php } else{ ?>
    <!--<td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">Slider Images</td>
            <td class="pageHeading" align="right">&nbsp;</td>
          </tr>
		  <tr>
            <td class="pageHeading">
				<?php //echo tep_draw_pull_down_menu('cat', $category_array, $HTTP_GET_VARS['cat'], 'onchange="location.href=\'' . tep_href_link('intro_slider.php', tep_get_all_get_params(array('cat')) . 'cat=') . '\'+this.value;"'); ?>
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
                
                <!-- <td class="dataTableHeadingContent"><?php /* echo 'Slider Image';  */?></td> -->
				<td class="dataTableHeadingContent" style="max-width: 30%;"><?php echo 'Slider Text'; ?></td>
				<!-- <td class="dataTableHeadingContent"><?php echo 'Sort Order'; ?></td> -->
				<td class="dataTableHeadingContent" align="right">Action&nbsp;</td>               
              </tr>
<?php
if(isset($HTTP_GET_VARS['orderby'])) $orderby = tep_db_prepare_input($HTTP_GET_VARS['orderby']);
if(isset($HTTP_GET_VARS['sort'])) $sort = tep_db_prepare_input($HTTP_GET_VARS['sort']);
if(!$orderby) $orderby = 'date_added';
if(!$sort) $sort = 'DESC';
if($orderby == 'category_letter') {
	$db_orderby = 'category_letter ' . $sort;
} elseif($orderby == 'date_added') {
	$db_orderby = 'date_added ' . $sort;
}
  $homepage_images_query_raw = "select * from intro_slider";
  $homepage_images_split = new splitPageResults($HTTP_GET_VARS['page'], 50,$homepage_images_query_raw, $homepage_images_query_numrows);
  
  $homepage_images_query = tep_db_query($homepage_images_query_raw);
  while($homepage_images = tep_db_fetch_array($homepage_images_query))
  {  
     if ((!isset($HTTP_GET_VARS['homepage_images_id']) || (isset($HTTP_GET_VARS['homepage_images_id']) && ($HTTP_GET_VARS['homepage_images_id'] == $homepage_images['is_id']))) && !isset($bInfo) && (substr($action, 0, 3) != 'new')) {
      $bInfo = new objectInfo($homepage_images);
    }
	
	
    if (isset($HTTP_GET_VARS['homepage_images_id']) && ($homepage_images['is_id'] == $HTTP_GET_VARS['homepage_images_id'])) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $homepage_images['is_id']) . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $homepage_images['is_id']) . '\'">' . "\n";
    }
?>
                
<!-- 				<td class="dataTableContent">
					<?php /* echo tep_image('../'.$homepage_images['is_image_url'],'Slider Image' ,50,50); */
					 ?>
				</td> -->

				<td class="dataTableContent" style="word-wrap: break-word;max-width: 30%;">
					<?php echo $homepage_images['is_text']; ?>
				</td>
 				<td class="dataTableContent">
	<?php echo $homepage_images['is_sort']; ?>
</td> 
<?php 
      if(isset($_GET['homepage_images_id'])) {
          $var_id = $_GET['homepage_images_id'];
      } else if(!isset($var_id)) {
          $var_id = $homepage_images['is_id'];
      }
   ?>
				<td class="dataTableContent" align="right"><?php if (isset($bInfo) && is_object($bInfo) && ($homepage_images['is_id'] == $var_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $homepage_images['is_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
				
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
                <td align="right" colspan="2" class="smallText"><?php echo '<a href="' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->homepage_images_id . '&action=new') . '">' . tep_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>Delete Slider Image</b>');

      $contents = array('form' => tep_draw_form('intro_slider', 'intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->is_id . '&action=deleteconfirm'));
      $contents[] = array('text' => 'Are you sure, you want to delete following Slider Image.');
      //$contents[] = array('text' => '<br><b>' . $bInfo->category_letter . '</b>');
/*      var_dump($bInfo);
      die();*/
      $contents[] = array('text' => '<br>Current Image:	<br>' . $bInfo->is_text);     
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->is_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
	  
    default:
      if (isset($bInfo) && is_object($bInfo)) {
	  	/*tep_datetime_short*/
      // var_dump($bInfo);
        $heading[] = array('text' => '<b>['.$bInfo->is_id.']&nbsp;&nbsp;'. tep_datetime_short($bInfo->is_date). '</b>');        
		
        $contents[] = array('align' => 'center', 'text' =>  '<br>'.'<a href="' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->is_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a>&nbsp;&nbsp; <a href="' . tep_href_link('intro_slider.php', 'page=' . $HTTP_GET_VARS['page'] . '&homepage_images_id=' . $bInfo->is_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>&nbsp;&nbsp;'.'<a href="'.tep_href_link('slider_preview.php', 'slider_id=' . $bInfo->is_id).'" target="_blank">'.'<button style="margin-top:5px;font-size:14px;">Preview</button>'.'</a>');
       

		
		 //$contents[] = array('text' => '<b>' . $bInfo->category_letter . '</b>');
/*		if(isset($bInfo->is_image_url)){
	 	  $contents[] = array('text' => '<br>Current Image:	<br>' . tep_image('../'.$bInfo->is_image_url,'Slider Image' ,150,150));
	    }*/
	    
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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            if ( window.CKEDITOR )
            {
                (function()
                {
                    var showCompatibilityMsg = function()
                    {
                        var env = CKEDITOR.env;

                        var html = '<p><strong>Your browser is not compatible with CKEditor.</strong>';

                        var browsers =
                            {
                            gecko : 'Firefox 2.0',
                            ie : 'Internet Explorer 6.0',
                            opera : 'Opera 9.5',
                            webkit : 'Safari 3.0'
                        };

                        var alsoBrowsers = '';

                        for ( var key in env )
                        {
                            if ( browsers[ key ] )
                            {
                                if ( env[key] )
                                    html += ' CKEditor is compatible with ' + browsers[ key ] + ' or higher.';
                                else
                                    alsoBrowsers += browsers[ key ] + '+, ';
                            }
                        }

                        alsoBrowsers = alsoBrowsers.replace( /\+,([^,]+), $/, '+ and $1' );

                        html += ' It is also compatible with ' + alsoBrowsers + '.';

                        html += '</p><p>With non compatible browsers, you should still be able to see and edit the contents (HTML) in a plain text field.</p>';

                        var alertsEl = document.getElementById( 'alerts' );
                        alertsEl && ( alertsEl.innerHTML = html );
                    };

                    var onload = function()
                    {
                        // Show a friendly compatibility message as soon as the page is loaded,
                        // for those browsers that are not compatible with CKEditor.
                        if ( !CKEDITOR.env.isCompatible )
                            showCompatibilityMsg();
                    };
                    // Register the onload listener.
                    if ( window.addEventListener )
                        window.addEventListener( 'load', onload, false );
                    else if ( window.attachEvent )
                        window.attachEvent( 'onload', onload );
                })();
            }

        </script>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>