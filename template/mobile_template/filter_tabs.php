<?php /* ?>
<?php   $moreTagsArray = array( 'alternate_stone', 'size','location','quality','color','pchakra','schakra','crystal','composition','astro','vibration','hardness','rarity','mineral','ailment');?>
<table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="productstabs" class="productstabs">
    <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','5');?></td></tr>
    <tr>
        <td align="left" valign="bottom" width="100%">
            <table cellspacing="0" cellpadding="0">
                <?php
                $show_value = $HTTP_GET_VARS['show'];
                $show_value_tumbled = $HTTP_GET_VARS['show'];
                $all_products_link = tep_href_link("products.php", "category=&amp;show=".$show_value);
                if($show_value = 'all'){
                  $show_value ='shape';  
                  $show_value_tumbled ='stone';  
                  $all_products_link = tep_href_link("all_pictures.shtml");
                }
                //echo $HTTP_GET_VARS['category']
                ?>
                <tr>
                    <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show']!='stone') echo 'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"';?>><td class="<?= ($HTTP_GET_VARS['show']!='stone')?'tab_left_high':'tab_left_high_selected';?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['show']!='stone')?'tab_center_high':'tab_center_high_selected';?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link('products.php',tep_get_all_get_params(array('show','model')).'show=stone') ?>">By Stone<br/>Name</a></td><td class="<?= ($HTTP_GET_VARS['show']!='stone')?'tab_right_high':'tab_right_high_selected';?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                    <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show']!='shape') echo 'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"';?>><td class="<?= ($HTTP_GET_VARS['show']!='shape')?'tab_left_high':'tab_left_high_selected';?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['show']!='shape')?'tab_center_high':'tab_center_high_selected';?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link('products.php',tep_get_all_get_params(array('show','model')).'show=shape') ?>">By Shape<br/>Formation</a></td><td class="<?= ($HTTP_GET_VARS['show']!='shape')?'tab_right_high':'tab_right_high_selected';?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                    <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show']!='assortments') echo 'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"';?>><td class="<?= ($HTTP_GET_VARS['show']!='assortments')?'tab_left_high':'tab_left_high_selected';?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['show']!='assortments')?'tab_center_high':'tab_center_high_selected';?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link('products.php',tep_get_all_get_params(array('show','model')).'show=assortments') ?>">Assortments<br/>Only</a></td><td class="<?= ($HTTP_GET_VARS['show']!='assortments')?'tab_right_high':'tab_right_high_selected';?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                    <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show']!='specials') echo 'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"';?>><td class="<?= ($HTTP_GET_VARS['show']!='specials')?'tab_left_high':'tab_left_high_selected';?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['show']!='specials')?'tab_center_high':'tab_center_high_selected';?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link('products.php',tep_get_all_get_params(array('show','model')).'show=specials')?>">On Sale<br/>Today</a></td><td class="<?= ($HTTP_GET_VARS['show']!='specials')?'tab_right_high':'tab_right_high_selected';?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                    <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show']!='bestsellers') echo 'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"';?>><td class="<?= ($HTTP_GET_VARS['show']!='bestsellers')?'tab_left_high':'tab_left_high_selected';?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['show']!='bestsellers')?'tab_center_high':'tab_center_high_selected';?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link('products.php',tep_get_all_get_params(array('show','model')).'show=bestsellers') ?>">Best<br/>Sellers</a></td><td class="<?= ($HTTP_GET_VARS['show']!='bestsellers')?'tab_right_high':'tab_right_high_selected';?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                    <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'taglist')===false && !in_array($HTTP_GET_VARS['show'], $moreTagsArray)) echo 'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"';?>><td class="<?= (stripos($file, 'taglist')!==false || in_array($HTTP_GET_VARS['show'], $moreTagsArray))?'tab_left_high_selected':'tab_left_high';?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= (stripos($file, 'taglist')!==false || in_array($HTTP_GET_VARS['show'], $moreTagsArray))?'tab_center_high_selected':'tab_center_high';?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link('taglist.php').'?category='.$HTTP_GET_VARS['category'] ?>">More<br/>Tags</a></td><td class="<?= (stripos($file, 'taglist')!==false || in_array($HTTP_GET_VARS['show'], $moreTagsArray))?'tab_right_high_selected':'tab_right_high';?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                    <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show']!='all') echo 'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"';?>><td class="<?= ($HTTP_GET_VARS['show']!='all')?'tab_left_high':'tab_left_high_selected';?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['show']!='all')?'tab_center_high':'tab_center_high_selected';?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link('products.php',tep_get_all_get_params(array('show','model')).'show=all') ?>">All</a></td><td class="<?= ($HTTP_GET_VARS['show']!='all')?'tab_right_high':'tab_right_high_selected';?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                    <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show']!='wholesale_product') echo 'onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"';?>><td class="<?= ($HTTP_GET_VARS['show']!='wholesale_product')?'tab_left_high':'tab_left_high_selected';?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['show']!='wholesale_product')?'tab_center_high':'tab_center_high_selected';?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link('products.php',tep_get_all_get_params(array('show','model')).'show=wholesale_product') ?>">Wholesale</a></td><td class="<?= ($HTTP_GET_VARS['show']!='wholesale_product')?'tab_right_high':'tab_right_high_selected';?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                </tr>
            </table>
        </td>
    </tr>        
</table>
<?php */ ?>