<?php

/* 

Tabs.php

 */

 

$file = basename($_SERVER['PHP_SELF']);

$multipleTabSet = array();

//$multipleTabSet = array('best-selling-crystals.php','best-selling-crystals-text.php','clearance-crystals.php','clearance-crystals-text.php','sale_specials.php','sale_specials_text.php','allprods.php','allprodsprice.php','allprodsmodel.php','all_pictures.php');

$catalogSet = array('best-selling-crystals.php','best-selling-crystals-text.php','clearance-crystals.php','clearance-crystals-text.php','sale_specials.php','sale_specials_text.php','random_products.php','back_in_stock.php','new_arrivals.php','back_in_stock.php');

$productsSet = array('products.php','products1.php','prinatble-product-catalog-creator.php','allprods.php','allprodsprice.php','allprodsmodel.php','all_pictures.php','all_pictures_new.php','products_by_model.php');

$articleSet = array('article_info.php','articles.php','popular_articles.php','newsfeed.php');

$cardsSet = array('cards.php','quotes-welcome.php');

$searchSet = array('advanced_search_result.php');

$tagSet = array('taglist.php','tags.php','products_by_chemical_composition.php','stones_with_tag.php', 'stones_with_chemical_composition.php', 'stones_with_property.php');

$accountSet = array('account.php','account_edit.php','account_password.php','account_history.php','address_book.php','my_wishlist.php');

//$affiliateSet = array('affiliate_summary.php','affiliate_banners.php','affiliate_clicks.php','affiliate_sales.php','affiliate_faq.php', 'affiliate_coupon.php', 'affiliate_details.php');

$crystaltalkSet = array('crystaltalk.php');

$linkSet = array('links.php');

//$supplierSet = array('vendor_page.php','individual_pending_purchase_order.php','vendorOrderInquiries.php', 'combined_pending_purchase_order.php', 'past_purchase_order.php', 'suppliers_comment.php','update_log.php');

$supplierSet = array('vendor_page.php','individual_pending_purchase_order.php','vendorOrderInquiries.php', 'combined_pending_purchase_order.php', 'past_purchase_order.php', 'suppliers_comment.php','update_log.php');

$displayTabs = array();

$tab_count = 1;

$hide  = 'block';

if(in_array($file, $multipleTabSet)){   

    $displayTabs = array('search', 'catalog', 'products', 'tags');

	$hide = 'none';		

}/*elseif(isset($HTTP_GET_VARS['seltab']) && $HTTP_GET_VARS['seltab'] != ''){

	$displayTabs[] = $HTTP_GET_VARS['seltab'];

}*/elseif(in_array($file, $linkSet)){ 

	$displayTabs[] = 'links';

}elseif(in_array($file, $crystaltalkSet)){ 

	$displayTabs[] = 'crystaltalk';

}elseif(in_array($file, $cardsSet)){ 

	$displayTabs[] = 'cards';

}/*elseif(in_array($file, $affiliateSet)){ 

	$displayTabs[] = 'account';

	$displayTabs[] = 'affiliate';	

}*/elseif(in_array($file, $catalogSet)){   

    //if(stripos(basename($_SERVER['HTTP_REFERER']),'-tags')!== false or stripos(basename($_SERVER['HTTP_REFERER']),'tagged-items')!== false or stripos(basename($_SERVER['HTTP_REFERER']),'chemical_composition')!== false)$displayTabs[]='tags';

	if($HTTP_GET_VARS['seltab'] == 'products')$displayTabs[] = 'products';

	elseif($HTTP_GET_VARS['seltab'] == 'tags')$displayTabs[] = 'tags';

    //else $displayTabs = array('products', 'catalog');

        else $displayTabs = array( 'catalog');

}elseif(in_array($file, $productsSet)){

    if($HTTP_GET_VARS['show']=='wholesale')

		$displayTabs = array('products'); 

		//$displayTabs = array('products', 'catalog'); Modified for Ticket #1168 on 23-07-2015

	 elseif($HTTP_GET_VARS['seltab'] == 'catalog')$displayTabs = array('products', 'catalog');

	elseif($HTTP_GET_VARS['seltab'] == 'tags')$displayTabs[] = 'tags';

    else $displayTabs[] = 'products';

}elseif(in_array($file, $tagSet)){

	if($HTTP_GET_VARS['seltab'] == 'products')$displayTabs[] = 'products';

	else $displayTabs[] = 'tags';

}elseif(in_array($file, $articleSet)){

    if($HTTP_GET_VARS['articles_id']=='2810')$displayTabs[]='metaphysical';	

	elseif($HTTP_GET_VARS['articles_id']=='1859' || $HTTP_GET_VARS['articles_id']=='1860' || $HTTP_GET_VARS['articles_id']=='1862')$displayTabs[]='crystaltalk';	

	elseif(isset( $HTTP_GET_VARS['articles_id'])) $displayTabs[] = 'articles';

    elseif($file == 'articles.php' && isset($HTTP_GET_VARS['search']))$displayTabs[]='search';

    elseif( stripos  ( $_SERVER['REQUEST_URI']  , '_PFT_' ) === FALSE && stripos  ( $_SERVER['REQUEST_URI']  , '-PFT-' ) === FALSE && $current_topic_id == '13')$displayTabs[]='metaphysical';

    elseif($current_topic_id=='3')$displayTabs[]='metaphysical';    

}elseif(in_array($file, $searchSet)) $displayTabs[] = 'search';

elseif(in_array($file, $supplierSet)) $displayTabs[] = 'supplier';

elseif(in_array($file, $accountSet)) $displayTabs = array('account');

foreach($displayTabs as $key){

switch ($key){

    case 'catalog':

        ?>

        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="catalogtabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

                <tr>

                    <td align="left" valign="bottom" width="100%">

                        <table class="tabs_design" cellspacing="0" cellpadding="0">

                            <tr>

							    

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file,'specials')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'specials')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'specials')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "sale_specials.php"); ?>">Sale<br/>Items</a></td><td class="<?= stripos($file, 'specials')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'clearance')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'clearance')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'clearance')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "clearance-crystals.php"); ?>">Clearance<br/>Items</a></td><td class="<?= stripos($file, 'clearance')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'best-selling')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'best-selling')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'best-selling')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "best-selling-crystals.php"); ?>">Best<br/>Sellers</a></td><td class="<?= stripos($file, 'best-selling')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                 <!--<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'products.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'products.php')!==false && $HTTP_GET_VARS['show'] == 'wholesale'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'products.php')!==false && $HTTP_GET_VARS['show'] == 'wholesale'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "products.php",'show=wholesale'); ?>">Wholesale<br/>catalog</a></td><td class="<?= stripos($file, 'products.php')!==false && $HTTP_GET_VARS['show'] == 'wholesale'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>-->

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'wholesale-catalog')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'wholesale-catalog')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'wholesale-catalog')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "wholesale-catalog.html/".$HTTP_GET_VARS['category']); ?>">Wholesale<br/>catalog</a></td><td class="<?= stripos($file, 'wholesale-catalog')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>
                                 
                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'new_arrivals')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'new_arrivals')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'new_arrivals')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "new_arrivals.php"); ?>">New<br/>Items</a></td><td class="<?= stripos($file, 'new_arrivals')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'back_in_stock')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'back_in_stock')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'back_in_stock')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "back_in_stock.php"); ?>">Back in<br/>Stock</a></td><td class="<?= stripos($file, 'back_in_stock')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'random')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);" <?php } ?>><td class="<?= stripos($file, 'random')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'random')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "random_products.php"); ?>">Discover</a></td><td class="<?= stripos($file, 'random')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'catalog')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);" <?php } ?>><td class="<?= stripos($file, 'catalog')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'catalog')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "catalog"); ?>">Quick<br/>Catalog</a></td><td class="<?= stripos($file, 'catalog')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'products_by_model')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file,'products_by_model')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file,'products_by_model')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("products_by_model.php"); ?>">Complete<br/>Catalog</a></td><td class="<?= stripos($file,'products_by_model')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                 <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'highvibe')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file,'highvibe')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file,'highvibe')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("highvibe.php"); ?>">High<br/>Vibe</a></td><td class="<?= stripos($file,'highvibe')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            </tr>

                        </table>

                    </td>

                </tr>

            </table>

        <?php

        break;

    case 'products1':

    case 'products':

        ?>

        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="productstabs" class="productstabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

                <tr>

                    <td align="left" valign="bottom" width="100%">

                        <table class="tabs_main_design" cellspacing="0" cellpadding="0">

                            <?php

                            $show_value = $HTTP_GET_VARS['show'];

                            //echo $show_value;                           

                            if($show_value == 'all' || $show_value=='wholesale'){

                              $show_value ='shape';  

                              if($HTTP_GET_VARS['category']=='T')$show_value ='stone';  

                              

                            }

                            $all_products_link = tep_href_link("products.php", "show=".$show_value);

							

                            ?>

                            <tr>                                

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'J') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='J'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='J'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("products.php", "category=J&amp;show=".$show_value); ?>">Crystal<br />Jewelry</a></td><td class="<?= $HTTP_GET_VARS['category']=='J'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'C') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='C'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='C'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("products.php", "category=C&amp;show=".$show_value); ?>">Cut & Polished<br />Crystals</a></td><td class="<?= $HTTP_GET_VARS['category']=='C'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'N') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='N'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='N'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("products.php", "category=N&amp;show=".$show_value); ?>">Natural Crystals<br />& Minerals</a></td><td class="<?= $HTTP_GET_VARS['category']=='N'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'T') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='T'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='T'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("products.php", "category=T&amp;show=".$show_value); ?>">Tumbled Stones<br />& Gemstones</a></td><td class="<?= $HTTP_GET_VARS['category']=='T'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'V') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='V'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='V'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("products.php", "category=V&amp;show=".$show_value); ?>">Other /<br />Accessories</a></td><td class="<?= $HTTP_GET_VARS['category']=='V'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'all' && isset($HTTP_GET_VARS['category']) || $file != 'products.php' && $file != 'all_pictures.php') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= (($HTTP_GET_VARS['category']=='' && $file == 'products.php') || $file == 'all_pictures.php' )?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= (($HTTP_GET_VARS['category']=='' && $file == 'products.php') || $file == 'all_pictures.php')?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo $all_products_link; ?>">All<br />Products</a></td><td class="<?= (($HTTP_GET_VARS['category']=='' && $file == 'products.php') || $file == 'all_pictures.php')?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

				<td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'all_pictures')===false && stripos($file, 'allprods')===false && stripos($file, 'printable-product')=== false && stripos($file, 'products_by_model')=== false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false|| stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false || stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "categories.html"); ?>">Catalog</a></td><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false || stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>                                

                            </tr>

                        </table>

                    </td>

                </tr>

                <?php

                //if(stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!== false || stripos($file, 'printable-product')!== false ||  stripos($file, 'products_by_model')!== false){

                $file = $_SERVER[REQUEST_URI];

				

                ?> 

				<tr>

                	<td>

						<?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?>
                        

                	</td>

            	</tr>               

                <tr>

                    <td>

                        <table class="tabs_main_design" BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;">

						  

                            <tr>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'featured-items') ===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file,'featured-items')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file,'featured-items')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href">

								<a href="<?php echo tep_href_link("featured-items.html/".$HTTP_GET_VARS['category']); ?>">Featured <br/>Items</a>

								</td><td class="<?= stripos($file,'featured-items')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?>

								</td></tr>

								</table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'specimen-catalog')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file,'specimen-catalog')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file,'specimen-catalog')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("specimen-catalog.html/".$HTTP_GET_VARS['category']); ?>">Specimen<br/>Catalog</a></td><td class="<?= stripos($file,'specimen-catalog')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?>

								</td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'wholesale-catalog')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file,'wholesale-catalog')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file,'wholesale-catalog')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("wholesale-catalog.html/".$HTTP_GET_VARS['category']); ?>">Wholesale<br/>Catalog</a></td><td class="<?= stripos($file,'wholesale-catalog')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'high-vibe')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file,'high-vibe')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file,'high-vibe')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("high-vibe.html/".$HTTP_GET_VARS['category']); ?>">High<br/>Vibe</a></td><td class="<?= stripos($file,'high-vibe')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'special-value')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file,'special-value')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file,'special-value')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("special-value.html/".$HTTP_GET_VARS['category']); ?>">Special<br/>Value</a></td><td class="<?= stripos($file,'special-value')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

				<td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'categories')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file,'categories')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file,'categories')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("categories.html"); ?>">Product<br/>Categories</a></td><td class="<?= stripos($file,'categories')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'all_pictures')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'all_pictures')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'all_pictures')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "all_pictures.shtml"); ?>">Picture<br/>Catalog</a></td><td class="<?= stripos($file, 'all_pictures')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'allprods')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'allprods')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'allprods')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "allprods.shtml"); ?>">Text<br/>Catalog</a></td><td class="<?= stripos($file, 'allprods')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td class="tabs_design_td" style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'printable-product')===false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'printable-product')!==false?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'printable-product')!==false?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "printable-product-catalog.html" , ""); ?>">Print<br/>Catalog</a></td><td class="<?= stripos($file, 'printable-product')!==false?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                

                                <td width="100%"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

                            </tr>

                        </table>

                    </td>

                </tr>

                <?php

                //}

                ?>

            </table>

        <?php

        break;

    case 'articles':

        $articles_topic_query = tep_db_query("select a2t.topics_id from articles_to_topics a2t, topics t where t.topics_id = a2t.topics_id and articles_id = '" . $HTTP_GET_VARS['articles_id'] . "' order by t.catalog_display_order limit 1");

	$articles_topic = tep_db_fetch_array($articles_topic_query);

	$articles_topic_name = tep_get_topics_name($articles_topic['topics_id']);

	$articles_name = tep_get_articles_name($HTTP_GET_VARS['articles_id']);

        strlen($articles_name)>60?$articles_name = substr($articles_name, 0, '60').'...':'';

		?>

        <table BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;" id="tabs">

            <tr><td ><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

            <tr>

                <td >

                    <table class="tabs_design" BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;">                        
 
                        <tr>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file!='article_info.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='article_info.php'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='article_info.php'?'tab_center_high_selected':'tab_center_high' ?>" height="40" <?= strlen($articles_name)>30?'width=280':''?> nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "article_info.php" , "articles_id=".$HTTP_GET_VARS['articles_id']); ?>"><?=$articles_name ?></a></td><td class="<?= $file=='article_info.php'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file!='popular_articles.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='popular_articles.php'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='popular_articles.php'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "popular_articles.php" , "articles_id=".$HTTP_GET_VARS['articles_id']."&tPath=".$articles_topic['topics_id']); ?>">Most Popular<br />Articles</a></td><td class="<?= $file=='popular_articles.php'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center" ><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file!='articles.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='articles.php'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='articles.php'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "articles.php" , "articles_id=".$HTTP_GET_VARS['articles_id']."&tPath=".$articles_topic['topics_id']); ?>"><?=$articles_topic_name ?><br />Category</a></td><td class="<?= $file=='articles.php'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td   style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file!='newsfeed.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='newsfeed.php'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='newsfeed.php'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "newsfeed.php" , "articles_id=".$HTTP_GET_VARS['articles_id']."&tPath=".$articles_topic['topics_id']); ?>">Newsfeed<br />Recent Updates</a></td><td class="<?= $file=='newsfeed.php'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td width="100%">

                            <?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?>

                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

        <?php

        break;

    case 'tags':

        $stone_property_name_array = array('2' => 'Chakra<br/>(Primary)', '12' => 'Chakra<br/>(Secondary)', '3' => 'Crystal<br />System', '4' => 'Chemical<br />Composition', '5' => 'Astrological<br />Sign', '6' => 'Numerical<br />Vibration', '7' => 'Hardness', '10' => 'Rarity', '13' => 'Mineral<br />Class', '14' => 'Issues &<br />Ailments');

        $product_property_name_array = array('Location' => 'Location', 'Quality' => 'Quality', 'Color' => 'Color');

        ?>

        <table width="1020" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="tagstabs" class="tagstabs" align="center" >

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

            <tr>

                <td align="left" valign="bottom" width="100%">

                    <table class="tabs_design" cellspacing="0" cellpadding="0">

                        <tr>                            

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['model'] != 'J') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['model']=='J'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['model']=='J'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('model')).'model=J'); ?>">Crystal<br />Jewelry</a></td><td class="<?= $HTTP_GET_VARS['model']=='J'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['model'] != 'C') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['model']=='C'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['model']=='C'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('model')).'model=C'); ?>">Cut & Polished<br />Crystals</a></td><td class="<?= $HTTP_GET_VARS['model']=='C'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['model'] != 'N') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['model']=='N'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['model']=='N'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('model')).'model=N'); ?>">Natural Crystals<br />& Minerals</a></td><td class="<?= $HTTP_GET_VARS['model']=='N'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['model'] != 'T') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['model']=='T'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['model']=='T'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('model')).'model=T'); ?>">Tumbled Stones<br />& Gemstones</a></td><td class="<?= $HTTP_GET_VARS['model']=='T'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['model'] != 'V') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['model']=='V'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['model']=='V'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('model')).'model=V'); ?>">Other /<br />Accessories</a></td><td class="<?= $HTTP_GET_VARS['model']=='V'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['model'] != 'all' && isset($HTTP_GET_VARS['model'])) { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= ($HTTP_GET_VARS['model']=='' )?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['model']=='')?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('model'))); ?>">All<br />Products</a></td><td class="<?= ($HTTP_GET_VARS['model']=='' )?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

								<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'all_pictures')===false && stripos($file, 'allprods')===false && stripos($file, 'printable-product')=== false && stripos($file, 'products_by_model')=== false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false|| stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false || stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "allprods.shtml"); ?>">Catalog</a></td><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false || stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                        </tr>

                    </table>

                </td>

            </tr>

			<?php

                                if ($HTTP_GET_VARS['p_id'] == '14') {

                        ?>

            <tr>

                <td>

<?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?>

                </td>

            </tr>

            <tr>

                <td align="left" valign="bottom" width="100%">

                    <table class="tabs_design" cellspacing="0" cellpadding="0">

                        <tr>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show_issue'] != ''){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show_issue'] == '' ? 'tab_left_high_selected' : 'tab_left_high'; ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show_issue'] == '' ? 'tab_center_high_selected' : 'tab_center_high'; ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14"); ?>">Issues & Ailments<br/>(All)</a></td><td class="<?= $HTTP_GET_VARS['show_issue'] == '' ? 'tab_right_high_selected' : 'tab_right_high'; ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show_issue'] != 'physical'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show_issue'] == 'physical' ? 'tab_left_high_selected' : 'tab_left_high'; ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'physical' ? 'tab_center_high_selected' : 'tab_center_high'; ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14&amp;show_issue=physical"); ?>">Issues & Ailments<br/>(Physical)</a></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'physical' ? 'tab_right_high_selected' : 'tab_right_high'; ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show_issue'] != 'emotional'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show_issue'] == 'emotional' ? 'tab_left_high_selected' : 'tab_left_high'; ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'emotional' ? 'tab_center_high_selected' : 'tab_center_high'; ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14&amp;show_issue=emotional"); ?>">Issues & Ailments<br/>(Emotional)</a></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'emotional' ? 'tab_right_high_selected' : 'tab_right_high'; ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show_issue'] != 'spiritual'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show_issue'] == 'spiritual' ? 'tab_left_high_selected' : 'tab_left_high'; ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'spiritual' ? 'tab_center_high_selected' : 'tab_center_high'; ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14&amp;show_issue=spiritual"); ?>">Issues & Ailments<br/>(Spiritual)</a></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'spiritual' ? 'tab_right_high_selected' : 'tab_right_high'; ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                        </tr>

                    </table>

                </td>

            </tr>

<?php

                                }

?>

        </table>

        <?php

        break;

    case 'tags_old':

        $stone_property_name_array = array('2' => 'Chakra<br/>(Primary)', '12' => 'Chakra<br/>(Secondary)', '3' => 'Crystal<br />System', '4' => 'Chemical<br />Composition', '5' => 'Astrological<br />Sign', '6' => 'Numerical<br />Vibration', '7' => 'Hardness', '10' => 'Rarity', '13' => 'Mineral<br />Class', '14' => 'Issues &<br />Ailments');

        $product_property_name_array = array('Location' => 'Location', 'Quality' => 'Quality', 'Color' => 'Color');

        ?>

        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="tagstabs" class="tagstabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

            <tr>

                <td align="left" valign="bottom" width="100%">

                    <table class="tabs_design" cellspacing="0" cellpadding="0">

                        <tr>                            

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '5' && $HTTP_GET_VARS['tab'] != '5'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '5' || $HTTP_GET_VARS['tab'] == '5') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '5' || $HTTP_GET_VARS['tab'] == '5') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=5"); ?>"><?= $stone_property_name_array[5]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '5' || $HTTP_GET_VARS['tab'] == '5') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show'] != 'stone'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show'] == 'stone' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show'] == 'stone' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone"); ?>">By<br/>Stone Name</a></td><td class="<?= $HTTP_GET_VARS['show'] == 'stone' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '2' && $HTTP_GET_VARS['tab'] != '2'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '2' || $HTTP_GET_VARS['tab'] == '2') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '2' || $HTTP_GET_VARS['tab'] == '2') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=2"); ?>"><?= $stone_property_name_array[2]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '2' || $HTTP_GET_VARS['tab'] == '2') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '12' && $HTTP_GET_VARS['tab'] != '12'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '12' || $HTTP_GET_VARS['tab'] == '12') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '12' || $HTTP_GET_VARS['tab'] == '12') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=12"); ?>"><?= $stone_property_name_array[12]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '12' || $HTTP_GET_VARS['tab'] == '12') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != 'Color' && $HTTP_GET_VARS['tab'] != 'Color'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == 'Color'|| $HTTP_GET_VARS['tab'] == 'Color')? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == 'Color'|| $HTTP_GET_VARS['tab'] == 'Color') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=product_property&amp;p_id=Color"); ?>"><?= $product_property_name_array['Color']; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == 'Color'|| $HTTP_GET_VARS['tab'] == 'Color') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '14' && $HTTP_GET_VARS['tab'] != '14'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '14' || $HTTP_GET_VARS['tab'] == '14') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '14' || $HTTP_GET_VARS['tab'] == '14') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14"); ?>"><?= $stone_property_name_array[14]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '14' || $HTTP_GET_VARS['tab'] == '14') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != 'Location' && $HTTP_GET_VARS['tab'] != 'Location'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['p_id'] == 'Location'|| $HTTP_GET_VARS['tab'] == 'Location' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['p_id'] == 'Location'|| $HTTP_GET_VARS['tab'] == 'Location' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=product_property&amp;p_id=" . 'Location'); ?>"><?= $product_property_name_array['Location']; ?></a></td><td class="<?= $HTTP_GET_VARS['p_id'] == 'Location' || $HTTP_GET_VARS['tab'] == 'Location' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <?php echo '</tr><tr><td class="main">' . tep_draw_separator('pixel_trans.gif', '100%', '5') . '</td></table><table cellspacing="0" cellpadding="0"><tr>';?>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '4' && $HTTP_GET_VARS['tab'] != '4' && $file != 'products_by_chemical_composition.php' && $file != 'stones_with_chemical_composition.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '4' || $HTTP_GET_VARS['tab'] == '4' || $file == 'products_by_chemical_composition.php' || $file == 'stones_with_chemical_composition.php') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '4' || $HTTP_GET_VARS['tab'] == '4' || $file == 'products_by_chemical_composition.php' || $file == 'stones_with_chemical_composition.php') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=4"); ?>"><?= $stone_property_name_array[4]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '4' || $HTTP_GET_VARS['tab'] == '4' || $file == 'products_by_chemical_composition.php' || $file == 'stones_with_chemical_composition.php') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '3' && $HTTP_GET_VARS['tab'] != '3'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '3' || $HTTP_GET_VARS['tab'] == '3') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '3' || $HTTP_GET_VARS['tab'] == '3') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=3"); ?>"><?= $stone_property_name_array[3]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '3' || $HTTP_GET_VARS['tab'] == '3') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '7' && $HTTP_GET_VARS['tab'] != '7'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '7' || $HTTP_GET_VARS['tab'] == '7') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '7' || $HTTP_GET_VARS['tab'] == '7') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=7"); ?>"><?= $stone_property_name_array[7]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '7' || $HTTP_GET_VARS['tab'] == '7') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '13' && $HTTP_GET_VARS['tab'] != '13'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '13' || $HTTP_GET_VARS['tab'] == '13') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '13' || $HTTP_GET_VARS['tab'] == '13') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=13"); ?>"><?= $stone_property_name_array[13]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '13' || $HTTP_GET_VARS['tab'] == '13') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '6' && $HTTP_GET_VARS['tab'] != '6'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '6' || $HTTP_GET_VARS['tab'] == '6') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '6' || $HTTP_GET_VARS['tab'] == '6') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=6"); ?>"><?= $stone_property_name_array[6]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '6' || $HTTP_GET_VARS['tab'] == '6') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != 'Quality' && $HTTP_GET_VARS['tab'] != 'Quality'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['p_id'] == 'Quality'|| $HTTP_GET_VARS['tab'] == 'Quality' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="Quality.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['p_id'] == 'Quality'|| $HTTP_GET_VARS['tab'] == 'Quality' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=product_property&amp;p_id=" . 'Quality'); ?>"><?= $product_property_name_array['Quality']; ?></a></td><td class="<?= $HTTP_GET_VARS['p_id'] == 'Quality' || $HTTP_GET_VARS['tab'] == 'Quality' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="Quality.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['p_id'] != '10' && $HTTP_GET_VARS['tab'] != '10'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['p_id'] == '10' || $HTTP_GET_VARS['tab'] == '10') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '10' || $HTTP_GET_VARS['tab'] == '10') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=10"); ?>"><?= $stone_property_name_array[10]; ?></a></td><td class="<?= ($HTTP_GET_VARS['p_id'] == '10' || $HTTP_GET_VARS['tab'] == '10') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show'] != 'show_all'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show'] == 'show_all' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show'] == 'show_all' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("taglist.php",'show=show_all'); ?>" <?= $HTTP_GET_VARS['show'] == 'show_all' ? 'style="font-weight:bold;"':''?>>View All<br/>Tags</a></td><td class="<?= $HTTP_GET_VARS['show'] == 'show_all' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                        </tr>

                    </table>

                </td>

            </tr>

                        <?php

                                if ($HTTP_GET_VARS['p_id'] == '14') {

                        ?>

            <tr>

                <td>

<?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?>

                </td>

            </tr>

            <tr>

                <td align="left" valign="bottom" width="100%">

                    <table  class="tabs_design" cellspacing="0" cellpadding="0">

                        <tr>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show_issue'] != ''){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show_issue'] == '' ? 'tab_left_high_selected' : 'tab_left_high'; ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show_issue'] == '' ? 'tab_center_high_selected' : 'tab_center_high'; ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14"); ?>">Issues & Ailments<br/>(All)</a></td><td class="<?= $HTTP_GET_VARS['show_issue'] == '' ? 'tab_right_high_selected' : 'tab_right_high'; ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show_issue'] != 'physical'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show_issue'] == 'physical' ? 'tab_left_high_selected' : 'tab_left_high'; ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'physical' ? 'tab_center_high_selected' : 'tab_center_high'; ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14&amp;show_issue=physical"); ?>">Issues & Ailments<br/>(Physical)</a></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'physical' ? 'tab_right_high_selected' : 'tab_right_high'; ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show_issue'] != 'emotional'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show_issue'] == 'emotional' ? 'tab_left_high_selected' : 'tab_left_high'; ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'emotional' ? 'tab_center_high_selected' : 'tab_center_high'; ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14&amp;show_issue=emotional"); ?>">Issues & Ailments<br/>(Emotional)</a></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'emotional' ? 'tab_right_high_selected' : 'tab_right_high'; ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['show_issue'] != 'spiritual'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $HTTP_GET_VARS['show_issue'] == 'spiritual' ? 'tab_left_high_selected' : 'tab_left_high'; ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'spiritual' ? 'tab_center_high_selected' : 'tab_center_high'; ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14&amp;show_issue=spiritual"); ?>">Issues & Ailments<br/>(Spiritual)</a></td><td class="<?= $HTTP_GET_VARS['show_issue'] == 'spiritual' ? 'tab_right_high_selected' : 'tab_right_high'; ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                        </tr>

                    </table>

                </td>

            </tr>

<?php

                                }

?>

        </table>

        <?php

        break;

    case 'metaphysical':

        ?>

        <table BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;" id="tabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

            <tr>

                <td colspan="2">

                    <table class="tabs_design" BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;">

                        <tr>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($_SERVER['REQUEST_URI']!='/Metaphysical_Directory_Crystal_Guide_Topics_3.html'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory_Crystal_Guide_Topics_3.html'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory_Crystal_Guide_Topics_3.html'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="/Metaphysical_Directory_Crystal_Guide_Topics_3.html">Summary<br/>With Pictures</a></td><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory_Crystal_Guide_Topics_3.html'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($_SERVER['REQUEST_URI']!='/Metaphysical_Directory_Crystal_Guide_Text_Topics_3.html'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory_Crystal_Guide_Text_Topics_3.html'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory_Crystal_Guide_Text_Topics_3.html'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="/Metaphysical_Directory_Crystal_Guide_Text_Topics_3.html">Summary<br/>Text Only</a></td><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory_Crystal_Guide_Text_Topics_3.html'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($_SERVER['REQUEST_URI']!='/Metaphysical_Directory__Detailed_Topics_13.html'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory__Detailed_Topics_13.html'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory__Detailed_Topics_13.html'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="/Metaphysical_Directory__Detailed_Topics_13.html">Full Text<br/>Listing</a></td><td class="<?= $_SERVER['REQUEST_URI']=='/Metaphysical_Directory__Detailed_Topics_13.html'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file!='article_info.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='article_info.php'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='article_info.php'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("article_info.php", "articles_id=2810"); ?>">More<br/>Metaphysical Guides</a></td><td class="<?= $file=='article_info.php'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td width="100%"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

        <?php

        break;

    case 'search':

        if($HTTP_GET_VARS['keywords']!='')$HTTP_GET_VARS['search']=$HTTP_GET_VARS['keywords'];

        ?>

        <table BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="searchtabs">

            <tr>

                <td colspan="2">

                    <table class="tabs_design" BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;">

                        <tr>                                

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'J') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='J'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='J'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("advanced_search_result.php", tep_get_all_get_params(array('category','search')).'category=J'); ?>">Crystal<br />Jewelry</a></td><td class="<?= $HTTP_GET_VARS['category']=='J'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'C') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='C'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='C'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("advanced_search_result.php", tep_get_all_get_params(array('category','search')).'category=C'); ?>">Cut & Polished<br />Crystals</a></td><td class="<?= $HTTP_GET_VARS['category']=='C'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'N') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='N'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='N'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("advanced_search_result.php", tep_get_all_get_params(array('category','search')).'category=N'); ?>">Natural Crystals<br />& Minerals</a></td><td class="<?= $HTTP_GET_VARS['category']=='N'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'T') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='T'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='T'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("advanced_search_result.php", tep_get_all_get_params(array('category','search')).'category=T'); ?>">Tumbled Stones<br />& Gemstones</a></td><td class="<?= $HTTP_GET_VARS['category']=='T'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category'] != 'V') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['category']=='V'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['category']=='V'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("advanced_search_result.php", tep_get_all_get_params(array('category','search')).'category=V'); ?>">Other /<br />Accessories</a></td><td class="<?= $HTTP_GET_VARS['category']=='V'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['category']=='' || !isset($HTTP_GET_VARS['category'])) { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= ($HTTP_GET_VARS['category']=='' || !isset($HTTP_GET_VARS['category']))?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['category']=='' || !isset($HTTP_GET_VARS['category']))?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("advanced_search_result.php", tep_get_all_get_params(array('category','search'))); ?>">All<br />Products</a></td><td class="<?= ($HTTP_GET_VARS['category']=='' || !isset($HTTP_GET_VARS['category']))?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if(stripos($file, 'all_pictures')===false && stripos($file, 'allprods')===false && stripos($file, 'printable-product')=== false && stripos($file, 'products_by_model')=== false){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false|| stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false || stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "allprods_by_model.shtml"); ?>">Catalog</a></td><td class="<?= stripos($file, 'all_pictures')!==false || stripos($file, 'allprods')!==false || stripos($file, 'printable-product')!== false || stripos($file, 'products_by_model')!== false ? 'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>                                

                        </tr>

                    </table>

                </td>

            </tr>

            <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif','100%','5');?></td></tr>

            <tr>

                <td colspan="2">

                    <table class="tabs_design" BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;">

                        <tr>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'advanced_search_result.php') {?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='advanced_search_result.php'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='advanced_search_result.php'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "advanced_search_result.php","keywords=".$HTTP_GET_VARS['search']); ?>">Search Results for<br/>"<?=$HTTP_GET_VARS['search']?>"</a></td><td class="<?= $file=='advanced_search_result.php'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'articles.php') {?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='articles.php' && $HTTP_GET_VARS['tPath']!='3'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='articles.php' && $HTTP_GET_VARS['tPath']!='3'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link( "articles.php","tPath=&search=" . $HTTP_GET_VARS['search'] . "&amp;key=title"); ?>">Articles on<br />"<?=$HTTP_GET_VARS['search']?>"</a></td><td class="<?= $file=='articles.php' && $HTTP_GET_VARS['tPath']!='3'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'articles.php' && $HTTP_GET_VARS['tPath']!='3') {?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='articles.php' && $HTTP_GET_VARS['tPath']=='3'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='articles.php' && $HTTP_GET_VARS['tPath']=='3'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" style="color:#ffffff; font-weight:bold;"><a href="<?php echo tep_href_link( "Metaphysical_Directory_Crystal_Guide_Text_Topics_3.html" , "tPath=3&search=" . $HTTP_GET_VARS['search'] . "&key=title"); ?>">"<?=$HTTP_GET_VARS['search']?>" in our<br />Metaphysical Directory</a></td><td class="<?= $file=='articles.php' && $HTTP_GET_VARS['tPath']=='3'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'advanced_search.php') {?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $file=='advanced_search.php'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" onclick="location.href=this.nextSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file=='advanced_search.php'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("advanced_search.php"); ?>">Advanced Search<br />Options</a></td><td class="<?= $file=='advanced_search.php'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?=tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td width="100%"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

        <?php

        break;

	case 'links':

		?>

        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="linkstabs" class="linkstabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

                <tr>

                    <td align="left" valign="bottom" width="100%">

                        <table class="tabs_design" cellspacing="0" cellpadding="0">

                            <tr>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['lPath'] != '6') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['lPath']=='6'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['lPath']=='6'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("links.php", "lPath=6"); ?>">Crystal<br />and Jewelry</a></td><td class="<?= $HTTP_GET_VARS['lPath']=='6'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['lPath'] != '7') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['lPath']=='7'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['lPath']=='7'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("links.php", "lPath=7"); ?>">Metaphysical</a></td><td class="<?= $HTTP_GET_VARS['lPath']=='7'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['lPath'] != '8') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['lPath']=='8'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['lPath']=='8'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("links.php", "lPath=8"); ?>">More Great<br />Resources</a></td><td class="<?= $HTTP_GET_VARS['lPath']=='8'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['lPath'] != '4') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['lPath']=='4'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['lPath']=='4'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("links.php", "lPath=4"); ?>">Reiki<br />& Kinesiology</a></td><td class="<?= $HTTP_GET_VARS['lPath']=='4'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['lPath'] != '2') { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['lPath']=='2'?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['lPath']=='2'?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("links.php", "lPath=2"); ?>">Spiritual Sites<br />& Resources</a></td><td class="<?= $HTTP_GET_VARS['lPath']=='2'?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                                <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if ($HTTP_GET_VARS['lPath'] != 'all' && isset($HTTP_GET_VARS['lPath'])) { ?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php } ?>><td class="<?= $HTTP_GET_VARS['lPath']==''?'tab_left_high_selected':'tab_left_high' ?>" width="20" height="40" align="center"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $HTTP_GET_VARS['lPath']==''?'tab_center_high_selected':'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href"><a href="<?php echo tep_href_link("links.php"); ?>">Link<br />Partners</a></td><td class="<?= $HTTP_GET_VARS['lPath']==''?'tab_right_high_selected':'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            </tr>

                        </table>

                    </td>

                </tr>

            </table>

 <?php

       		break;	    

		case 'crystaltalk':

		?>

		 <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="crystaltalktabs" class="crystaltalktabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

            <tr>

                <td align="left" valign="bottom" width="100%">

                    <table class="tabs_design" cellspacing="0" cellpadding="0">

                        <tr>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'crystaltalk.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'crystaltalk.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'crystaltalk.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("crystaltalk.php"); ?>">Live<br/>Chat</a></td><td class="<?= $file == 'crystaltalk.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>							

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['articles_id'] != '1860'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['articles_id'] == '1860') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['articles_id'] == '1860') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("article_info.php", "articles_id=1860"); ?>">Healing<br />Profiles</a></td><td class="<?= ($HTTP_GET_VARS['articles_id'] == '1860') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($HTTP_GET_VARS['articles_id'] != '1859'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= ($HTTP_GET_VARS['articles_id'] == '1859') ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= ($HTTP_GET_VARS['articles_id'] == '1859') ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("article_info.php", "articles_id=1859"); ?>">Healing<br />Helpers</a></td><td class="<?= ($HTTP_GET_VARS['articles_id'] == '1859') ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>							

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"><td class="tab_left_high" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="tab_center_high" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="http://www.healingcrystals.com/forum/">Forum /<br />Message Board</a></td><td class="tab_right_high" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>  

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"><td class="tab_left_high" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="tab_center_high" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("article_info.php", "articles_id=1862"); ?>">Community &<br />Social Media</a></td><td class="tab_right_high" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>                            

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

	<?php

		break;

	case 'cards':

		?>

		 <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="cardstabs" class="cardstabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

            <tr>

                <td align="left" valign="bottom" width="100%">

                    <table class="tabs_design" cellspacing="0" cellpadding="0">

                        <tr>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'cards.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'cards.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'cards.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("cards.php"); ?>">Crystal<br/>Divination Cards</a></td><td class="<?= $file == 'cards.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'quotes-welcome.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'quotes-welcome.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'quotes-welcome.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("quotes-welcome.php"); ?>">Inspirational<br/>Quotes</a></td><td class="<?= $file == 'quotes-welcome.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'articles.php' || $HTTP_GET_VARS['tPath'] != '22'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'articles.php' && $HTTP_GET_VARS['tPath'] == '22' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'articles.php' && $HTTP_GET_VARS['tPath'] == '22' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("articles.php","tPath=22"); ?>">Contests &amp; Games</a></td><td class="<?= $file == 'articles.php' && $HTTP_GET_VARS['tPath'] == '22' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

	<?php

		break;

	/*case 'affiliate':

		if ($_SESSION['affiliate_id'] != '') {

		?>

		 <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="affiliatetabs" class="affiliatetabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

            <tr>

                <td align="left" valign="bottom" width="100%">

                    <table cellspacing="0" cellpadding="0">

                        <tr>

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'affiliate_summary.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'affiliate_summary.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'affiliate_summary.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("affiliate_summary.php"); ?>">Affilate<br/>Summary</a></td><td class="<?= $file == 'affiliate_summary.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'affiliate_banners.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'affiliate_banners.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'affiliate_banners.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("affiliate_banners.php"); ?>">Create a<br/>Banner</a></td><td class="<?= $file == 'affiliate_banners.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'affiliate_coupon.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'affiliate_coupon.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'affiliate_coupon.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("affiliate_coupon.php"); ?>">Create a<br/>Coupon</a></td><td class="<?= $file == 'affiliate_coupon.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'affiliate_clicks.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'affiliate_clicks.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'affiliate_clicks.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("affiliate_clicks.php"); ?>">Clickthrough<br/>Report</a></td><td class="<?= $file == 'affiliate_clicks.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'affiliate_sales.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'affiliate_sales.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'affiliate_sales.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("affiliate_sales.php"); ?>">Sales<br/>Report</a></td><td class="<?= $file == 'affiliate_sales.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'affiliate_details.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'affiliate_details.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'affiliate_details.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("affiliate_details.php"); ?>">Affiliate Account<br/>Information</a></td><td class="<?= $file == 'affiliate_details.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'affiliate_faq.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'affiliate_faq.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'affiliate_faq.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("affiliate_faq.php"); ?>">Affiliate<br/>FAQ</a></td><td class="<?= $file == 'affiliate_faq.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

						</tr>						

                    </table>

                </td>

            </tr>			

        </table>

		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="affiliatetabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','5');?></td></tr>

		</table>		

	<?php

		}

		break;*/

	case 'supplier':

        ?>

        <table BORDER="0" width="100%" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;" id="tabs">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

            <tr>

                <td colspan="2">

                    <table class="tabs_design" BORDER="0" align="center" CELLSPACING="0" CELLPADDING="0" style="border-bottom:1px solid #B6B7CB;">

                        <tr>

                            <td style="cursor:pointer;" align="left"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'update_log.php'){?>onmouseover="activateSupTab(this);" onmouseout="deactivateSupTab(this);"<?php }?>><td class="<?= $file == 'update_log.php' ? 'tab_sup_left_high_selected' : 'tab_sup_left_high' ?>" width="20" height="65" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td><td class="<?= $file == 'update_log.php' ? 'tab_sup_center_high_selected' : 'tab_sup_center_high' ?>" height="65" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link('update_log.php?vendor=sup'); ?>">Update Log</a></td><td class="<?= $file == 'update_log.php' ? 'tab_sup_right_high_selected' : 'tab_sup_right_high' ?>" width="20" height="65" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td></tr></table></td>

                        	<td style="cursor:pointer;" align="left"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'vendor_page.php'){?>onmouseover="activateSupTab(this);" onmouseout="deactivateSupTab(this);"<?php }?>><td class="<?= $file == 'vendor_page.php' ? 'tab_sup_left_high_selected' : 'tab_sup_left_high' ?>" width="20" height="65" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td><td class="<?= $file == 'vendor_page.php' ? 'tab_sup_center_high_selected' : 'tab_sup_center_high' ?>" height="65" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link('vendor_page.php?vendor=sup'); ?>">Supplier Information</a></td><td class="<?= $file == 'vendor_page.php' ? 'tab_sup_right_high_selected' : 'tab_sup_right_high' ?>" width="20" height="65" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="left"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'suppliers_comment.php'){?>onmouseover="activateSupTab(this);" onmouseout="deactivateSupTab(this);"<?php }?>><td class="<?= $file == 'suppliers_comment.php' ? 'tab_sup_left_high_selected' : 'tab_sup_left_high' ?>" width="20" height="65" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td><td class="<?= $file == 'suppliers_comment.php' ? 'tab_sup_center_high_selected' : 'tab_sup_center_high' ?>" height="65" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link('suppliers_comment.php?vendor=sup'); ?>">Comments</a></td><td class="<?= $file == 'suppliers_comment.php' ? 'tab_sup_right_high_selected' : 'tab_sup_right_high' ?>" width="20" height="65" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="left"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'individual_pending_purchase_order.php'){?>onmouseover="activateSupTab(this);" onmouseout="deactivateSupTab(this);"<?php }?>><?php /*<td class="<?= $file == 'individual_pending_purchase_order.php' ? 'tab_sup_left_high_selected' : 'tab_sup_left_high' ?>" width="20" height="65" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td><td class="<?= $file == 'individual_pending_purchase_order.php' ? 'tab_sup_center_high_selected' : 'tab_sup_center_high' ?>" height="65" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link('individual_pending_purchase_order.php?vendor=sup'); ?>">Order Inquiries <br/> and PO's</a></td><td class="<?= $file == 'individual_pending_purchase_order.php' ? 'tab_sup_right_high_selected' : 'tab_sup_right_high' ?>" width="20" height="65" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td>*/?></tr></table></td>

                                                        <td style="cursor:pointer;" align="left"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'vendorOrderInquiries.php'){?>onmouseover="activateSupTab(this);" onmouseout="deactivateSupTab(this);"<?php }?>><td class="<?= $file == 'vendorOrderInquiries.php' ? 'tab_sup_left_high_selected' : 'tab_sup_left_high' ?>" width="20" height="65" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td><td class="<?= $file == 'vendorOrderInquiries.php' ? 'tab_sup_center_high_selected' : 'tab_sup_center_high' ?>" height="65" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link('vendorOrderInquiries.php?vendor=sup'); ?>">Order Inquiries</a></td><td class="<?= $file == 'vendorOrderInquiries.php' ? 'tab_sup_right_high_selected' : 'tab_sup_right_high' ?>" width="20" height="65" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="left"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'combined_pending_purchase_order.php' && $HTTP_GET_VARS['orderby_pending']!='date_added'){?>onmouseover="activateSupTab(this);" onmouseout="deactivateSupTab(this);"<?php }?>><td class="<?= $file == 'combined_pending_purchase_order.php' && $HTTP_GET_VARS['orderby_pending']=='date_added' ? 'tab_sup_left_high_selected' : 'tab_sup_left_high' ?>" width="20" height="65" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td><td class="<?= $file == 'combined_pending_purchase_order.php' && $HTTP_GET_VARS['orderby_pending']=='date_added' ? 'tab_sup_center_high_selected' : 'tab_sup_center_high' ?>" height="65" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link('combined_pending_purchase_order.php?vendor=sup&orderby_pending=date_added'); ?>">Pending Orders<!--<br/>(by date)--></a></td><td class="<?= $file == 'combined_pending_purchase_order.php' && $HTTP_GET_VARS['orderby_pending']=='date_added'? 'tab_sup_right_high_selected' : 'tab_sup_right_high' ?>" width="20" height="65" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td></tr></table></td>

							<td style="cursor:pointer;" align="left"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'combined_pending_purchase_order.php' && $HTTP_GET_VARS['orderby_pending']!='products_model'){?>onmouseover="activateSupTab(this);" onmouseout="deactivateSupTab(this);"<?php }?>><?php/*<td class="<?= $file == 'combined_pending_purchase_order.php' && $HTTP_GET_VARS['orderby_pending']=='products_model' ? 'tab_sup_left_high_selected' : 'tab_sup_left_high' ?>" width="20" height="65" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td><td class="<?= $file == 'combined_pending_purchase_order.php' && $HTTP_GET_VARS['orderby_pending']=='products_model' ? 'tab_sup_center_high_selected' : 'tab_sup_center_high' ?>" height="65" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link('combined_pending_purchase_order.php?vendor=sup&orderby_pending=products_model'); ?>">Combined <br/> Purchase Order<br/>(by model)</a></td> <td class="<?= $file == 'combined_pending_purchase_order.php' && $HTTP_GET_VARS['orderby_pending']=='products_model' ? 'tab_sup_right_high_selected' : 'tab_sup_right_high' ?>" width="20" height="65" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td>*/ ?></tr></table></td>

							<td style="cursor:pointer;" align="left"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'past_purchase_order.php'){?>onmouseover="activateSupTab(this);" onmouseout="deactivateSupTab(this);"<?php }?>><td class="<?= $file == 'past_purchase_order.php' ? 'tab_sup_left_high_selected' : 'tab_sup_left_high' ?>" width="20" height="65" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td><td class="<?= $file == 'past_purchase_order.php' ? 'tab_sup_center_high_selected' : 'tab_sup_center_high' ?>" height="65" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link('past_purchase_order.php?vendor=sup'); ?>">Purchase Orders<br/>(listed by PO#)</a></td><td class="<?= $file == 'past_purchase_order.php' ? 'tab_sup_right_high_selected' : 'tab_sup_right_high' ?>" width="20" height="65" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '65'); ?></td></tr></table></td>

						</tr>

						<tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','5');?></td></tr>

                    </table>

                </td>

            </tr>

        </table>

        <?php

        break;

	case 'account':

		if($customer_id){

	?>

		<table width="100%" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #B6B7CB;display:<?=$hide; ?>" id="affiliatetabs" class="affiliatetabs">

           <tr>

                <td align="left" valign="bottom" width="100%">

                    <table  class="tabs_design" cellspacing="0" cellpadding="0">

						<tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','1');?></td></tr>

                        <tr>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'account.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'account.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'account.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("account.php",'','SSL'); ?>">Order<br/>Summary</a></td><td class="<?= $file == 'account.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'account_history.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'account_history.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'account_history.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("account_history.php",'','SSL'); ?>">Order<br/>History</a></td><td class="<?= $file == 'account_history.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							

                            

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'my_wishlist.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'my_wishlist.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'my_wishlist.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("my_wishlist.php",'','SSL'); ?>">Wishlist</a></td><td class="<?= $file == 'my_wishlist.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							

                            

                            

                            

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'account_edit.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'account_edit.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'account_edit.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("account_edit.php",'','SSL'); ?>">Account<br/>Information</a></td><td class="<?= $file == 'account_edit.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'address_book.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'address_book.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'address_book.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("address_book.php",'','SSL'); ?>">Address<br/>Book</a></td><td class="<?= $file == 'address_book.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							

                            <td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'account_password.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'account_password.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'account_password.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("account_password.php",'','SSL'); ?>">Change<br/>Password</a></td><td class="<?= $file == 'account_password.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td>

							

                                                        <?php /* // if ($_SESSION['customer_id'] == '') { ?>

							<td style="cursor:pointer;" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr <?php if($file != 'rewards_subscribe.php'){?>onmouseover="activateTab(this);" onmouseout="deactivateTab(this);"<?php }?>><td class="<?= $file == 'rewards_subscribe.php' ? 'tab_left_high_selected' : 'tab_left_high' ?>" width="20" height="40" align="center" onclick="location.href=this.nextSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td><td class="<?= $file == 'rewards_subscribe.php' ? 'tab_center_high_selected' : 'tab_center_high' ?>" height="40" nowrap="nowrap" onclick="location.href=this.childNodes[0].href" ><a href="<?php echo tep_href_link("rewards_subscribe.php"); ?>">Diamond<br/>club</a></td><td class="<?= $file == 'rewards_subscribe.php' ? 'tab_right_high_selected' : 'tab_right_high' ?>" width="20" height="40" onclick="location.href=this.previousSibling.childNodes[0].href"><?= tep_draw_separator('pixel_trans.gif', '20', '40'); ?></td></tr></table></td> 

							<?php// } */?>

							<td width="100%"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

						</tr>						

                    </table>

                </td>

            </tr>			

        </table>

	<?php

		}		

		break;

}

if(count($displayTabs) > $tab_count){

?>

		<table width="100%" cellspacing="0" cellpadding="0" border="0">

            <tr><td><?php echo tep_draw_separator('pixel_trans.gif','100%','10');?></td></tr>

		</table>

<?php

}

$tab_count++;

}

?>