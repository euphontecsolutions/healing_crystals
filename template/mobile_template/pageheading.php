<?php
/*
 * $author: Shantnu Aggarwal
 * shantnuaggarwal@gmail.com
 */
$breadcrumb_link = '';
$pageheading = '';
$tertiary_tabs = '';
//print_r($HTTP_GET_VARS['show']);
switch (basename($PHP_SELF)) {
      case 'products_by_model.php':
        $breadcrumb_link = ' > <a href="'.tep_href_link('products_by_model.php',tep_get_all_get_params()).'">Products By Category</a>';
        $pageheading = 'Products By Category';
        break;
    case 'sale_specials.php':
        $breadcrumb_link = ' > <a href="'.tep_href_link('sale_specials.php',tep_get_all_get_params()).'">On Sale Today</a>';
        $pageheading = 'Crystals On Sale Today';
        break;
    case 'clearance-crystals.php':
        $breadcrumb_link = ' > <a href="'.tep_href_link('clearance-crystals.php',tep_get_all_get_params()).'">Clearance Items</a>';
        $pageheading = 'Clearance Items';
        break;
    case 'best-selling-crystals.php':
        $breadcrumb_link = ' > <a href="'.tep_href_link('best-selling-crystals.php',tep_get_all_get_params()).'">Best Selling Crystals</a>';
        $pageheading = 'Best Selling Crystals';
        break;
    case 'new_arrivals.php':
        $breadcrumb_link = ' > <a href="'.tep_href_link('new_arrivals.php',tep_get_all_get_params()).'">New Arrivals</a>';
        $pageheading = 'New Arrivals';
        break;
    case 'random_products.php':
        $breadcrumb_link = ' > <a href="'.tep_href_link('random_products.php',tep_get_all_get_params()).'">Discover</a>';
        $pageheading = "On this Discover page you'll see 20 items available from our website. The prospect of new items alone is exciting, because you never know if you'll learn about a new crystal or item on our website. If you ask yourself a question about which crystals you need before pressing the refresh button, you can find your answer in the crystals that stand out to you. Of course, because there are images shown you'll receive the energy of the crystals through the images, just by looking at them. So, check out our Discover page and see what awaits you!";
        break;
    case 'products.php':
        $categ = $HTTP_GET_VARS['category'];

        if ($HTTP_GET_VARS['quartz'] == 1)$categ = "NQ";
        switch ($HTTP_GET_VARS['show']) {
            case 'color':
            case 'location':
            case 'size':
            case 'quality':
            case 'alternate_stone':
            case 'shape':
                $stoneNameArray = array();
//                print_r($categoryNameArray);
foreach($categoryNameArray as $key => $value){
//$forStonesOnlyStr = '';
          if($HTTP_GET_VARS['category'] == 'N' && $HTTP_GET_VARS['quartz']=='1'){
              $clearQuartzStoneId = tep_get_stone_name_id('Clear Quartz');
              //$forStonesOnlyStr = " and p2s.stone_name_id = '".$clearQuartzStoneId."'";
         }
         //$parant_stone = array();
         $Parent_stone_id_query = tep_db_query("SELECT `stone_name_id`, `stone_name` FROM `stone_names` WHERE `parent_stone_id` = '0'");
         while($Parent_stone_id = tep_db_fetch_array($Parent_stone_id_query)){
            // if(!in_array($Parent_stone_id['stone_name'],$parant_stone)){
              //   $parant_stone[$Parent_stone_id['stone_name_id']] = $Parent_stone_id['stone_name'];
            // }
         }
    if($key == 'N'){
        $crystaljewelleryquery = tep_db_query("select sn.parent_stone_id, sn.stone_name_id, sn.stone_name from stone_names sn, products_to_stones p2s, products p where sn.stone_name_id = p2s.stone_name_id and p2s.products_id = p.products_id and p.products_model like '".$key."%' and p.products_model not like 'NQ%' group by sn.stone_name");
    }else{
//        echo 'hlo';
        $crystaljewelleryquery = tep_db_query("select sn.parent_stone_id, sn.stone_name_id, sn.stone_name from stone_names sn, products_to_stones p2s, products p where sn.stone_name_id = p2s.stone_name_id and p2s.products_id = p.products_id and p.products_model like '".$key."%' group by sn.stone_name");
    }
    $stoneNameArray[$key] = array();
    while($crystaljewellery = tep_db_fetch_array($crystaljewelleryquery) ){
       // if($crystaljewellery['parent_stone_id'] != '0'){
           // $crystaljewellery['stone_name'] = $parant_stone[$crystaljewellery['parent_stone_id']];
           // $crystaljewellery['stone_name_id'] = $crystaljewellery['parent_stone_id'];
      //  }
        if(!in_array($crystaljewellery['stone_name'],$stoneNameArray[$key]) && $crystaljewellery['stone_name']!=''){
            $stoneNameArray[$key][$crystaljewellery['stone_name_id']] = $crystaljewellery['stone_name'];
        }
    }
    asort($stoneNameArray[$key]);
}
                if (!isset($HTTP_GET_VARS[strtolower($HTTP_GET_VARS['show'])])) {
                    $breadcrumb_link =  ($categoryLinkArray[$categ] ? $categoryLinkArray[$categ] : ' ');
                    $breadcrumb_link .= $filterLinkArray[$HTTP_GET_VARS['show']];
                    $pageheading = $categoryNameArray[$categ] ? ($categoryNameArray[$categ]).' ' : '';
                    $pageheading .= 'Products matching "'.$filterArray[$HTTP_GET_VARS['show']].'" Tag';
                    if($_GET['show']== 'shape' && ($HTTP_GET_VARS['quartz'] != 1) && $HTTP_GET_VARS['category']!= "NQ"){                   $option_text = '';
                        if(isset($HTTP_GET_VARS['stone']) && $HTTP_GET_VARS['stone'] != ''){
                            $sel_stone_id = $HTTP_GET_VARS['stone'];
                        }else{
                            $sel_stone_id = '';
                        }
                        if(is_array($stoneNameArray[$categ]) && !empty($stoneNameArray[$categ])){
                            foreach ($stoneNameArray[$categ] as $key => $val){
                                $option_text .= '<option onclick="location.href=\''.tep_href_link("products.php", tep_get_all_get_params(array('stone','show','sort_view')).'&show=stone&sort_view=stone&stone='.$key).'\'" value="'.$key.'" '.($sel_stone_id != '' && $sel_stone_id ==$key?' selected ':'' ).' >'.$val.'</option>';
                            }
                        }
                        $pageheading1 .= 'Refine Search by Stone Type:&nbsp;<select style="color:#14116c;"><option value="">Select</option>'.$option_text.'</select>';
                    }
                } else {
                    $breadcrumb_link =  $categoryLinkArray[$categ] ? ($categoryLinkArray[$categ]) : '';
                    $breadcrumb_link .=  $filterLinkArray[$HTTP_GET_VARS['show']] ? $filterLinkArray[$HTTP_GET_VARS['show']] . ' > ' : '';
                    $breadcrumb_link .=  '<a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">' . $HTTP_GET_VARS[strtolower($HTTP_GET_VARS['show'])] . '</a>';
                    $pageheading = $categoryNameArray[$categ] ? ($categoryNameArray[$categ]).' ' : '';
                    $pageheading .= 'Products matching "'.$filterArray[$HTTP_GET_VARS['show']].'" & "'.$HTTP_GET_VARS[strtolower($HTTP_GET_VARS['show'])].'" Tag';
                    if($HTTP_GET_VARS['show']!='shape'){
                        $tertiary_tabs = '<table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;>
            <tr><td>'. tep_draw_separator('pixel_trans.gif','100%','1').'</td></tr>
            <tr>
                <td align="left" valign="bottom" width="100%">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr '.($HTTP_GET_VARS['sort_view']!='stone'?'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"':'').'><td class="'. ($HTTP_GET_VARS['sort_view']=='stone' ? 'tab_left_high_selected' : 'tab_left_high').'" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td><td class="'. ($HTTP_GET_VARS['sort_view']=='stone' ? 'tab_center_high_selected' : 'tab_center_high').'" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="'. tep_href_link("products.php", tep_get_all_get_params(array('sort_view'))).'">View by<br/>Stone Type</a></td><td class="'. ($HTTP_GET_VARS['sort_view']=='stone' ? 'tab_right_high_selected' : 'tab_right_high').'" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td></tr></table></td>
                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr '.($HTTP_GET_VARS['sort_view']!='shape'?'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"':'').'><td class="'. ($HTTP_GET_VARS['sort_view']=='shape' ? 'tab_left_high_selected' : 'tab_left_high').'" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td><td class="'. ($HTTP_GET_VARS['sort_view']=='shape' ? 'tab_center_high_selected' : 'tab_center_high').'" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="'. tep_href_link("products.php", tep_get_all_get_params(array('sort_view')).'sort_view=shape').'">View by<br/>Shape</a></td><td class="'. ($HTTP_GET_VARS['sort_view']=='shape' ? 'tab_right_high_selected' : 'tab_right_high').'" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td></tr></table></td>
                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr '.($HTTP_GET_VARS['sort_view']!='all'?'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"':'').'><td class="'. ($HTTP_GET_VARS['sort_view']=='all' ? 'tab_left_high_selected' : 'tab_left_high').'" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td><td class="'. ($HTTP_GET_VARS['sort_view']=='all' ? 'tab_center_high_selected' : 'tab_center_high').'" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="'. tep_href_link("products.php", tep_get_all_get_params(array('sort_view')).'sort_view=all').'">View All<br/>Products</a></td><td class="'. ($HTTP_GET_VARS['sort_view']=='all' ? 'tab_right_high_selected' : 'tab_right_high').'" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td></tr></table></td>
                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr '.($HTTP_GET_VARS['show']!='' && isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']])?'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"':'').'><td class="'. ($HTTP_GET_VARS['show']!='' && !isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']]) ? 'tab_left_high_selected' : 'tab_left_high').'" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td><td class="'. ($HTTP_GET_VARS['show']!='' && !isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']]) ? 'tab_center_high_selected' : 'tab_center_high').'" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="'. tep_href_link("products.php", tep_get_all_get_params(array('sort_view',$HTTP_GET_VARS['show']))).'">View All<br/>'.$filterArray[$HTTP_GET_VARS['show']].' Tags</a></td><td class="'. ($HTTP_GET_VARS['show']!='' && !isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']]) ? 'tab_right_high_selected' : 'tab_right_high').'" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td></tr></table></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';
                        switch($HTTP_GET_VARS['sort_view']){
                            case 'stone':
                                $breadcrumb_link .=  ' > <a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">View by Stone Type</a>';
                                break;
                            case 'shape':
                                $breadcrumb_link .=  ' > <a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">View by Shape/Formation</a>';
                                break;
                            case 'all':
                                $breadcrumb_link .=  ' > <a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">View All</a>';
                                break;
                        }
                    }
                }
                break;
            case 'stone':
                if (!isset($HTTP_GET_VARS['stone'])) {
                    $breadcrumb_link = ($categoryLinkArray[$categ] ? $categoryLinkArray[$categ] : ' ');
                    $breadcrumb_link .= $filterLinkArray[$HTTP_GET_VARS['show']];
                    $pageheading =  ($categoryNameArray[$categ] ? $categoryNameArray[$categ] : ' ');
                    $pageheading .= ' - '.$filterArray[$HTTP_GET_VARS['show']];
                } else {
                    $breadcrumb_link = $categoryLinkArray[$categ] ? ($categoryLinkArray[$categ]) : '';
                    $breadcrumb_link .= $filterLinkArray[$HTTP_GET_VARS['show']] ? $filterLinkArray[$HTTP_GET_VARS['show']] . ' > ' : '';
                    $parent_stone_query = tep_db_query("select parent_stone_id from stone_names where stone_name_id = '" . $HTTP_GET_VARS['stone'] . "'");
                    $pageheading = $categoryNameArray[$categ] ? ($categoryNameArray[$categ]) : '';
                    $pageheading .= ' - '.($filterArray[$HTTP_GET_VARS['show']] ? $filterArray[$HTTP_GET_VARS['show']] . ' - ' : '');
                    $parent_stone = tep_db_fetch_array($parent_stone_query);
                    if ($parent_stone['parent_stone_id'] > 0) {
                        $breadcrumb_link .= '<a href="' . tep_href_link('products.php', tep_get_all_get_params(array('stone','sort_view')) . 'stone=' . $parent_stone['parent_stone_id']) . '">' . tep_get_stone_name($parent_stone['parent_stone_id']) . '</a> > ';
                    }
                    $breadcrumb_link .= '<a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">' . tep_get_stone_name($HTTP_GET_VARS['stone']) . '</a>';
                    $pageheading .= tep_get_stone_name($HTTP_GET_VARS['stone']);
                }
                break;  
            case 'crystals':
                $breadcrumb_link = ($filterLinkArray[$_GET[$HTTP_GET_VARS['show']].'-'.$HTTP_GET_VARS['show']] ? $filterLinkArray[$_GET[$HTTP_GET_VARS['show']].'-'.$HTTP_GET_VARS['show']] : '');
                $pageheading = ($filterArray[$_GET[$HTTP_GET_VARS['show']].'-'.$HTTP_GET_VARS['show']] ? $filterArray[$_GET[$HTTP_GET_VARS['show']].'-'.$HTTP_GET_VARS['show']] : '');
                break;
            case 'wholesale':
                $breadcrumb_link = ($filterLinkArray[$HTTP_GET_VARS['show']] ? $filterLinkArray[$HTTP_GET_VARS['show']] : '');
                $pageheading = ($filterArray[$HTTP_GET_VARS['show']] ? $filterArray[$HTTP_GET_VARS['show']] : '');
                break;
            case 'pchakra':
            case 'schakra':
            case 'crystal':
            case 'astro':
            case 'vibration':
            case 'hardness':
            case 'rarity':
            case 'mineral':
            case 'ailment':
                if (!isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']])) {
                    $breadcrumb_link = ($categoryLinkArray[$categ] ? $categoryLinkArray[$categ] : ' ');
                    $breadcrumb_link .= $filterLinkArray[$HTTP_GET_VARS['show']];
                    $pageheading = $categoryNameArray[$categ] ? ($categoryNameArray[$categ]).' ' : '';
                    $pageheading .= 'Products matching "'.$filterArray[$HTTP_GET_VARS['show']].'" Tag';
                } else {
                    $breadcrumb_link = $categoryLinkArray[$categ] ? (' > ' . $categoryLinkArray[$categ]) : '';
                    $breadcrumb_link .= $filterLinkArray[$HTTP_GET_VARS['show']] ? $filterLinkArray[$HTTP_GET_VARS['show']] . ' > ' : '';
                    $breadcrumb_link .= '<a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">' . stripslashes($HTTP_GET_VARS[$HTTP_GET_VARS['show']]) . '</a>';
                    $pageheading = $categoryNameArray[$categ] ? ($categoryNameArray[$categ]).' ' : '';
                    $pageheading .= 'Products matching "'.$filterArray[$HTTP_GET_VARS['show']].'" & "'.$HTTP_GET_VARS[strtolower($HTTP_GET_VARS['show'])].'" Tag';
                }
                $tertiary_tabs = '<table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;>
            <tr><td>'. tep_draw_separator('pixel_trans.gif','100%','1').'</td></tr>
            <tr>
                <td align="left" valign="bottom" width="100%">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr '.($HTTP_GET_VARS['sort_view']!='stone'?'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"':'').'><td class="'. ($HTTP_GET_VARS['sort_view']=='stone' ? 'tab_left_high_selected' : 'tab_left_high').'" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td><td class="'. ($HTTP_GET_VARS['sort_view']=='stone' ? 'tab_center_high_selected' : 'tab_center_high').'" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="'. tep_href_link("products.php", tep_get_all_get_params(array('sort_view'))).'">View by<br/>Stone Type</a></td><td class="'. ($HTTP_GET_VARS['sort_view']=='stone' ? 'tab_right_high_selected' : 'tab_right_high').'" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td></tr></table></td>
                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr '.($HTTP_GET_VARS['sort_view']!='shape'?'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"':'').'><td class="'. ($HTTP_GET_VARS['sort_view']=='shape' ? 'tab_left_high_selected' : 'tab_left_high').'" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td><td class="'. ($HTTP_GET_VARS['sort_view']=='shape' ? 'tab_center_high_selected' : 'tab_center_high').'" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="'. tep_href_link("products.php", tep_get_all_get_params(array('sort_view')).'sort_view=shape').'">View by<br/>Shape</a></td><td class="'. ($HTTP_GET_VARS['sort_view']=='shape' ? 'tab_right_high_selected' : 'tab_right_high').'" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td></tr></table></td>
                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr '.($HTTP_GET_VARS['sort_view']!='all'?'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"':'').'><td class="'. ($HTTP_GET_VARS['sort_view']=='all' ? 'tab_left_high_selected' : 'tab_left_high').'" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td><td class="'. ($HTTP_GET_VARS['sort_view']=='all' ? 'tab_center_high_selected' : 'tab_center_high').'" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="'. tep_href_link("products.php", tep_get_all_get_params(array('sort_view')).'sort_view=all').'">View All<br/>Products</a></td><td class="'. ($HTTP_GET_VARS['sort_view']=='all' ? 'tab_right_high_selected' : 'tab_right_high').'" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td></tr></table></td>
                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr '.($HTTP_GET_VARS['show']!='' && isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']])?'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"':'').'><td class="'. ($HTTP_GET_VARS['show']!='' && !isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']]) ? 'tab_left_high_selected' : 'tab_left_high').'" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td><td class="'. ($HTTP_GET_VARS['show']!='' && !isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']]) ? 'tab_center_high_selected' : 'tab_center_high').'" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="'. tep_href_link("products.php", tep_get_all_get_params(array('sort_view',$HTTP_GET_VARS['show']))).'">View All<br/>'.$filterArray[$HTTP_GET_VARS['show']].' Tags</a></td><td class="'. ($HTTP_GET_VARS['show']!='' && !isset($HTTP_GET_VARS[$HTTP_GET_VARS['show']]) ? 'tab_right_high_selected' : 'tab_right_high').'" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href">'. tep_draw_separator('pixel_trans.gif', '20', '40').'</td></tr></table></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';
                switch($HTTP_GET_VARS['sort_view']){
                    case 'stone':
                        $breadcrumb_link .=  ' > <a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">View by Stone Type</a>';
                        break;
                    case 'shape':
                        $breadcrumb_link .=  ' > <a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">View by Shape/Formation</a>';
                        break;
                    case 'all':
                        $breadcrumb_link .=  ' > <a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">View All</a>';
                        break;
                }
                break;
            case 'composition':
                if (!isset($HTTP_GET_VARS['composition'])) {
                    $breadcrumb_link = ($categoryLinkArray[$categ] ? $categoryLinkArray[$categ] : ' ');
                    $breadcrumb_link .= $filterLinkArray[$HTTP_GET_VARS['show']];
                    $pageheading =  ($categoryNameArray[$categ] ? $categoryNameArray[$categ] : ' ');
                    $pageheading .= ' - '.$filterArray[$HTTP_GET_VARS['show']];
                } else {
                    $stone_property_id_query = tep_db_query("select property_value from stone_properties where property_value = '" . $HTTP_GET_VARS['composition'] . "'");
                    $stone_property_id = tep_db_fetch_array($stone_property_id_query);
                    $breadcrumb_link = $categoryLinkArray[$categ] ? ($categoryLinkArray[$categ]) : '';
                    $breadcrumb_link .= $filterLinkArray[$HTTP_GET_VARS['show']] ? $filterLinkArray[$HTTP_GET_VARS['show']] . ' > ' : '';
                    $breadcrumb_link .= '<a href="' . tep_href_link('products.php', tep_get_all_get_params(array('sort_view'))) . '">' . stripslashes($stone_property_id['property_value']) . '</a>';
                    $pageheading = $categoryNameArray[$categ] ? ($categoryNameArray[$categ]) : '';
                    $pageheading .= ' - '.($filterArray[$HTTP_GET_VARS['show']] ? $filterArray[$HTTP_GET_VARS['show']] . ' - ' : '');
                    $pageheading .= stripslashes($stone_property_id['property_value']) ;
                }
                break;
            default:

                $breadcrumb_link = ($categoryLinkArray[$categ] ? ($HTTP_GET_VARS['quartz'] == 1 ? ' > <a href="' . tep_href_link('products.php', 'show=all&category=N') . '" >Natural Crystals & Minerals</a> > <a href="' . tep_href_link('products.php', 'show=all&category=N&quartz=1') . '" >Clear Quartz Crystals</a>' : $categoryLinkArray[$categ]) : ' ');
                $breadcrumb_link .= ($filterLinkArray[$HTTP_GET_VARS['show']] ? $filterLinkArray[$HTTP_GET_VARS['show']] : '');
                $pageheading = ($categoryNameArray[$categ] ? ($HTTP_GET_VARS['quartz'] == 1 ? 'Clear Quartz Crystals' : $categoryNameArray[$categ]) : ' ');
                $pageheading .= ' - '.($filterArray[$HTTP_GET_VARS['show']] ? $filterArray[$HTTP_GET_VARS['show']] : '');
        }
        
        break;
        case 'taglist.php':
            $this_page_path = $_SERVER['REQUEST_URI'];    
            for ($counter = 65; $counter < 91; $counter++) {
                $arr_letter_anchor[] = '<A HREF="' . $this_page_path . '#' . chr($counter) . '">' . chr($counter) . '</A>';
                $arr_letter_row [$counter] = '<TD ALIGN="center" COLSPAN="2">
<TABLE BORDER="0" CELLSPACING="1" CELLPADDING="2" ALIGN="center" WIDTH="100%">
    <TR>
            <TD ALIGN="center" CLASS="mainA" WIDTH="99%"><BIG><B>' .
                        chr($counter) .
                        '</B></BIG><A NAME="' . chr($counter) . '"></A></TD>
            <TD ALIGN="right" WIDTH="1%"><A HREF="' . $this_page_path . '#page_top">back&#160;to&#160;top</A></TD>
    </TR>
</TABLE>
</TD>';
            }
            $categ = $HTTP_GET_VARS['category'];
            if ($categ == '' && $HTTP_GET_VARS['model'] != '')$categ = $HTTP_GET_VARS['model'];
            $categoryLinkArray = array(
                'A' => ' > <a href="' . tep_href_link('products.php', 'show=assortments') . '">Assortment</a>',
                'C' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=C') . '">Cut & Polished Crystals</a>',
                'J' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=J') . '">Crystal Jewelry</a>',
                'N' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=N') . '">Natural Crystals & Minerals</a> (See <a href="' . tep_href_link('products.php', 'show=shape&category=N&quartz=1') . '">Clear Quartz</a> only)',
                'NQ' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=N') . '">Natural Crystals & Minerals</a> > <a href="' . tep_href_link('products.php', 'show=all&category=N&quartz=1') . '">Clear Quartz Crystals</a>',
                'T' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=T') . '">Tumbled Stones / Gemstones</a>',
                'V' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=V') . '">Other / Accessories</a>',
                'D' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=D') . '">Discontinued</a>',
            );
            $categoryNameArray = array(
      'A' => 'Assortment',
      'C' => 'Cut & Polished Crystals',
      'J' => 'Crystal Jewelry',
      'N' => 'Natural Crystals & Minerals',
      'NQ' => 'Quartz Crystals',
      'T' => 'Tumbled Stones / Gemstones',
      'V' => 'Other / Accessories',
      'D' => 'Discontinued',
    );
            if ($HTTP_GET_VARS['quartz'] == 1)$categ = "NQ";
            $breadcrumb_link =($categoryLinkArray[$categ] ? $categoryLinkArray[$categ] : '');
            $pageheading =($categoryNameArray[$categ] ? $categoryNameArray[$categ] : '');
            $cat_name = $categoryNameArray[$HTTP_GET_VARS['model']] ? $categoryNameArray[$HTTP_GET_VARS['model']] : '';
            switch ($HTTP_GET_VARS['show']) {
                case 'stone':
                    $breadcrumb_link .= ' > <a href="'.tep_href_link('taglist.php',tep_get_all_get_params()).'">Stone Names</a>';
                    $pageheading .=' - More Tags - Stone Names';
                    break;
                case 'show_all':                    
                    $breadcrumb_link .=' > <a href="' . tep_href_link('taglist.php', tep_get_all_get_params()) . '">Tags</a>';
                    $pageheading .=' - More Tags';
                    break;
                case 'stone_property':                    
                    if ($HTTP_GET_VARS['p_id'] == '14') {                        
                        switch ($HTTP_GET_VARS['show_issue']) {
                            case 'physical':
                                $breadcrumb_link .= ' > <a href="'.tep_href_link('taglist.php',tep_get_all_get_params()).'">Crystals by Issues & Ailments (Physical)</a>';
                                $pageheading .=' - More Tags - Crystals by Issues & Ailments (Physical)';
                                break;
                            case 'emotional':
                                $breadcrumb_link .= ' > <a href="'.tep_href_link('taglist.php',tep_get_all_get_params()).'">Crystals by Issues & Ailments (Emotional)</a>';
                                $pageheading .=' - More Tags - Crystals by Issues & Ailments (Emotional)';
                                break;
                            case 'spiritual':
                                $breadcrumb_link .=' > <a href="'.tep_href_link('taglist.php',tep_get_all_get_params()).'">Crystals by Issues & Ailments (Spiritual)</a>';
                                $pageheading .=' - More Tags - Crystals by Issues & Ailments (Spiritual)';
                                break;
                            case 'default':
                            case '':
                                $breadcrumb_link .= ' > <a href="'.tep_href_link('taglist.php',tep_get_all_get_params()).'">Crystals by Issues & Ailments (All)</a>';
                                $pageheading .=' - More Tags - Crystals by Issues & Ailments (All)';
                                break;
                        } 
                    } else {
                        $breadcrumb_link .= ' > <a href="'.tep_href_link('taglist.php',tep_get_all_get_params()).'">'.str_replace('<br />', ' ', $stone_property_name_array[$HTTP_GET_VARS['p_id']]).'</a>';
                        $pageheading .=' - More Tags - '.str_replace('<br />', ' ', $stone_property_name_array[$HTTP_GET_VARS['p_id']]);
                                
                    }
                    break;
                case 'product_property':
                    $breadcrumb_link .= ' > <a href="'.tep_href_link('taglist.php',tep_get_all_get_params()).'">'.str_replace('<br />', ' ', $product_property_name_array[$HTTP_GET_VARS['p_id']]).'</a>';
                    $pageheading .=' - More Tags - '.str_replace('<br />', ' ', $product_property_name_array[$HTTP_GET_VARS['p_id']]);
                    break;
            }
            break;
        case 'advanced_search_result.php':
            $categ = $HTTP_GET_VARS['category'];
            if ($categ == '' && $HTTP_GET_VARS['model'] != '')$categ = $HTTP_GET_VARS['model'];
            $categoryLinkArray = array(
                'A' => ' > <a href="' . tep_href_link('products.php', 'show=assortments') . '">Assortment</a>',
                'C' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=C') . '">Cut & Polished Crystals</a>',
                'J' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=J') . '">Crystal Jewelry</a>',
                'N' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=N') . '">Natural Crystals & Minerals</a> (See <a href="' . tep_href_link('products.php', 'show=shape&category=N&quartz=1') . '">Clear Quartz</a> only)',
                'NQ' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=N') . '">Natural Crystals & Minerals</a> > <a href="' . tep_href_link('products.php', 'show=all&category=N&quartz=1') . '">Clear Quartz Crystals</a>',
                'T' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=T') . '">Tumbled Stones / Gemstones</a>',
                'V' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=V') . '">Other / Accessories</a>',
                'D' => ' > <a href="' . tep_href_link('products.php', 'show=all&category=D') . '">Discontinued</a>',
            );
            if ($HTTP_GET_VARS['quartz'] == 1)$categ = "NQ";
            $breadcrumb_link =($categoryLinkArray[$categ] ? $categoryLinkArray[$categ] : '');
            $breadcrumb_link .= ' > <a href="'.tep_href_link('advanced_search_result.php',tep_get_all_get_params()).'">Search Results for '.$HTTP_GET_VARS['keywords'].'</a>';        
            if ($HTTP_GET_VARS['show_oos'] == 1)
                $breadcrumb_link .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:block;"><tr><td colspan="3" class="mainA"><a href="' . tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('show_oos'))) . '">Hide Out of Stock Products</a></td></tr></table>';
            else
                $breadcrumb_link .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:block;"><tr><td colspan="3" class="mainA"><a href="' . tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('show_oos')) . 'show_oos=1') . '">Display Out of Stock Products</a></td></tr></table>';
            
            break;
}
if($breadcrumb_link!=''){
?>
<table width="1020" cellspacing="0" cellpadding="0" align="center">
    
    <tr>
         <td style="width:125px;" id="showLeftMenuButton"><img  onclick="$('#leftmenubutton').toggle();$('#showLeftMenuButton').toggle();" src="images/left_menu_button_view.png" style="width:112px; height:25px;"></td>
        <td class="pageHeading3 breadcrump_lastchild" valign="middle" align="left" >
            
              <?php
            if(basename($PHP_SELF)== 'products_by_model.php'){
                echo '<a href="' . tep_href_link('index.php') . '" style="color:#959595;text-decoration: none;">Home</a>';
            }else{
             echo '<a href="' . tep_href_link('categories.html') . '" style="color:#959595;text-decoration: none;">All Products</a>';
            }
          echo $breadcrumb_link ;
            ?>
        </td>
<!--        <td ALIGN="right" valign="middle">
            <table><tr>
			    <?php /*if ($print_view != 'on') { ?> 
                    <td align="right">
                <div  class="addthis_toolbox addthis_default_style" style="display:inline-table"> <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=healingcrystals" class="addthis_button_expanded">Share</a> <a class="addthis_button_facebook"></a> <a class="addthis_button_myspace"></a> <a class="addthis_button_google"></a> <a class="addthis_button_twitter"></a> &nbsp;<a href="<?php echo tep_href_link("reviews_write.php"); ?>" title="Post a Comment, Leave Feedback and/or Rate this article" class="mainA" style="vertical-align:top;"><?//= tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/buttons/' . $language . '/' .  'button_post_a_comment.gif', 'Post a comment', '', '', 'style="vertical-align:middle;"');?></a></div></td>
                
                
                <?php }else{?><td align="right">&nbsp;</td><?php }*/ ?>
				 AddThis Follow BEGIN 
<td align="right">      
                               <div class="addthis_toolbox addthis_default_style">
<p style="float:left; margin-top:2px;">Follow Us</p>	
<a class="addthis_button_google_follow" addthis:userid="118159989747072814756" ></a>
<a class="addthis_button_youtube_follow" addthis:userid="healingcrystals" ></a>
<a class="addthis_button_pinterest_follow" addthis:userid="crystaltalk" ></a>
<a class="addthis_button_instagram_follow" addthis:userid="healingcrystals" ></a>
<a class="addthis_button_facebook_follow" addthis:userid="crystaltalk" ></a>
<a class="addthis_button_twitter_follow" addthis:userid="CrystalTalk" ></a>
</div></td>

 AddThis Follow END 
                    </tr>
               <tr><td align="right"> <div style="margin-top: 5px; color:#000000; font-size:13px;">
                
                    <b>Display Options</b>&nbsp;<select onchange="redirectPage(this.value)" id="dropdowngradient"><option value="summary_image" <?//= $hide_products_images != '1' ? 'selected' : '' ?>>Summary (w/Images)</option><option value="summary_text" <?//= $hide_products_images == '1' ? 'selected' : '' ?>>Summary (Text Only)</option><option value="print" <?//= $HTTP_GET_VARS['view'] == 'print' ? 'selected' : '' ?>>Print View</option></select>
     </div></td></tr></table>
        </td>                    -->
</tr>           
</table>

<?php } ?>

<?php 
$supplier = tep_db_fetch_array(tep_db_query("select suppliers_name from suppliers where suppliers_id = '".$_SESSION['suppliers_id']."'"));
$supplier_name = $supplier['suppliers_name'];
if(isset($_SESSION['suppliers_id']) && basename($_SERVER['PHP_SELF']) == 'vendor_page.php'){
	?>
	<table border="0" width="90%" align="center" cellspacing="0">
	  <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" width="60%" style="font-size: 17px;width: 90%;"><?php echo 'This is the&nbsp;'.$supplier_name .'&nbsp;Vendor Page'; ?></td>
          	<td class="pageHeading" align="right" style="font-size: 13px; padding-right:10px;width: 10%;" ><?php echo '<a href = "'. tep_href_link('suppliers_logout.php') .'">log out</a>';?></td>
		  </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	</table>
	<?php
}
elseif(isset($_SESSION['suppliers_id']) && basename($_SERVER['PHP_SELF']) == 'individual_pending_purchase_order.php'){
	?>
	<table border="0" width="90%" align="center" cellspacing="0">
		<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"  style="font-size: 17px;width: 90%;"><?php echo $supplier_name .'&nbsp;Individual Purchase Order page'; ?></td>
          	<td class="pageHeading" align="right"  style="font-size: 13px; padding-right:10px;width: 10%;" ><?php echo '<a href = "'. tep_href_link('suppliers_logout.php') .'">log out</a>';?></td>
		  </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	</table>
	<?php
}
elseif(isset($_SESSION['suppliers_id']) && basename($_SERVER['PHP_SELF']) == 'suppliers_comment.php'){
	?>
	<table border="0" width="90%" align="center" cellspacing="0">
		<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"  style="font-size: 17px;width: 90%;"><?php echo $supplier_name .'&nbsp;Comments page'; ?></td>
          	<td class="pageHeading" align="right"  style="font-size: 13px;width: 10%; padding-right:10px" ><?php echo '<a href = "'. tep_href_link('suppliers_logout.php') .'">log out</a>';?></td>
		  </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	</table>
	<?php
}
elseif(isset($_SESSION['suppliers_id']) && basename($_SERVER['PHP_SELF']) == 'combined_pending_purchase_order.php'){
	?>
	<table border="0" width="90%" align="center" cellspacing="0">
	  <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" style="font-size: 17px; width: 90%;"><?php echo $supplier_name .'&nbsp;Combined Purchase Order Page'; ?></td>
            <td class="pageHeading" align="right"  style="font-size: 13px; width: 10%; padding-right:10px" ><?php echo '<a href = "'. tep_href_link('suppliers_logout.php') .'">log out</a>';?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	</table>
	<?php
}
elseif(isset($_SESSION['suppliers_id']) && basename($_SERVER['PHP_SELF']) == 'vendorOrderInquiries.php'){
	?>
	<table border="0" width="90%" align="center" cellspacing="0">
	  <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" style="font-size: 17px; width: 90%;"><?php echo $supplier_name .'&nbsp; Order Inquiries Page'; ?></td>
            <td class="pageHeading" align="right"  style="font-size: 13px; width: 10%; padding-right:10px" ><?php echo '<a href = "'. tep_href_link('suppliers_logout.php') .'">log out</a>';?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	</table>
	<?php
}
elseif(isset($_SESSION['suppliers_id']) && basename($_SERVER['PHP_SELF']) == 'past_purchase_order.php'){
	?>
	<table border="0" width="90%" align="center" cellspacing="0">
		<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"  style="font-size: 17px;width: 90%;"><?php echo'Purchase Orders for&nbsp;' .$supplier_name; ?></td>
          	<td class="pageHeading" align="right" style="padding-right:10px; width: 10%; font-size: 13px;" ><?php echo '<a href = "'. tep_href_link('suppliers_logout.php') .'">log out</a>';?></td>
		  </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	</table>
	<?php
}
elseif(isset($_SESSION['suppliers_id']) && basename($_SERVER['PHP_SELF']) == 'update_log.php'){
	?>
	<table border="0" width="90%" align="center" cellspacing="0">
		<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"  style="width: 90%;font-size: 17px;"><?php echo'Update Log for&nbsp;' .$supplier_name; ?></td>
          	<td class="pageHeading" align="right"  style="width: 10%; padding-right:10px; font-size: 13px;" ><?php echo '<a href = "'. tep_href_link('suppliers_logout.php') .'">log out</a>';?></td>
		  </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	</table>
	<?php
}
//here is for product detail tabs....................
require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/tabs.php');
if((basename($PHP_SELF)=='products.php' || basename($PHP_SELF)=='taglist.php') && $HTTP_GET_VARS['show']!='wholesale'){
        ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td><?php include ('templates/'.TEMPLATE_NAME.'/filter_tabs.php'); ?></td>
    </tr>
    </table>
    <?php
    }

if($pageheading!=''){
?>
<table width="1020" cellspacing="0" cellpadding="0" align="center"> 
    <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
    <tr>
        <td class="pageHeading4" valign="middle" align="left" colspan="2">
			<div itemscope itemtype="http://schema.org/MedicalTherapy">
            	<span itemprop="name"><?php echo $pageheading; ?></span>
			</div>
        </td> 
    </tr>
    <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
    <tr>
        <td class="pageHeading5" valign="middle" align="left" colspan="2">
			<div itemscope itemtype="http://schema.org/MedicalTherapy">
            	<span itemprop="name"><?php echo $pageheading1; ?></span>
			</div>
        </td> 
    </tr>            
</table>
<?php } 
if($tertiary_tabs!='' && $HTTP_GET_VARS[strtolower($HTTP_GET_VARS['show'])]!=''){
?>
<table width="100%" cellspacing="0" cellpadding="0">
    <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td></tr>
    <tr>
        <td class="pageHeading4" valign="middle" align="left" colspan="2">
            <?php             
             echo $tertiary_tabs;
            ?>
        </td>                           
    </tr>            
</table> 
<?php } ?>