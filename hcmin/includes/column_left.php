<?php
/*
  $Id: column_left.php,v 1.2 2003/09/24 13:57:07 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

//if($_GET['action']=='SearchText'){
 //include_once('application_top.php');
	//$value = $_GET['value'];
	//if($value != ''){
		//$search_query = tep_db_query("select * from admin_ln_files where files_display_name = '".$value."%' order by files_sort_order ASC");
		//$content !='';
		//while ($search_result = tep_db_fetch_array($search_query)){
			//$content .= '<br><a class="menuBoxContentLink" href="'.tep_href_link($search_result['files_file_name'], $search_result['files_link_parameters']).'" style="background-color:'.$search_result['files_bg_color'].';">'.$search_result['files_display_name'].'</a>';
		//}
		//echo $content;
		//exit();
	//}
	//exit();
//}

 //print_r($_SESSION);
 ?>

 <?php
 
 if(isset($_SESSION['priority']) && $_SESSION['priority'] == 'All' ){
      $boxmenupriority = '1';
      $filemenupriority = ''; 
  }elseif($_SESSION['priority'] == 'Primary' || !isset($_SESSION['priority']) || $_SESSION['priority'] == ''){
      $boxmenupriority = " boxes_MenuPriority = '1'";
      $filemenupriority = " and files_MenuPriority = '1'";
}
echo '<div onclick="toggleLeftMenu(\'leftNav\');"><img id="show_arrow" src="images/arrow_hide.gif" style="border: 1px solid #ccc;" alt="Show/Hide Menu" title="Show/Hide Menu"></div>' ;





echo '<tr><td><table id="leftNav"  style="display:block;" border="0">';
echo '<tr>
<td><input type="text" name="Search" onkeyup="MenuSearch(this.value)">
</td>
</tr>';
echo '<tr><td><table id="leftNavSearch" width="125" style="display:block;" border="0"></table></td></tr>';
echo '<tr>
        <td><a href="'.tep_href_link(basename($PHP_SELF),tep_get_all_get_params(array('priority','setpriority')).'priority=Primary&setpriority=yes').'">Primary Menu</a></br><a href="'.tep_href_link(basename($PHP_SELF),tep_get_all_get_params(array('priority','setpriority')).'priority=All&setpriority=yes').'">Show All</a>
        </td>
    </tr>';
  //if    (MENU_DHTML != true) {
 define('BOX_WIDTH', 125);

if(isset($_GET['priority']) && $_GET['priority'] == 'secondary' ){
    $lnBoxesQuery = tep_db_query("select * from admin_ln_boxes where (admin_ln_boxes_id in (select admin_ln_boxes_id from admin_ln_files where files_MenuPriority = '2' group by admin_ln_boxes_id) or boxes_MenuPriority = '2') group by admin_ln_boxes_id order by boxes_sort_order ASC");
}  
else {
    $lnBoxesQuery = tep_db_query("select * from admin_ln_boxes where ".$boxmenupriority." order by boxes_sort_order ASC");
	//die("select * from admin_ln_boxes where ".$boxmenupriority." order by boxes_sort_order ASC");
}

 while($lnBoxesArray = tep_db_fetch_array($lnBoxesQuery)){
     if(tep_admin_check_boxes($lnBoxesArray['boxes_file_name']) == true){
         echo '<!-- '.$lnBoxesArray['boxes_display_name'].' //-->
          <tr>
            <td>';
        $heading = array();
        $contents = array();
        $boxLink = '';
        $contentstext = '';
        if($lnBoxesArray['boxes_MenuPriority'] == '2'){
        $lnFilesQuery = tep_db_query("select * from admin_ln_files where admin_ln_boxes_id = '".$lnBoxesArray['admin_ln_boxes_id']."' order by files_sort_order ASC");
        }  else {
            $lnFilesQuery = tep_db_query("select * from admin_ln_files where admin_ln_boxes_id = '".$lnBoxesArray['admin_ln_boxes_id']."' ".$filemenupriority." order by files_sort_order ASC");
        }
        
         while($lnFilesArray = tep_db_fetch_array($lnFilesQuery)){
                if($boxLink=='' && tep_admin_files_boxes($lnFilesArray['files_file_name'], $lnFilesArray['files_display_name'], $lnFilesArray['files_link_parameters'])!=''){
                    $boxLink = tep_href_link($lnFilesArray['files_file_name'], $lnFilesArray['files_link_parameters']);
                    if($lnFilesArray['files_link_parameters']=='' && !isset($HTTP_GET_VARS['osCAdminID']))$boxLink.='?selected_box='.$lnBoxesArray['admin_ln_boxes_id']; else $boxLink.='&selected_box='.$lnBoxesArray['admin_ln_boxes_id'];
                }
             //  echo 'admin_ln_boxes_id-'.$lnBoxesArray['admin_ln_boxes_id'].'<br />';
			  // echo 'selected_box-'.$selected_box.'<br />';
                 if ($selected_box == $lnBoxesArray['admin_ln_boxes_id'])
				 {
				   //echo $lnFilesArray['files_display_name'].'<br />';
				  $contentstext .= tep_admin_files_boxes($lnFilesArray['files_file_name'], $lnFilesArray['files_display_name'], $lnFilesArray['files_link_parameters'], $lnFilesArray['files_bg_color']);
         }
         }
        $heading[] = array('text'  => $lnBoxesArray['boxes_display_name'],
                'link'  => $boxLink);
        $contents[] = array('text' => $contentstext);
        $box = new box;
        echo $box->menuBoxNew($heading, $contents, $lnBoxesArray['boxes_bg_color']);
           echo '</td>
          </tr>
<!-- '.$lnBoxesArray['boxes_display_name'].'_eof //-->';

     }
	 
 }
//Admin end
//}
?>


<?php
echo '</table></td></tr>';
?>
<?php if(basename($PHP_SELF) != 'incoming_order_log.php' && basename($PHP_SELF) != 'articles_short.php' && basename($PHP_SELF) != 'purchase-invoices.php' ){ ?>
<script type="text/javascript" src="jquery.min.js"></script>
<?php } ?>
<script type="text/javascript">
			function MenuSearch(text){
                            if(text.length >= 3){
                                var url = "<?php echo tep_href_link(basename($PHP_SELF),'action=SearchText&value=');?>"+text;
                                //alert(url);
                                $.post(url, function(data) {

                                    //alert(data);
                                        if(data != ''){
                                            var html = '<tr><td class="menuBoxContent">'+data+'</td></tr>';
                                             $('#leftNavSearch').html(html);
                                        }

                                });
                            }
                        }

			
			
			//--></script>	