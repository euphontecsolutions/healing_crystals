
 <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
 <style type="text/css">
   .reset-this {
    animation : none;
    animation-delay : 0;
    animation-direction : normal;
    animation-duration : 0;
    animation-fill-mode : none;
    animation-iteration-count : 1;
    animation-name : none;
    animation-play-state : running;
    animation-timing-function : ease;
    backface-visibility : visible;
    background : 0;
    background-attachment : scroll;
    background-clip : border-box;
    background-color : transparent;
    background-image : none;
    background-origin : padding-box;
    background-position : 0 0;
    background-position-x : 0;
    background-position-y : 0;
    background-repeat : repeat;
    background-size : auto auto;
    border : 0;
    border-style : none;
    border-width : medium;
    border-color : inherit;
    border-bottom : 0;
    border-bottom-color : inherit;
    border-bottom-left-radius : 0;
    border-bottom-right-radius : 0;
    border-bottom-style : none;
    border-bottom-width : medium;
    border-collapse : separate;
    border-image : none;
    border-left : 0;
    border-left-color : inherit;
    border-left-style : none;
    border-left-width : medium;
    border-radius : 0;
    border-right : 0;
    border-right-color : inherit;
    border-right-style : none;
    border-right-width : medium;
    border-spacing : 0;
    border-top : 0;
    border-top-color : inherit;
    border-top-left-radius : 0;
    border-top-right-radius : 0;
    border-top-style : none;
    border-top-width : medium;
    bottom : auto;
    box-shadow : none;
    box-sizing : content-box;
    caption-side : top;
    clear : none;
    clip : auto;
    color : inherit;
    columns : auto;
    column-count : auto;
    column-fill : balance;
    column-gap : normal;
    column-rule : medium none currentColor;
    column-rule-color : currentColor;
    column-rule-style : none;
    column-rule-width : none;
    column-span : 1;
    column-width : auto;
    content : normal;
    counter-increment : none;
    counter-reset : none;
    cursor : auto;
    direction : ltr;
    display : inline;
    empty-cells : show;
    float : none;
    font : normal;
    font-family : inherit;
    font-size : medium;
    font-style : normal;
    font-variant : normal;
    font-weight : normal;
    height : auto;
    hyphens : none;
    left : auto;
    letter-spacing : normal;
    line-height : normal;
    list-style : none;
    list-style-image : none;
    list-style-position : outside;
    list-style-type : disc;
    margin : 0;
    margin-bottom : 0;
    margin-left : 0;
    margin-right : 0;
    margin-top : 0;
    max-height : none;
    max-width : none;
    min-height : 0;
    min-width : 0;
    opacity : 1;
    orphans : 0;
    outline : 0;
    outline-color : invert;
    outline-style : none;
    outline-width : medium;
    overflow : visible;
    overflow-x : visible;
    overflow-y : visible;
    padding : 0;
    padding-bottom : 0;
    padding-left : 0;
    padding-right : 0;
    padding-top : 0;
    page-break-after : auto;
    page-break-before : auto;
    page-break-inside : auto;
    perspective : none;
    perspective-origin : 50% 50%;
    position : static;
    /* May need to alter quotes for different locales (e.g fr) */
    quotes : '\201C' '\201D' '\2018' '\2019';
    right : auto;
    tab-size : 8;
    table-layout : auto;
    text-align : inherit;
    text-align-last : auto;
    text-decoration : none;
    text-decoration-color : inherit;
    text-decoration-line : none;
    text-decoration-style : solid;
    text-indent : 0;
    text-shadow : none;
    text-transform : none;
    top : auto;
    transform : none;
    transform-style : flat;
    transition : none;
    transition-delay : 0s;
    transition-duration : 0s;
    transition-property : none;
    transition-timing-function : ease;
    unicode-bidi : normal;
    vertical-align : baseline;
    visibility : visible;
    white-space : normal;
    widows : 0;
    width : auto;
    word-spacing : normal;
    z-index : auto;
    /* basic modern patch */
    all: initial;
    all: unset;
}

/* basic modern patch */

#reset-this-root {
    all: initial;
    * {
        all: unset;
    }
}
 </style>
<script type="text/javascript" language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800,screenX=50,screenY=50,top=50,left=50')
}
function showPrintPage(){
if(document.getElementById('print_link').checked == true) 
  {
    location.href = '<?php echo tep_href_link('articles_print_view.php', tep_get_all_get_params()); ?>';
  }else{
    location.href = '<?php echo tep_href_link('article_info_mobile.php', 'articles_id='.$HTTP_GET_VARS['articles_id']); ?>';
  }
}
function hideImages(){
  var col = document.getElementById('cpage').getElementsByTagName("img");
  for(var i=0; i<col.length; i++){
    if( col[i].src.indexOf('pixel_trans') == '-1'){
      if(col[i].style.display != 'none'){
        col[i].style.display = 'none';
      }else{
        col[i].style.display = 'block';
      }
    }
  } 
}
function redirectPage(val){
    switch(val){
        case '-':
            return false;
            break;
        case 'detail_image':
            var url = '<?php echo tep_href_link(FILENAME_ARTICLE_INFO,tep_get_all_get_params(array('hide_images','show_images','action')).'action=text_only&show_images=1'); ?>';
            break;
        case 'detail_text':
            var url = '<?php echo tep_href_link(FILENAME_ARTICLE_INFO,tep_get_all_get_params(array('hide_images','show_images','action')).'action=text_only&hide_images=yes'); ?>';
            break;
        case 'summary_image':
            var url = '<?php echo tep_href_link(FILENAME_ARTICLE_INFO,tep_get_all_get_params(array('hide_images','show_images','action')).'action=text_only&show_images=1'); ?>';
            break;
        case 'summary_text':
            var url = '<?php echo tep_href_link(FILENAME_ARTICLE_INFO,tep_get_all_get_params(array('hide_images','show_images','action')).'action=text_only&hide_images=yes'); ?>';
            break;
        case 'print':
            var url = '<?php echo tep_href_link('articles_print_view.php',tep_get_all_get_params(array('hide_images','show_images','action'))); ?>';
            break;            
    }
    location.href=url;
}
function replayFocus(pc_id_value)
{
document.getElementById('pc_id').value = pc_id_value;
document.getElementById('submit_button').focus();
}
//--></script>
<div class="container">

<?php $referral_url = $HTTP_SERVER_VARS['HTTP_REFERER']; ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
   <tr style="border: 0px;"><td align="left"><a href="/faq_mobile.php" class="btn btn-info"  style="background-color: #4c6aafad !important; color: #001abc;float: left;">&laquo;  Back To FAQ</a>
        </td></tr>
<?php
  if ($article_check['total'] < 1) {
?>
      <tr>
        <td class="pageHeading" colspan="2"><?php echo HEADING_ARTICLE_NOT_FOUND; ?></td>
      </tr>
      <tr>
        <!-- <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td> -->
      </tr>
      <tr>
        <td class="mainA" colspan="2"><?php echo TEXT_ARTICLE_NOT_FOUND; ?></td>
      </tr>
<?php
  } else {
    $article_info_query = tep_db_query("select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (" . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad) left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id where a.articles_id = '" . (int)$HTTP_GET_VARS['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$languages_id . "'");
    //echo "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name, a.articles_video from (" . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad) left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id where a.articles_id = '" . (int)$HTTP_GET_VARS['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$languages_id . "'";
    $article_info = tep_db_fetch_array($article_info_query);

    tep_db_query("update " . TABLE_ARTICLES_DESCRIPTION . " set articles_viewed = articles_viewed+1 where articles_id = '" . (int)$HTTP_GET_VARS['articles_id'] . "' and language_id = '" . (int)$languages_id . "'");

    $articles_name = $article_info['articles_name'];
    $articles_author_id = $article_info['authors_id'];
    $articles_author = $article_info['authors_name'];
  $articles_video = $article_info['articles_video'];

$stone_id_query = tep_db_query("select sn.stone_name_id, sn.summary_mpd, sn.stone_name, sn.detailed_mpd from stone_names sn where sn.detailed_mpd='".(int)$HTTP_GET_VARS['articles_id']."'");
if(tep_db_num_rows($stone_id_query) > 0) {

    $stoneIds = tep_db_fetch_array($stone_id_query);
    $stone_id = $stoneIds['stone_name_id'];

    $stone_property_value = tep_db_query("select property_value from stone_properties where stone_name_id = '" . $stone_id . "' and property_id = '62'");
    if(tep_db_num_rows($stone_property_value) > 0){
        $stoneValues = tep_db_fetch_array($stone_property_value);

    }else{
        $stoneValues ='';
    }


}
?>
      <tr>
        <td colspan="2"><!-- <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
         <td class="pageHeading" valign="top">
                 <?php echo $articles_name; ?><br>
                 <?php echo $stoneValues['property_value']; ?>
             </td>
       <td class="mainA" align="right" valign="top">
    <?php if(basename($PHP_SELF)!='articles_print_view.php'){ 
       $sql = tep_db_query("select count(*) as total from articles_comments where articles_id = '".$HTTP_GET_VARS['articles_id']."' and comments_status = 1 and parent_comments_id = '0' ");
  $array = tep_db_fetch_array($sql);
  $str='';
  if($array['total']>0) $str='<a href="/articles_comments.php?articles_id='.$HTTP_GET_VARS['articles_id'].'" style="vertical-align:middle;">Read Comments ('.$array['total'].')</a>&nbsp;&nbsp;';
  
  ?>

        <?php /*echo $str;*/ ?>
      <?php /* BOF:#402 */ if($HTTP_GET_VARS['screenshot_preview']!='1'){
      ?>
   
      <?php /* EOF:#402 */ }  ?>

  <?php 
    }
    
    
  ?>
       </td>
          </tr>     
        </table> --></td>
      </tr>
      
      <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="mainA" colspan="2" valign="top" id="cpage">
    <?php 
    if($articles_video != ''){
    
    ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" >
          <tr>
            <td align="left" class="smallText" valign="top">
        <?php
    }
    if (tep_not_null($article_info['articles_url'])) {
?>
 
    <div class="col-md-12"><img src="http://<?php echo $article_info['articles_url']; ?>" style="max-width: 100%; height:auto;"  /></div>
    
<?php
    }
   
        if($HTTP_GET_VARS['articles_id'] == '1159'){
           echo '<script language="javascript"> '
            . 'function newwindow(url) { testwindow = window.open(url,\'content\',\'width=850,height=600,status=yes,scrollbars=yes,resizable=yes\'); testwindow.moveTo(0,0); }


</script> ';
            echo  stripslashes($article_info['articles_description']); 
            
        }elseif($HTTP_GET_VARS['articles_id'] == '1111') {
          $articles1 = str_replace('"http://www.healingcrystals.com/images/HcFamily/ar1111-1.jpg"','"http://www.healingcrystals.com/images/HcFamily/ar1111-1.jpg" style="width: 100%; height: auto;"',$article_info['articles_description']);
          $articles2 = str_replace('"http://www.healingcrystals.com/images/HcFamily/abc.png" style="font-family: Arial, Verdana, sans-serif; font-size: 12px; width: 624px; height: 61px;"','"http://www.healingcrystals.com/images/HcFamily/abc.png" style="width: 100%; height: auto;"',$articles1);
           echo '<div class="col-md-12">'.  html_entity_decode(stripslashes($articles2)).'</div>';
        }elseif ($HTTP_GET_VARS['articles_id'] == '4433'){
          $articles3 = str_replace('img alt="" height="64" src="data:image/jpeg;base64,','img alt="" style="width: 80%; height: auto;" src="data:image/jpeg;base64,',$article_info['articles_description']);
           echo '<div class="col-md-12">'.  html_entity_decode(stripslashes($articles3)).'</div>';
        }else{
           echo '<div class="col-md-12">'.  html_entity_decode(stripslashes($article_info['articles_description'])).'</div>';
        } ?>

        </td>
     <?php
     if($articles_video != ''){
   ?>   
    <td align="left" class="smallText" valign="top">
      <object width="100%" height="auto">
<param name="movie" value="video/<?php echo $articles_video; ?>">
<embed src="video/<?php echo $articles_video; ?>" width="100%" height="auto">
</embed>
</object>   
    </td>
  </tr>
  </table>  
<?php
  }
echo '</tr>';

                        if($tPath == '13' ){
                         //   echo 'hii';
                            
                            $stone_name_query = tep_db_query("select stone_name, stone_name_id from stone_names where `detailed_mpd`= '".$HTTP_GET_VARS['articles_id']."' order by stone_name_id ASC");
                          
$no_of_stones = tep_db_num_rows($stone_name_query);


if($no_of_stones > 0){
   // echo 'hello';
  foreach($stone_name_ids2 as $stone_name_ids){
$prosql_tags = tep_db_query("select distinct st.tag_id, tl.tag_name, st.property_id from stone_tags st, taglist tl where st.tag_id = tl.tag_id and stone_name_id ='".$stone_name_ids['stone_name_id']."' order by st.property_id, tl.tag_name");

if(tep_db_num_rows($prosql_tags)){            
            $pro_array = array();
          $stone_article_id_query = tep_db_query("select detailed_mpd from stone_names where stone_name_id='". $stone_name_ids['stone_name_id'] ."'");
          $stone_article_id = tep_db_fetch_array($stone_article_id_query);
          if($stone_article_id['detailed_mpd'] > 0){
      ?>
      <tr><td class="catDesc" style="width: 150px; min-width: 150px;"><b>Properties for Stone:</b></td><td class="catDesc"><a class="property_link" href="<?php echo tep_href_link('article_info_mobile.php','articles_id='.$stone_article_id['detailed_mpd']); ?>"><?php echo tep_get_stone_name($stone_name_ids['stone_name_id']);?></a></td></tr>

      
      <?php
          }else{
      ?>
          <tr><td class="catDesc"><b>Properties for Stone:</b></td><td class="catDesc"><?php echo tep_get_stone_name($stone_name_ids['stone_name_id']); ?></td></tr>
      <?php 
          }
          /*echo '<tr><td colspan="2">' . tep_draw_separator('pixel_trans.gif', '100%', '5') . '</td></tr>';*/
          $alternate_stone_name_array = array();
            while($array1 = tep_db_fetch_array($prosql_tags)){
              $tag_display_name = str_replace('-', ' ',$array1['tag_name']);
                                                $tag_display_name = str_replace('_', ' ',$array1['tag_name']);
                                                if($array1['property_id'] == '22' || $array1['property_id'] == '23' ){
                                                    if(!in_array($array1['tag_name'],$alternate_stone_name_array) ){
                                                        $alternate_stone_name_array[] = $array1['tag_name'];

                                                    }
                                                    $pro_array[$array1['property_id']] .=  $array1['tag_name']  ;           
                                                }elseif($array1['property_id'] == '11'){
                                                    $pro_array[$array1['property_id']] .=  $tag_display_name .', ' ;
                                                }elseif($array1['property_id'] == '9'){
                                                    $psp_query = tep_db_query("select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".trim($tag_display_name)."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id");
                                                    //echo "select * from products_specific_property psp, products p, products_attributes pa where psp.products_id = p.products_id and pa.products_id = p.products_id and psp.property_value like '".$val."' and psp.property_name LIKE '%location%' and p.products_status = '1' and pa.product_attributes_status = '1' group by p.products_id";
                                                    if(tep_db_num_rows($psp_query)){
                                                        $pro_array[$array1['property_id']] .=  '<a class="property_link" href="'.tep_href_link('products.php','show=location&location='.$tag_display_name).'">' . $tag_display_name . '</a>, ';
                                                    }                                                    
                                                }elseif($array1['property_id'] == '4'){
                                                    $get_property_stone_id_query = tep_db_query("SELECT `stone_properties_id` FROM `stone_properties` WHERE `stone_name_id` = '".$stone_name_ids['stone_name_id']."' and `property_id` = '4' and `property_value` like '%".$array1['tag_name']."%' limit 1"); 
                                                    $get_property_stone_id = tep_db_fetch_array($get_property_stone_id_query);
                                                    
                                                    $pro_array[$array1['property_id']] .= '<a class="property_link" href="' . tep_href_link("products_by_chemical_composition.php","sp_id=".$get_property_stone_id['stone_properties_id']) . '">' . $tag_display_name . '</a>, ' ;
                                                }else{
                                                    $pro_array[$array1['property_id']] .= '<a class="property_link" href="' . tep_href_link("tags.php","tag_name=".$array1['tag_name']."&amp;tab=".$array1['property_id']) . '">' . $tag_display_name . '</a>, ' ;            
                                                }
            }
                                        //print_r($pro_array); 
          for($i = 1; $i<= 61; $i++){
                                            if($i != 22 || $i != 23){
                                                $pro_array[$i] = substr($pro_array[$i], 0, -2);
                                            }
            
            if(!tep_not_null($pro_array[$i])){
              $pro_array[$i] = tep_get_stone_property_value($stone_name_ids['stone_name_id'],0,$i);           
            }
          }
          
            $pro_final_array['Stone Name']= $pro_array[1];
                                        $pro_final_array['Alternate Stone Name #1']= $pro_array[22];
                                        $pro_final_array['Alternate Stone Name #2']= $pro_array[23];
            $pro_final_array['Primary Chakra']= $pro_array[2];
            $pro_final_array['Secondary Chakra']= $pro_array[12];
            $pro_final_array['Crystal System']= $pro_array[3];
            $pro_final_array['Chemical Composition']= $pro_array[4];
            $pro_final_array['Astrological Sign']= $pro_array[5];
            $pro_final_array['Numerical Vibration']= $pro_array[6];
            $pro_final_array['Hardness']= $pro_array[7];
            $pro_final_array['Color']= $pro_array[8];
            $pro_final_array['Location']= $pro_array[9];
            $pro_final_array['Rarity']= $pro_array[10];
            $pro_final_array['Pronunciation']= $pro_array[11];
          $pro_final_array['Mineral Class']= $pro_array[13];
                                        $pro_final_array['Issues and Ailments (Physical)']= $pro_array[14];
                                        $pro_final_array['Issues and Ailments (Emotional)']= $pro_array[15];
                                        $pro_final_array['Issues and Ailments (Spiritual)']= $pro_array[16];
                                        $pro_final_array['Extra Grade']= $pro_array[17];
                                        $pro_final_array['A Grade']= $pro_array[18];
                                        $pro_final_array['B Grade']= $pro_array[19];
                                        $pro_final_array['Affirmation']= $pro_array[20];
                                        $pro_final_array['Question']= $pro_array[21];
                                        $pro_final_array['Reference 1'] = $pro_array[57];
                                        $pro_final_array['Reference 2'] = $pro_array[58];
                                        $pro_final_array['Reference 3'] = $pro_array[59];
                                        $pro_final_array['Reference 4'] = $pro_array[60];
                                        $pro_final_array['Reference 5'] = $pro_array[61];
           
            foreach($pro_final_array as $key => $value){
                                            if($key == 'Alternate Stone Name #1' || $key == 'Alternate Stone Name #2' ){
                                                continue;
                                            }
              if($value){
                                                        if($key == 'Reference 1' || $key == 'Reference 2' || $key == 'Reference 3' || $key == 'Reference 4' || $key == 'Reference 5' ){
                                                            echo '<tr><td class="catDesc"  valign="top"><b>'.$key.':</b></td><td class="catDesc"  valign="top"><a href="'.$value.'" target="_blank">'.$value.'</a></td></tr>';
                echo '<tr><td colspan="2">' . tep_draw_separator('pixel_trans.gif', '100%', '5') . '</td></tr>'; 
                                                        }elseif($key != 'Stone Name'){
                echo '<tr><td class="catDesc"  valign="top"><b>'.$key.':</b></td><td class="catDesc"  valign="top">'.$value.'</td></tr>';
              /*  echo '<tr><td colspan="2">' . tep_draw_separator('pixel_trans.gif', '100%', '5') . '</td></tr>';*/ 
              }else{
                
              }
            }
            }
           /* if(tep_db_num_rows($prosql_tags)>1)echo '<tr><td colspan="2">' . tep_draw_separator('pixel_trans.gif', '100%', '20') . '</td></tr>';*/
          }
      }   
    }

    $product_properties_array = array();
    $categoryNameArray = array(
      'A' => 'Assortment',
      'C' => 'Polished Crystals',
      'J' => 'Crystal Jewelry',
      'N' => 'Natural Crystals',
      'NQ' => 'Quartz Crystals',
      'T' => 'Tumbled Stones',
      'V' => 'Accessories',
      'D' => 'Discontinued',
    );
                $alreadyASNPrint = false;
    
                if(is_array($alternate_stone_name_array) && !empty($alternate_stone_name_array)){
                                  $alternate_stone_name = null;
                                  foreach($alternate_stone_name_array as $val){
                                      $tag_display_value = str_replace('-', ' ',$val);
                                      $alternate_stone_name .= '<a class="property_link" href="'.tep_href_link('products.php','sort_view=all&show=alternatestone&alternatestone='.$val).'">' . $tag_display_value . '</a>, ';
                                  }
                                 $product_properties_array['Alternate Stone Name'] = rtrim($alternate_stone_name,',');
                              }
                
    foreach($product_properties_array as $pkey => $pvalue){
        if($pvalue){
        echo '<tr><td class="catDesc"  valign="top"><b>'. $pkey .':</b></td><td class="catDesc"  valign="top">'. substr($pvalue, 0, -2) . '</td></tr>';
        echo '<tr><td colspan="2">' . tep_draw_separator('pixel_trans.gif', '100%', '5') . '</td></tr>';
                                            }
                }
        
  
                
                        }
                        
                         
      
                        
?>
    
      <!-- <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->

      <!--/form//-->
<?php
$check_query = tep_db_query("select topics_id from " . TABLE_ARTICLES_TO_TOPICS . " where articles_id = '" . (int)$HTTP_GET_VARS['articles_id'] . "'");
$check = tep_db_fetch_array($check_query);
if ($check['topics_id'] == '3') {
  ?>
    <!--  <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->
   <tr>
        <td class="mainA" colspan="2"><?php //echo TEXT_ALL_ARTICLES; ?>
      <form method="get" id="searchform" action="<?php echo tep_href_link(FILENAME_ARTICLES, tep_get_all_get_params(array('search, key'))); ?>"><input type="hidden" name="tPath" value="3">
      <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr><td class="mainA" valign="top" align="left" nowrap style="padding-right: 12px;">Search: <?php echo tep_draw_input_field('search'); ?>&nbsp;&nbsp;<input type="submit" id="searchsubmit" value="Search" /></td></tr>

        <tr><td class="mainA" valign="top" align="left" nowrap style="padding-right: 12px;"><input type="radio" name="key" value="title" <?php echo $radio_title; ?>>Search Metaphysical Crystal Directory - Stone Names only</td></tr>
        <tr><td class="mainA" valign="top" align="left" nowrap style="padding-right: 12px;"><input type="radio" name="key" value="content" <?php echo $radio_content; ?>>Search Metaphysical Crystal Directory - Stone Names &amp; Descriptions</form></td></tr>



      </table>
      </form>

    </td>
      </tr>
 
    <?php } ?>
<!-- 
      <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->
<!-- tell_a_friend_eof //-->

      <!-- <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->
    
      <!-- <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->
      <?php if(basename($PHP_SELF)!='articles_print_view.php'){?>
     <tr>
        <td class="mainA" colspan="2" valign="bottom">
  
    </td>
      </tr>
      <?php }?>
     <!--  <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->
      <?php
      if (ENABLE_TELL_A_FRIEND_ARTICLE == 'true' && basename($PHP_SELF)!= 'articles_print_view.php') {
    if (isset($HTTP_GET_VARS['articles_id'])) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => BOX_TEXT_TELL_A_FRIEND);
      //new infoBoxHeading($info_box_contents, false, false);
      $info_box_contents = array();
      $info_box_contents[] = array('form' => tep_draw_form('tell_a_friend', tep_href_link(FILENAME_TELL_A_FRIEND, '', 'NONSSL', false), 'get'),
                                   'align' => 'left',
                                   'text' => '<a href="tell_a_friend.php?to_email_address=&amp;x=9&amp;y=9&amp;articles_id='.$HTTP_GET_VARS['articles_id'].'" >'.tep_template_image_button('button_tell_a_friend.gif', 'Tell A Friend').'</a>' ); ?>
<?php     
    }
  }
    ?>
      <tr>
        <td>
<?php
//added for cross-sell
   if ( (USE_CACHE == 'true') && !SID) {
     include(DIR_WS_MODULES . FILENAME_ARTICLES_XSELL);
   } else {
     include(DIR_WS_MODULES . FILENAME_ARTICLES_XSELL);
    }
   }
?>
        </td>
      </tr>
    </table>
<!-- body_text_eof //-->
<?php
  if($hide_products_images == 1){
    echo '<script  type="text/javascript">hideImages();</script>';
  }
?>
<?php if($HTTP_GET_VARS['show']=='all') { ?>
<script type="text/javascript" language="javascript">
 
      document.getElementById('showcommentstbl').focus();
</script>
<?php } ?>
 </div>
 <script>
$( document ).ready(function() {
   $(".main-container").css("transform","");
});
 </script>