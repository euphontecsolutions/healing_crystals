<?php
  $popular_tag_query = tep_db_query("select tag_name from taglist order by tag_usage desc,rand() limit 11");
  if(tep_db_num_rows($popular_tag_query)){
  $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">Search By Tags</font>',

																	'image' => tep_image(DIR_WS_TEMPLATES.TEMPLATE_NAME."/images/infobox/left_stones_3.gif", '', '45', '28'));

  $informationString = "";

  $info_box_contents = array();
  $info_box_contents[] = array('text' =>  '<a class="infoBoxContents" href="'.tep_href_link(FILENAME_LINKS).'">Search By Tags</a>');

//  new infoBox($info_box_contents);
  $info_box_contents = array();

  $tag_array = '';				
  
  while($popular_tag = tep_db_fetch_array($popular_tag_query)){
	
	$tags_array .= '<a href="' . tep_href_link('tags.php', 'tag_name='.$popular_tag['tag_name']) . '" class="boxText">' . $popular_tag['tag_name'] . '</a> &nbsp;&nbsp;&nbsp;';
  
  }	
					

    if(tep_db_num_rows($popular_tag_query)){
	    $info_box_contents[] = array('text' => $tags_array);
    }

?>
<TR>
  <TD style="background-image:url(<?=DIR_WS_TEMPLATES.TEMPLATE_NAME?>/images/infobox_bg1.gif)">
	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
   	  <TR>
              <td><div class="glossymenuHeader" style="width:190px;margin-bottom:5px;"><a class="menuitem" href="javascript:void(0);">Search By Tags</a></div></td>
          </TR>
	</TABLE>

<TABLE class=infoBoxLeft cellSpacing=0 cellPadding=1 width="100%" border=0>
  <TR><TD>
	  <TABLE class=infoBoxLeftContents cellSpacing=0 cellPadding=0 width="100%" border=0>
         <TR><TD><IMG height=1 alt="" src="<?=DIR_WS_TEMPLATES.TEMPLATE_NAME?>/images/pixel_trans.gif" width="100%" border=0></TD></TR>
         <TR><TD class=boxText align=left><?new infoBox($info_box_contents);?></TD></TR>
         <TR><TD><IMG height=1 alt="" src="<?=DIR_WS_TEMPLATES.TEMPLATE_NAME?>/images/pixel_trans.gif" width="100%" border=0></TD></TR>
	   </TABLE>
   </TD></TR>
</TABLE>
</TD></TR>
<TR><TD   class="infoBoxBg">
<img border="0" src="<?=DIR_WS_TEMPLATES.TEMPLATE_NAME?>/images/divider1.gif" width="190" height="7" ALT="">
</TD></TR>
<TR><TD>
<IMG height=5 src="<?=DIR_WS_TEMPLATES.TEMPLATE_NAME?>/images/spacer.gif" width=1 border=0 ALT=""></TD></TR>
<?php } ?>