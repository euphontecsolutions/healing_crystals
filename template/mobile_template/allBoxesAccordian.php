
<script>
$(document).ready(function(){
    $(".left_menu_toggle").click(function(){
        $(".left_toggle_list").toggle();
    });
	  $(".left_menu_toggle1").click(function(){
        $(".left_toggle_list1").toggle();
    });
	  $(".left_menu_toggle2").click(function(){
        $(".left_toggle_list2").toggle();
    });
	  $(".left_menu_toggle3").click(function(){
        $(".left_toggle_list3").toggle();
    });
	  $(".left_menu_toggle4").click(function(){
        $(".left_toggle_list4").toggle();
    });
	  $(".left_menu_toggle5").click(function(){
        $(".left_toggle_list5").toggle();
    });
	  $(".left_menu_toggle6").click(function(){
        $(".left_toggle_list6").toggle();
    });
	  $(".left_menu_toggle7").click(function(){
        $(".left_toggle_list7").toggle();
    });
	  $(".left_menu_toggle8").click(function(){
        $(".left_toggle_list8").toggle();
    });
	 $(".left_menu_toggle9").click(function(){
        $(".left_toggle_list9").toggle();
    });
	 $(".left_menu_toggle10").click(function(){
        $(".left_toggle_list10").toggle();
    });
	 $(".left_menu_toggle11").click(function(){
        $(".left_toggle_list11").toggle();
    });
	 $(".left_menu_toggle12").click(function(){
        $(".left_toggle_list12").toggle();
    });
	 $(".left_menu_toggle13").click(function(){
        $(".left_toggle_list13").toggle();
    });
	 $(".left_menu_toggle14").click(function(){
        $(".left_toggle_list14").toggle();
    });

});
</script>
<tr><td>
		<table cellspacing="0" cellpadding="0" border="0" class="leftNavTable">
			<?php if($customer_id) {?>
                <tr>
                <td valign="bottom">
                    <div class="glossymenuHeader" style="width:190px;margin-bottom:5px;"><a class="menuitemNE menuitem" href="/my_wishlist.php">My Wishlist</a></div>
                </td>
                </tr>
                <?php } ?>
                <tr>
                <td valign="bottom">
                    <div class="glossymenuHeader"><a class="menuitem submenuleftheader" href="javascript:void(0);">Products / Catalog</a>
                        <div class="submenuleft">
                            <ul>
                                <li class="left_menu_li">
                                 <a href="<?=tep_href_link('sale_specials.php');?>"  id="one-ddheader" class="upperdd">On Sale Today &amp; Specials </a><span class="left_menu_toggle left_toggle_icon"></span>
                                 <ul id="one-ddcontent"  class="left_toggle_list left_nav_listU" >
                                 <li onmouseover="document.getElementById('one-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('sale_specials.php'); ?>">On Sale Today!</a></li>
                                                <li onmouseover="document.getElementById('one-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('clearance-crystals.php'); ?>">Items on Clearance</a></li>

                                                <li onmouseover="document.getElementById('one-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('new_options.php'); ?>">New Arrivals</a></li>
                                                <?php /*?><li onmouseover="document.getElementById('one-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('back_in_stock.php'); ?>">Back in Stock</a></li><?php */?>
                                                <li onmouseover="document.getElementById('one-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('random_products.php'); ?>">Discover</a></li>


                                 </ul>

                                </li>
								<li class="left_menu_li">
                                <a href="<?= tep_href_link('best-selling-crystals.php'); ?>">Best Sellers </a>
								</li>
                                <li class="left_menu_li">
                                <a  class="upperdd" href="<?=tep_href_link('products.php','show=assortments');?>">Assortments</a>
                                <span class="left_menu_toggle1 left_toggle_icon"></span>
         <ul class="left_toggle_list1 left_nav_listU"
>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'show=shape&shape=mix'); ?>">Crystal Healing Mixes</a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('tags.php', 'tag_name=Chakra Assortments'); ?>">Chakra Assortments</a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=assortments'); ?>">Crystal Jewelry</a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=assortments'); ?>">Cut &amp; Polished Crystals</a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=assortments'); ?>">Natural Crystals &amp; Minerals </a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=assortments&amp;quartz=1'); ?>">Quartz Crystals</a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=assortments'); ?>">Tumbled Stones &amp; Gemstones</a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=V&amp;show=assortments'); ?>">Other / Accessories</a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('tags.php', 'tag_name=Discount Assortments'); ?>">On Sale</a></li>
                                                <li onmouseover="document.getElementById('eight-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=&amp;show=assortments'); ?>">All</a></li>
                                            </ul>

                                </li>

                                <li class="left_menu_li">
                                <a href="<?=tep_href_link('products.php','category=N&amp;show=shape&amp;quartz=1');?>">Clear Quartz Crystals</a><span class="left_menu_toggle2 left_toggle_icon" ></span>
                              <ul  class="left_toggle_list2 left_nav_listU"
>
                                                <li onmouseover="document.getElementById('two-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=shape&amp;quartz=1'); ?>">by Shape</a></li>
                                                <li onmouseover="document.getElementById('two-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=stone&amp;quartz=1'); ?>">by Stone Type</a></li>
                                                <li onmouseover="document.getElementById('two-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=location&amp;quartz=1'); ?>">by Mining Location</a></li>
                                                <li onmouseover="document.getElementById('two-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=assortments&amp;quartz=1'); ?>">Assortments</a></li>
                                                <li onmouseover="document.getElementById('two-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=bestsellers&amp;quartz=1'); ?>">Best Sellers</a></li>
                                                <li onmouseover="document.getElementById('two-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=specials&amp;quartz=1'); ?>">On Sale</a></li>
                                                <li onmouseover="document.getElementById('two-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=clearance&amp;quartz=1'); ?>">Clearance</a></li>
                                                <li onmouseover="document.getElementById('two-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=all&amp;quartz=1'); ?>">All</a></li>
                                            </ul>

                                </li>
                                <li class="left_menu_li">
                                <a href="<?=tep_href_link('products.php','category=J&amp;show=shape');?>">Crystal Jewelry</a>
                                <span class="left_menu_toggle3 left_toggle_icon" ></span>
                              <ul class="left_toggle_list3 left_nav_listU"
>
                                                <li onmouseover="document.getElementById('three-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=shape'); ?>">by Shape</a></li>
                                                <li onmouseover="document.getElementById('three-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=stone'); ?>">by Stone Type</a></li>
                                                <li onmouseover="document.getElementById('three-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=location'); ?>">by Mining Location</a></li>
                                                <li onmouseover="document.getElementById('three-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=assortments'); ?>">Assortments</a></li>
                                                <li onmouseover="document.getElementById('three-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=bestsellers'); ?>">Best Sellers</a></li>
                                                <li onmouseover="document.getElementById('three-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=specials'); ?>">On Sale</a></li>
                                                <li onmouseover="document.getElementById('three-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=clearance'); ?>">Clearance</a></li>
                                                <li onmouseover="document.getElementById('three-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=J&amp;show=all'); ?>">All</a></li>
                                            </ul>

                                </li>
                                <li class="left_menu_li">
                                <a href="<?=tep_href_link('products.php','category=C&amp;show=shape');?>">Cut &amp; Polished Crystals</a>
                                  <span class="left_menu_toggle4 left_toggle_icon" ></span>
                                   <ul  class="left_toggle_list4 left_nav_listU">
                                                <li onmouseover="document.getElementById('four-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=shape'); ?>">by Shape</a></li>
                                                <li onmouseover="document.getElementById('four-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=stone'); ?>">by Stone Type</a></li>
                                                <li onmouseover="document.getElementById('four-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=location'); ?>">by Mining Location</a></li>
                                                <li onmouseover="document.getElementById('four-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=assortments'); ?>">Assortments</a></li>
                                                <li onmouseover="document.getElementById('four-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=bestsellers'); ?>">Best Sellers</a></li>
                                                <li onmouseover="document.getElementById('four-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=specials'); ?>">On Sale</a></li>
                                                <li onmouseover="document.getElementById('four-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=clearance'); ?>">Clearance</a></li>
                                                <li onmouseover="document.getElementById('four-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=C&amp;show=all'); ?>">All</a></li>
                                            </ul>
                                 </li>
                                <li class="left_menu_li">
                                <a href="<?=tep_href_link('products.php','category=N&amp;show=shape');?>">Natural Crystals &amp; Minerals</a> <span class="left_menu_toggle5 left_toggle_icon" ></span>
                                <ul class="left_toggle_list5 left_nav_listU">
                                                <li onmouseover="document.getElementById('five-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=shape'); ?>">by Shape</a></li>
                                                <li onmouseover="document.getElementById('five-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=stone'); ?>">by Stone Type</a></li>
                                                <li onmouseover="document.getElementById('five-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=location'); ?>">by Mining Location</a></li>
                                                <li onmouseover="document.getElementById('five-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=assortments'); ?>">Assortments</a></li>
                                                <li onmouseover="document.getElementById('five-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=bestsellers'); ?>">Best Sellers</a></li>
                                                <li onmouseover="document.getElementById('five-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=specials'); ?>">On Sale</a></li>
                                                <li onmouseover="document.getElementById('five-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=clearance'); ?>">Clearance</a></li>
                                                <li onmouseover="document.getElementById('five-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=N&amp;show=all'); ?>">All</a></li>
                                            </ul>

                                </li>
                                <li class="left_menu_li">
                                <a href="<?=tep_href_link('products.php','category=T&amp;show=stone');?>">Tumbled Stones</a>
                                <span class="left_menu_toggle6 left_toggle_icon" ></span>
                                <ul class="left_toggle_list6 left_nav_listU">
                                                <li onmouseover="document.getElementById('six-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=shape'); ?>">by Shape</a></li>
                                                <li onmouseover="document.getElementById('six-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=stone'); ?>">by Stone Type</a></li>
                                                <li onmouseover="document.getElementById('six-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=location'); ?>">by Mining Location</a></li>
                                                <li onmouseover="document.getElementById('six-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=assortments'); ?>">Assortments</a></li>
                                                <li onmouseover="document.getElementById('six-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=bestsellers'); ?>">Best Sellers</a></li>
                                                <li onmouseover="document.getElementById('six-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=specials'); ?>">On Sale</a></li>
                                                <li onmouseover="document.getElementById('six-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=clearance'); ?>">Clearance</a></li>
                                                <li onmouseover="document.getElementById('six-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=T&amp;show=all'); ?>">All</a></li>
                                            </ul>

                                </li>
               <li class="left_menu_li">
               <a href="<?=tep_href_link('products.php','category=V&amp;show=all');?>">Other / Accessories</a>
		    <span class="left_menu_toggle7 left_toggle_icon" ></span>
            <ul  class="left_toggle_list7 left_nav_listU">
                                                <li onmouseover="document.getElementById('seven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=V&amp;show=shape'); ?>">by Shape</a></li>
                                                <li onmouseover="document.getElementById('seven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=V&amp;show=assortments'); ?>">Assortments</a></li>
                                                <li onmouseover="document.getElementById('seven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=V&amp;show=bestsellers'); ?>">Best Sellers</a></li>
                                                <li onmouseover="document.getElementById('seven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=V&amp;show=specials'); ?>">On Sale</a></li>
                                                <li onmouseover="document.getElementById('seven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=V&amp;show=clearance'); ?>">Clearance</a></li>
                                                <li onmouseover="document.getElementById('seven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=V&amp;show=all'); ?>">All</a></li>
                                            </ul>

                                </li>
				<!--BOF:mod 20110920 #400 -->
                                <li class="left_menu_li left_menu_bb">
                                <a href="<?= tep_href_link('products_by_model.php'); ?>">Listing of All Crystals</a>
                                 <span class="left_menu_toggle8 left_toggle_icon" ></span>
                                <ul class="left_toggle_list8 left_nav_listU">
                                                <li onmouseover="document.getElementById('eleven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('taglist.php', 'show=product_property&amp;p_id=shape'); ?>">By Shape</a></li>
                                                <li onmouseover="document.getElementById('eleven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('taglist.php', 'show=stone'); ?>">By Stone Type</a></li>
                                                <li onmouseover="document.getElementById('eleven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('taglist.php', 'show=product_property&amp;p_id=location'); ?>">By Mining Location</a></li>
                                                <li onmouseover="document.getElementById('eleven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'category=&amp;show=assortments'); ?>">Assortments</a></li>
                                                <li onmouseover="document.getElementById('eleven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('best-selling-crystals.php'); ?>">Best Sellers</a></li>
                                                <li onmouseover="document.getElementById('eleven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('sale_specials.php'); ?>">On Sale</a></li>
                                                <li onmouseover="document.getElementById('eleven-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('clearance-crystals.php'); ?>">Clearance</a></li>
                                            </ul>

                                </li>
				<!--EOF:mod 20110920 #400 -->
								<li  class="left_menu_li left_menu_pt">
                                <a href="<?= tep_href_link('taglist.php'); ?>">All Tags</a>
                                <span class="left_menu_toggle9 left_toggle_icon" ></span>
                                <ul class="left_toggle_list9 left_nav_listU">
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=5"); ?>">Astrological Sign</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=2"); ?>">Chakra (Primary)</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=12"); ?>">Chakra (Secondary)</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=4"); ?>">Chemical Composition</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=product_property&amp;p_id=Color"); ?>">Color</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=3"); ?>">Crystal System</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=7"); ?>">Hardness</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=14"); ?>">Issues & Ailments</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=product_property&amp;p_id=Location"); ?>">Location</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=13"); ?>">Mineral Class</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=6"); ?>">Numerical Vibration</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=product_property&amp;p_id=Quality"); ?>">Quality</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone_property&amp;p_id=10"); ?>">Rarity</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=product_property&amp;p_id=Shape"); ?>">Shape / Formation</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("products.php", "show=size"); ?>">Size</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("taglist.php", "show=stone"); ?>">Stone Name</a></li>
												<li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("tags.php", "tag_name=wholesale"); ?>">Wholesale</a></li>
                                                <li onmouseover="document.getElementById('twentythree-ddheader').style.background='#81A5FF'"><a href="<?php echo tep_href_link("products_by_model.php"); ?>">Product Categories</a></li>
                                            </ul>

                                </li>
                                <li class="left_menu_li">
                                <a href="<?= tep_href_link('taglist.php', 'show=stone_property&amp;p_id=14'); ?>">By Issue or Ailment</a>

                                </li>
								<li class="left_menu_li">
                                <a href="<?= tep_href_link('products.php', 'show=stone'); ?>">By Stone Name</a>

                                </li>
								<li class="left_menu_li">
                                <a href="<?=tep_href_link('allprods.shtml');?>">Complete Catalog</a>
                                 <span class="left_menu_toggle10 left_toggle_icon" ></span>
                                <ul class="left_toggle_list10 left_nav_listU">
                                                <li onmouseover="document.getElementById('ten-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('all_pictures.shtml'); ?>">Catalog (w/Pictures)</a></li>
                                                <li onmouseover="document.getElementById('ten-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('allprods.shtml'); ?>">Catalog (text-only)</a></li>
                                                <li onmouseover="document.getElementById('ten-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('printable-product-catalog.html'); ?>">Printable Catalog</a></li>
                                                <?php /*?><li onmouseover="document.getElementById('ten-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link("taglist.php", "show=product_property&amp;p_id=" . 'Shape'); ?>">by Shape</a></li>
                                                <li onmouseover="document.getElementById('ten-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('products.php', 'show=stone'); ?>">by Stone Type</a></li><?php */?>
                                            </ul>

                                </li>
                            </ul>
                        </div>
                    </div>

                </td>
</tr>

            <?php
			//echo '<tr><td valign="bottom">'.basename($_SERVER['SCRIPT_NAME']).'</td></tr>';
		/*	if((basename($_SERVER['SCRIPT_NAME'])=='products.php' && $HTTP_GET_VARS['show'] != 'wholesale') || (stripos(basename($_SERVER['SCRIPT_NAME']),'articles')!==false && ($HTTP_GET_VARS['tPath'] == '3' || $HTTP_GET_VARS['tPath'] == '13') && !isset($HTTP_GET_VARS['search'])) || (basename($_SERVER['SCRIPT_NAME'])=='mpd_filter.php' || stripos(basename($_SERVER['SCRIPT_NAME']),'products_by_model')!==false) || stripos(basename($_SERVER['SCRIPT_NAME']),'best-selling')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'specials')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'clearance-crystals')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'back_in_stock')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'new_options')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'random_products')!==false || (basename($_SERVER['SCRIPT_NAME'])=='products.php' && $HTTP_GET_VARS['show'] == 'wholesale') || stripos(basename($_SERVER['SCRIPT_NAME']),'allprods')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'all_pictures_new')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'all_pictures')!==false){
					$agrs_list = '';
					if(stripos(basename($_SERVER['SCRIPT_NAME']),'best-selling')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'specials')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'clearance-crystals')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'back_in_stock')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'new_options')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'random_products')!==false || (basename($_SERVER['SCRIPT_NAME'])=='products.php' && $HTTP_GET_VARS['show'] == 'wholesale')){
						$args_list = '&amp;seltab=catalog';
					}
					if(stripos(basename($_SERVER['SCRIPT_NAME']),'articles')!==false || (basename($_SERVER['SCRIPT_NAME'])=='mpd_filter.php')){
						$sc_name = 'mpd_filter.php';
						$asc_name = 'articles.php';
					}else{
						$sc_name = 'products.php';
						$asc_name = 'products.php';
					}
			?>
            <tr>
                <td valign="bottom">
                    <?php
			switch(basename($_SERVER['SCRIPT_NAME'])){
				case 'sale_specials.php':
			    case 'clearance-crystals.php':
			    case 'best-selling-crystals.php':
			    case 'new_options.php':
			    case 'random_products.php':
			    case 'back_in_stock.php':
					echo '<script type="text/javascript">document.getElementById(\'one-ddheader\').style.background=\'#81A5FF\';</script>';
				break;
				case 'products.php':
					switch($HTTP_GET_VARS['show']){
						case 'assortments':
							echo '<script type="text/javascript">document.getElementById(\'eight-ddheader\').style.background=\'#81A5FF\';</script>';
						break;
						case 'stone':
							if($HTTP_GET_VARS['stone']=='203')echo '<script type="text/javascript">document.getElementById(\'two-ddheader\').style.background=\'#81A5FF\';</script>';

							else echo '<script type="text/javascript">document.getElementById(\'twentytwo-ddheader\').style.background=\'#81A5FF\';</script>';
						break;
						case 'all':
						default:
							switch($HTTP_GET_VARS['category']){
								case 'N':
									if($HTTP_GET_VARS['quartz']=='1'){
										echo '<script type="text/javascript">document.getElementById(\'two-ddheader\').style.background=\'#81A5FF\';</script>';
									}else{
										echo '<script type="text/javascript">document.getElementById(\'five-ddheader\').style.background=\'#81A5FF\';</script>';
									}
								break;
								case 'C':
									echo '<script type="text/javascript">document.getElementById(\'four-ddheader\').style.background=\'#81A5FF\';</script>';
								break;
								case 'J':
									echo '<script type="text/javascript">document.getElementById(\'three-ddheader\').style.background=\'#81A5FF\';</script>';
								break;
								case 'T':
									echo '<script type="text/javascript">document.getElementById(\'six-ddheader\').style.background=\'#81A5FF\';</script>';
								break;
								case 'V':
									echo '<script type="text/javascript">document.getElementById(\'seven-ddheader\').style.background=\'#81A5FF\';</script>';
								break;
							}
						break;
					}
				break;
				case 'taglist.php':
					if($HTTP_GET_VARS['show']=='stone' && $HTTP_GET_VARS['p_id']=='14')echo '<script type="text/javascript">document.getElementById(\'twentyone-ddheader\').style.background=\'#81A5FF\';</script>';
					else echo '<script type="text/javascript">document.getElementById(\'twentythree-ddheader\').style.background=\'#81A5FF\';</script>';
				break;
				case 'allprodsprice.php':
				case 'allprodsmodel.php':
				case 'allprods.php':
				case 'all_pictures.php':
					echo '<script type="text/javascript">document.getElementById(\'ten-ddheader\').style.background=\'#81A5FF\';</script>';
				break;
			}
			?>
                    <div class="glossymenuHeader"><a class="menuitem submenuleftheader" href="javascript:void(0);">Filter / Options</a>
                            <div class="submenuleft">
                                <table class="submenuRight" cellpadding="0" cellspacing="0">
                                    <tr class="leftmenueven"><td colspan="2" class="main" style="font-weight:bold;" >Sort By</td></tr>
                              <?php
$removeGetArray = array('show','shape','stone','color','location','alternate-stone','quality','pchakra','schakra','crystal','astro','vibration','hardness','rarity','mineral','ailment','composition','tPath');
?>
                                    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'astro')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="astro" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=astro' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'astro')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=astro' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'astro')echo 'style="font-weight:bold;"'; ?>>Astrological Sign</a></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'pchakra')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="pchakra" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=pchakra' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'pchakra')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=pchakra' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'pchakra')echo 'style="font-weight:bold;"'; ?>>Chakra (Primary)</a></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'schakra')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="schakra" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=schakra' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'schakra')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=schakra' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'schakra')echo 'style="font-weight:bold;"'; ?>>Chakra (Secondary)</a></td></tr>
                                    <tr>
                                        <td colspan="2" class="filter_submenu" style="padding:0px;">
                                            <table class="submenuRight" cellpadding="0" cellspacing="0" style="border:none;width:186px;">
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'composition')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="composition" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=composition' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'composition')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=composition' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'composition')echo 'style="font-weight:bold;"'; ?>>Chemical Composition</a></td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'color')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="color" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=color' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'color')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=color' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'color')echo 'style="font-weight:bold;"'; ?> >Color</a></td></tr>
                                    <tr>
                                        <td colspan="2" class="filter_submenu" style="padding:0px;">
                                            <table class="submenuRight" cellpadding="0" cellspacing="0" style="border:none;width:186px;">
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'crystal')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="crystal" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=crystal' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'crystal')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=crystal' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'crystal')echo 'style="font-weight:bold;"'; ?>>Crystal System</a></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'hardness')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="hardness" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=hardness' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'hardness')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=hardness' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'hardness')echo 'style="font-weight:bold;"'; ?>>Hardness</a></td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'ailment')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="color" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=ailment' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'ailment')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=ailment' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'ailment')echo 'style="font-weight:bold;"'; ?>>Issue or Ailment</a></td></tr>
                                    <tr>
                                        <td colspan="2" class="filter_submenu" style="padding:0px;">
                                            <table class="submenuRight" cellpadding="0" cellspacing="0" style="border:none;width:186px;">
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'location')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="location" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=location' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'location')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=location' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'location')echo 'style="font-weight:bold;"'; ?>>Location</a></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'mineral')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="mineral" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=mineral' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'mineral')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=mineral' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'mineral')echo 'style="font-weight:bold;"'; ?>>Mineral Class</a></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'vibration')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="vibration" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=vibration' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'vibration')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=vibration' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'vibration')echo 'style="font-weight:bold;"'; ?>>Numerical Vibration</a></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'quality')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" id="qualityfilter" value="quality" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=quality' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'quality')echo 'checked'; ?> <?php if($sc_name == 'mpd_filter.php') echo ' disabled="disabled"'; ?>/>&nbsp;<label for="qualityfilter">Quality</label></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'rarity')echo 'style="font-weight:bold;"';else echo ''; ?>><input type="radio" name="filter" value="rarity" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=rarity' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'rarity')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=rarity' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'rarity')echo 'style="font-weight:bold;"'; ?>>Rarity</a></td></tr>
                                            </table>
                                        </td>
                                    </tr>
				    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'shape')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="shape" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=shape' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'shape')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=shape' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'shape')echo 'style="font-weight:bold;"'; ?>>Shape / Formation</a></td></tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main"><input type="radio" name="filter" value="stone" onclick="if(this.checked)location.href='<?= tep_href_link($asc_name, tep_get_all_get_params($removeGetArray).'show=stone&tPath=3' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'stone' || $HTTP_GET_VARS['tPath'] == '3' || $HTTP_GET_VARS['tPath'] == '13')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($asc_name, tep_get_all_get_params($removeGetArray).'show=stone&tPath=3' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'stone' || $HTTP_GET_VARS['tPath'] == '3' || $HTTP_GET_VARS['tPath'] == '13')echo 'style="font-weight:bold;"'; ?>>Stone Name</a></td></tr>
                                    <tr><td colspan="2" class="filter_submenu" style="padding:0px;" id="accor_control"></td></tr>
                                    <tr class="leftmenuodd"><td class="left_col_filter main" style="padding:0px;" colspan="2"></td></tr>
                                    <tr class="leftmenuodd"><td class="left_col_filter main" style="padding:0px;" colspan="2"></td></tr>
                                    <tr class="leftmenuodd"><td class="left_col_filter main" style="padding:0px;" colspan="2"></td></tr>
                                    <tr class="leftmenuodd"><td class="left_col_filter main" style="" id="moreOp" colspan="2" onclick="openCloseAccor();">&nbsp;<input type="hidden" value="0" id="controller" /></td></tr>

                                    <tr class="leftmenueven"><td colspan="2" class="main" style="font-weight:bold;" >Show Only</td></tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'bestsellers')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="bestsellers" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=bestsellers' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'bestsellers')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=bestsellers' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'bestsellers')echo 'style="font-weight:bold;"'; ?>>Best Sellers</a></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'clearance')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="clearance" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=clearance' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'clearance')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=clearance' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'clearance')echo 'style="font-weight:bold;"'; ?>>Clearance</a></td></tr>
				    <tr class="leftmenueven"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'specials')echo 'style="font-weight:bold;padding-bottom:8px;border-bottom:1px solid #8C8C8C;"';else echo 'style="padding-bottom:8px;border-bottom:1px solid #8C8C8C;"'; ?>><input type="radio" name="filter" value="specials" onclick="if(this.checked)location.href='<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=specials' . $args_list) ?>'" <?php if ($HTTP_GET_VARS['show'] == 'specials')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link($sc_name, tep_get_all_get_params($removeGetArray).'show=specials' . $args_list) ?>" <?php if ($HTTP_GET_VARS['show'] == 'specials')echo 'style="font-weight:bold"'; ?>>On Sale</a></td></tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" style="font-weight:bold;" >Display Options</td></tr>
								<?php if(stripos(basename($_SERVER['SCRIPT_NAME']),'best-selling')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'specials')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'clearance-crystals')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'back_in_stock')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'new_options')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'random_products')!==false || (basename($_SERVER['SCRIPT_NAME'])=='products.php' && $HTTP_GET_VARS['show'] == 'wholesale')){
								?>
									<tr class="leftmenuodd"><td style="font-weight:bold"><input type="radio" name="products_display" value="1" checked="checked" >&nbsp;Summary&nbsp;</td><td><input type="radio" name="products_display" value="1" disabled="disabled">&nbsp;Details</td></tr>
									<?php echo $leftNavFilterString; ?>
									<?php }elseif(stripos(basename($_SERVER['SCRIPT_NAME']),'allprods')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'all_pictures_new')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'all_pictures')!==false){ ?>
									<?php echo $leftNavFilterString; ?>
									<?php }elseif(stripos(basename($_SERVER['SCRIPT_NAME']),'products')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'products_by_model')!==false){ ?>
                                    <tr class="leftmenuodd"><td colspan="2"><input type="radio" name="products_display" value="1" <?php if ($HTTP_GET_VARS['products_display'] != 'details') echo 'CHECKED'; ?> onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display'))); ?>'">&nbsp;<a href="<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display'))); ?>" <?php if ($HTTP_GET_VARS['products_display'] != 'details')echo 'style="font-weight:bold"'; ?>>Summary</a>&nbsp;<input type="radio" name="products_display" value="1" <?php if ($HTTP_GET_VARS['products_display'] == 'details') echo 'CHECKED'; ?> <?php if (stripos(basename($_SERVER['SCRIPT_NAME']),'products_by_model')!==false) echo 'disabled=""'; ?> onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display')).'products_display=details') ?>'">&nbsp;<a href="<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display')).'products_display=details') ?>" <?php if ($HTTP_GET_VARS['products_display'] == 'details')echo 'style="font-weight:bold"'; ?>>Details</a></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2"><input type="radio" name="hide_images" value="<?php echo $value; ?>" <?php if ($value == 'yes') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}" >&nbsp;<a href="javascript:void(0);" onclick="document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();" <?php if ($value != 'no')echo 'style="font-weight:bold"'; ?>>Images</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="hide_images" value="<?php echo $value; ?>" <?php if ($value == 'no') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}">&nbsp;<a href="javascript:void(0);" onclick="document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();" <?php if ($value == 'no')echo 'style="font-weight:bold"'; ?>>Text Only</a></td></tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" <?php if($print_view=='on')echo 'style="font-weight:bold;"'; ?>><input type="checkbox" name="print_link"  id="print_link" value="1" onclick="showPrintPage();" <?php if($print_view=='on')echo 'CHECKED'; ?>/>&nbsp;<label for="print_link">Print View</label></td></tr>
                                   <?php }elseif(stripos(basename($_SERVER['SCRIPT_NAME']),'articles')!==false ){ ?>
                                    <tr class="leftmenuodd"><td><input type="radio" <?=$HTTP_GET_VARS['tPath']=="3"?'checked':''?> name="display_typeSD" value="summary" onclick="if(this.checked)location.href='<?= tep_href_link( "Metaphysical_Directory_Crystal_Guide_Topics_3.html"); ?>'"/>&nbsp;<a href="<?= tep_href_link( "Metaphysical_Directory_Crystal_Guide_Topics_3.html"); ?>" <?=$HTTP_GET_VARS['tPath']=="3"?'style="font-weight:bold"':''?>>Summary</a></td><td><input type="radio" <?=$HTTP_GET_VARS['tPath']=="13"?'checked':''?> name="display_typeSD" value="detailed" onclick="if(this.checked)location.href='<?=tep_href_link( "Metaphysical_Directory__Detailed_Topics_13.html"); ?>'"/>&nbsp;<a href="<?=tep_href_link( "Metaphysical_Directory__Detailed_Topics_13.html"); ?>" <?=$HTTP_GET_VARS['tPath']=="13"?'style="font-weight:bold"':''?>>Details</a></td></tr>
                                    <tr class="leftmenueven" ><td <?=$value=="yes"?'style="font-weight:bold"':''?>><input <?php //if($HTTP_GET_VARS['tPath']=="13")echo 'disabled="disabled"'; ?> id="display_images" type="radio" <?=$value=="yes"?'checked':''?> name="hide_images" value="summary" onclick="if(this.checked)showTextPage();"/>&nbsp;<label for="display_images">Images</label></td><td <?=$value=="no"?'style="font-weight:bold"':''?>><input id="hide_images" type="radio" <?=$value=="no"?'checked':''?> name="hide_images" value="summary" onclick="if(this.checked)showTextPage();"/>&nbsp;<label for="hide_images">Text Only</label></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2"><input type="checkbox" name="print_link"  id="print_link" value="1" onclick="showPrintPage();" <?php if ($print_view == 'on')echo 'CHECKED'; ?>/>&nbsp;<font <?=$print_view == 'on'?'style="font-weight:bold"':''?>><label for="print_link">Print View</label></font></td></tr>
                                   <?php  }elseif(stripos(basename($_SERVER['SCRIPT_NAME']),'mpd_filter')!==false){ ?>
                                    <tr class="leftmenuodd"><td colspan="2"><input type="radio" name="hide_images" value="<?php echo $value; ?>" <?php if ($value == 'yes') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}" >&nbsp;<a href="javascript:void(0);" onclick="document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();" <?php if ($value != 'no')echo 'style="font-weight:bold"'; ?>>Images</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="hide_images" value="<?php echo $value; ?>" <?php if ($value == 'no') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}">&nbsp;<a href="javascript:void(0);" onclick="document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();" <?php if ($value == 'no')echo 'style="font-weight:bold"'; ?>>Text Only</a></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2"><input type="checkbox" name="print_link"  id="print_link" value="1" onclick="showPrintPage();" <?php if ($print_view == 'on')echo 'CHECKED'; ?>/>&nbsp;<font <?=$print_view == 'on'?'style="font-weight:bold"':''?>><label for="print_link">Print View</label></font></td></tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                </td>
            </tr>
            <?php }elseif(stripos(basename($_SERVER['SCRIPT_NAME']),'taglist')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'tags')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'products_by_chemical_composition')!==false){

				$stone_property_name_array = array('2' => 'Chakra<br/>(Primary)', '12' => 'Chakra<br/>(Secondary)', '3' => 'Crystal<br />System', '4' => 'Chemical<br />Composition', '5' => 'Astrological<br />Sign', '6' => 'Numerical<br />Vibration', '7' => 'Hardness', '10' => 'Rarity', '13' => 'Mineral<br />Class', '14' => 'Issues &<br />Ailments');
       		 	$product_property_name_array = array('Location' => 'Location', 'Quality' => 'Quality', 'Color' => 'Color', 'Shape' => 'Shape');
            ?>
            <tr>
                <td valign="bottom">
                     <div class="glossymenuHeader" style="width: 190px;"><a class="menuitem submenuleftheader" href="javascript:void(0);">Filter / Options</a>
                         <div class="submenuleft">
                         	<table class="submenuRight" cellpadding="0" cellspacing="0">
						 		<tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '5' || $HTTP_GET_VARS['tab'] == '5')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="astro" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=5"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '5' || $HTTP_GET_VARS['tab'] == '5')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=5"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '5' || $HTTP_GET_VARS['tab'] == '5')echo 'style="font-weight:bold;"'; ?>>Astrological Sign</a></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '2' || $HTTP_GET_VARS['tab'] == '2')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="pchakra" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=2"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '2' || $HTTP_GET_VARS['tab'] == '2')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=2"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '2' || $HTTP_GET_VARS['tab'] == '2')echo 'style="font-weight:bold;"'; ?>>Chakra (Primary)</a></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '12' || $HTTP_GET_VARS['tab'] == '12')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="schakra" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=12"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '12' || $HTTP_GET_VARS['tab'] == '12')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=12"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '12' || $HTTP_GET_VARS['tab'] == '12')echo 'style="font-weight:bold;"'; ?>>Chakra (Secondary)</a></td></tr>
                                    <tr>
                                        <td colspan="2" class="filter_submenu" style="padding:0px;">
                                            <table class="submenuRight" cellpadding="0" cellspacing="0" style="border:none;width:186px;">
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '4' || $HTTP_GET_VARS['tab'] == '4' || stripos(basename($_SERVER['SCRIPT_NAME']),'products_by_chemical_composition')!==false)echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="composition" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=4"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '4' || $HTTP_GET_VARS['tab'] == '4' || stripos(basename($_SERVER['SCRIPT_NAME']),'products_by_chemical_composition')!==false )echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=4"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '4' || $HTTP_GET_VARS['tab'] == '4' || stripos(basename($_SERVER['SCRIPT_NAME']),'products_by_chemical_composition')!==false)echo 'style="font-weight:bold;"'; ?>>Chemical Composition</a></td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == 'Color'|| $HTTP_GET_VARS['tab'] == 'Color')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="color" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=product_property&amp;p_id=Color"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == 'Color'|| $HTTP_GET_VARS['tab'] == 'Color')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=product_property&amp;p_id=Color"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == 'Color'|| $HTTP_GET_VARS['tab'] == 'Color')echo 'style="font-weight:bold;"'; ?> >Color</a></td></tr>
                                    <tr>
                                        <td colspan="2" class="filter_submenu" style="padding:0px;">
                                            <table class="submenuRight" cellpadding="0" cellspacing="0" style="border:none;width:186px;">
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '3' || $HTTP_GET_VARS['tab'] == '3')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="crystal" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=3"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '3' || $HTTP_GET_VARS['tab'] == '3')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=3"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '3' || $HTTP_GET_VARS['tab'] == '3')echo 'style="font-weight:bold;"'; ?>>Crystal System</a></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '7' || $HTTP_GET_VARS['tab'] == '7')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="hardness" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=7"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '7' || $HTTP_GET_VARS['tab'] == '7')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=7"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '7' || $HTTP_GET_VARS['tab'] == '7')echo 'style="font-weight:bold;"'; ?>>Hardness</a></td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '14' || $HTTP_GET_VARS['tab'] == '14')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="color" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=14"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '14' || $HTTP_GET_VARS['tab'] == '14')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=14"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '14' || $HTTP_GET_VARS['tab'] == '14')echo 'style="font-weight:bold;"'; ?>>Issue or Ailment</a></td></tr>
                                    <tr>
                                        <td colspan="2" class="filter_submenu" style="padding:0px;">
                                            <table class="submenuRight" cellpadding="0" cellspacing="0" style="border:none;width:186px;">
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == 'Location'|| $HTTP_GET_VARS['tab'] == 'Location')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="location" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=product_property&amp;p_id=" . 'Location'); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == 'Location'|| $HTTP_GET_VARS['tab'] == 'Location')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=product_property&amp;p_id=" . 'Location'); ?>" <?php if ($HTTP_GET_VARS['p_id'] == 'Location'|| $HTTP_GET_VARS['tab'] == 'Location')echo 'style="font-weight:bold;"'; ?>>Location</a></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '13' || $HTTP_GET_VARS['tab'] == '13')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="mineral" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=13"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '13' || $HTTP_GET_VARS['tab'] == '13')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=13"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '13' || $HTTP_GET_VARS['tab'] == '13')echo 'style="font-weight:bold;"'; ?>>Mineral Class</a></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '6' || $HTTP_GET_VARS['tab'] == '6')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="vibration" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=6"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '6' || $HTTP_GET_VARS['tab'] == '6')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=6"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '6' || $HTTP_GET_VARS['tab'] == '6')echo 'style="font-weight:bold;"'; ?>>Numerical Vibration</a></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == 'Quality'|| $HTTP_GET_VARS['tab'] == 'Quality')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" id="qualityfilter" value="quality" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=product_property&amp;p_id=" . 'Quality'); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == 'Quality'|| $HTTP_GET_VARS['tab'] == 'Quality')echo 'checked'; ?> />&nbsp;<label for="qualityfilter">Quality</label></td></tr>
                                                <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == '10' || $HTTP_GET_VARS['tab'] == '10')echo 'style="font-weight:bold;"';else echo ''; ?>><input type="radio" name="filter" value="rarity" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=10"); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == '10' || $HTTP_GET_VARS['tab'] == '10')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone_property&amp;p_id=10"); ?>" <?php if ($HTTP_GET_VARS['p_id'] == '10' || $HTTP_GET_VARS['tab'] == '10')echo 'style="font-weight:bold;"'; ?>>Rarity</a></td></tr>
                                            </table>
                                        </td>
                                    </tr>
				    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['p_id'] == 'Shape'|| $HTTP_GET_VARS['tab'] == 'Shape')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="shape" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=product_property&amp;p_id=" . 'Shape'); ?>'" <?php if ($HTTP_GET_VARS['p_id'] == 'Shape'|| $HTTP_GET_VARS['tab'] == 'Shape')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=product_property&amp;p_id=" . 'Shape'); ?>" <?php if ($HTTP_GET_VARS['p_id'] == 'Shape'|| $HTTP_GET_VARS['tab'] == 'Shape')echo 'style="font-weight:bold;"'; ?>>Shape / Formation</a></td></tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main"><input type="radio" name="filter" value="stone" onclick="if(this.checked)location.href='<?= tep_href_link("taglist.php", "show=stone"); ?>'" <?php if ($HTTP_GET_VARS['show'] == 'stone')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link("taglist.php", "show=stone"); ?>" <?php if ($HTTP_GET_VARS['show'] == 'stone')echo 'style="font-weight:bold;"'; ?>>Stone Name</a></td></tr>
                                    <tr><td colspan="2" class="filter_submenu" style="padding:0px;" id="accor_control"></td></tr>
                                    <tr class="leftmenuodd"><td class="left_col_filter main" style="padding:0px;" colspan="2"></td></tr>
                                    <tr class="leftmenuodd"><td class="left_col_filter main" style="padding:0px;" colspan="2"></td></tr>
                                    <tr class="leftmenuodd"><td class="left_col_filter main" style="padding:0px;" colspan="2"></td></tr>
                                    <tr class="leftmenuodd"><td class="left_col_filter main" style="" id="moreOp" colspan="2" onclick="openCloseAccor();">&nbsp;<input type="hidden" value="0" id="controller" /></td></tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" style="font-weight:bold;" >Show Only</td></tr>
                                    <tr class="leftmenueven"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'bestsellers')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="bestsellers" onclick="if(this.checked)location.href='<?= tep_href_link('products.php', 'show=bestsellers') ?>'" <?php if ($HTTP_GET_VARS['show'] == 'bestsellers')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link('products.php', 'show=bestsellers') ?>" <?php if ($HTTP_GET_VARS['show'] == 'bestsellers')echo 'style="font-weight:bold;"'; ?>>Best Sellers</a></td></tr>
                                    <tr class="leftmenuodd"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'clearance')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="filter" value="clearance" onclick="if(this.checked)location.href='<?= tep_href_link('products.php', 'show=clearance') ?>'" <?php if ($HTTP_GET_VARS['show'] == 'clearance')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link('products.php', 'show=clearance') ?>" <?php if ($HTTP_GET_VARS['show'] == 'clearance')echo 'style="font-weight:bold;"'; ?>>Clearance</a></td></tr>
				    				<tr class="leftmenueven"><td colspan="2" class="main" <?php if ($HTTP_GET_VARS['show'] == 'specials')echo 'style="font-weight:bold;padding-bottom:8px;border-bottom:1px solid #8C8C8C;"';else echo 'style="padding-bottom:8px;border-bottom:1px solid #8C8C8C;"'; ?>><input type="radio" name="filter" value="specials" onclick="if(this.checked)location.href='<?= tep_href_link('products.php', 'show=specials') ?>'" <?php if ($HTTP_GET_VARS['show'] == 'specials')echo 'checked'; ?>/>&nbsp;<a href="<?= tep_href_link('products.php', 'show=specials') ?>" <?php if ($HTTP_GET_VARS['show'] == 'specials')echo 'style="font-weight:bold"'; ?>>On Sale</a></td></tr>
									<tr class="leftmenueven"><td colspan="2" class="main" style="font-weight:bold;" >Display Options</td></tr>
						<?php
						if(stripos(basename($_SERVER['SCRIPT_NAME']),'taglist')!==false ){ ?>
                                <tr class="leftmenueven">
									<td><input id="display_typeS" type="radio" <?=$HTTP_GET_VARS['display_type']=="summary"||!isset($HTTP_GET_VARS['display_type'])?'checked':''?> name="display_type" value="summary" onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('display_type')).'display_type=summary') ?>'"/>&nbsp;<a href="<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('display_type')).'display_type=summary') ?>" <?=$HTTP_GET_VARS['display_type']=="summary"||!isset($HTTP_GET_VARS['display_type'])?'style="font-weight:bold;"':''?>>Summary</a></td><td><input id="display_typeD" type="radio" <?=$HTTP_GET_VARS['display_type']=="detailed"?'checked':''?> name="display_type" value="detailed" onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('display_type')).'display_type=detailed') ?>'"/>&nbsp;<a href="<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('display_type')).'display_type=detailed') ?>" <?=$HTTP_GET_VARS['display_type']=="detailed"?'style="font-weight:bold;"' : ''?>>Details</a></td>
								</tr>
                                <tr class="leftmenuodd">
									<td <?php if ($value == 'yes')echo 'style="font-weight:bold;"';?>><input type="radio" id="display_images" name="hide_images" value="<?php echo $value; ?>" <?php if ($value == 'yes') echo 'CHECKED'; ?> <?php if($HTTP_GET_VARS['show']=='stone' || stripos(basename($_SERVER['SCRIPT_NAME']),'stones_with_property')!==false) { ?>onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}" <? }else echo 'disabled="disabled"'; ?>>&nbsp;<label for="display_images">Images</label></td><td <?php if ($value == 'no')echo 'style="font-weight:bold; background-color:#BCD2F8;"'; ?>><input id="hide_images" type="radio" name="hide_images" value="<?php echo $value; ?>" <?php if ($value == 'no') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}">&nbsp;<label for="hide_images">Text Only</label></td>
								</tr>
								 <tr class="leftmenueven"><td <?php if ($print_view == 'on')echo 'style="font-weight:bold;"'; ?> colspan="2"><input type="checkbox" name="print_link"  id="print_link" value="1" onclick="showPrintPage();" <?php if ($print_view == 'on')echo 'CHECKED'; ?>/>&nbsp;<label for="print_link">Print View</label></td></tr>
						<?php }elseif(stripos(basename($_SERVER['SCRIPT_NAME']),'tags')!==false || stripos(basename($_SERVER['SCRIPT_NAME']),'products_by_chemical_composition')!==false){
							//if(stripos(basename($_SERVER['SCRIPT_NAME']),'tags')!==false ){ ?>
								<tr class="leftmenuodd"><td><input type="radio" name="products_display" value="1" <?php if ($HTTP_GET_VARS['products_display'] != 'details') echo 'CHECKED'; ?> onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display'))) ?>'">&nbsp;<a href="<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display'))) ?>" <?php if ($HTTP_GET_VARS['products_display'] != 'details')echo 'style="font-weight:bold;"'; ?>>Summary</a></td><td><input type="radio" name="products_display" value="1" <?php if ($HTTP_GET_VARS['products_display'] == 'details') echo 'CHECKED'; ?> onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display')).'products_display=details') ?>'">&nbsp;<a href="<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display')).'products_display=details') ?>" <?php if ($HTTP_GET_VARS['products_display'] == 'details')echo 'style="font-weight:bold;"'; ?>>Details</a></td></tr>
								<tr class="leftmenuodd"><td <?php if ($value == 'yes')echo 'style="font-weight:bold;"'; ?>><input type="radio" id="display_images" name="hide_images" value="<?php echo 'yes' ?>" <?php if ($value == 'yes') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}">&nbsp;<label for="display_images">Images</label></td><td <?php if ($value == 'no')echo 'style="font-weight:bold;"'; ?>><input type="radio" id="hide_images" name="hide_images" value="<?php echo 'no' ?>" <?php if ($value == 'no') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}">&nbsp;<label for="hide_images">Text Only</label></td></tr>

                                <tr class="leftmenueven"><td <?php if ($print_view == 'on')echo 'style="font-weight:bold"'; ?> colspan="2"><input type="checkbox" name="print_link"  id="print_link" value="1" onclick="showPrintPage();" <?php if ($print_view == 'on')echo 'CHECKED'; ?>/>&nbsp;<label for="print_link">Print View</label></td></tr>
							<?php } ?>
                         </table>
                         </div>
                     </div>
                </td>
            </tr>
            <?php
            }else if(stripos(basename($_SERVER['SCRIPT_NAME']),'search_result')!==false ){?>
            <tr>
                <td valign="bottom">
                    <div class="glossymenuHeader" style="width: 190px;"><a class="menuitem submenuleftheader" href="javascript:void(0);">Filter / Options</a>
                        <div class="submenuleft">
                            <table class="submenuRight" cellpadding="0" cellspacing="0">
								<tr class="leftmenueven"><td colspan="2" class="main" style="font-weight:bold;" >Narrow by Category</td></tr>
								<tr class="leftmenuodd"><td colspan="2" <?=$HTTP_GET_VARS['broadCat']=="A"?'style="font-weight:bold;"':''?>><input id="broadCatA" type="radio" <?=$HTTP_GET_VARS['broadCat']=="A"?'checked':''?> name="filterC" value="A" onclick="if(this.checked)location.href='<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=A') ?>'"/>&nbsp;<a href="<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=A') ?>" <?=$HTTP_GET_VARS['broadCat']=="A"?'style="font-weight:bold;"':''?>>Assortments</a></td></tr>
                                <tr class="leftmenueven"><td colspan="2" <?=$HTTP_GET_VARS['broadCat']=="J"?'style="font-weight:bold;"':''?>><input id="broadCatJ" type="radio" <?=$HTTP_GET_VARS['broadCat']=="J"?'checked':''?> name="filterC" value="J" onclick="if(this.checked)location.href='<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=J') ?>'"/>&nbsp;<a href="<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=J') ?>" <?=$HTTP_GET_VARS['broadCat']=="J"?'style="font-weight:bold;"':''?>>Crystal Jewelry</a></td></tr>
                                <tr class="leftmenuodd"><td colspan="2" <?=$HTTP_GET_VARS['broadCat']=="C"?'style="font-weight:bold;"':''?>><input id="broadCatC" type="radio" <?=$HTTP_GET_VARS['broadCat']=="C"?'checked':''?> name="filterC" value="C" onclick="if(this.checked)location.href='<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=C') ?>'"/>&nbsp;<a href="<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=C') ?>" <?=$HTTP_GET_VARS['broadCat']=="C"?'style="font-weight:bold;"':''?>>Cut & Polished Crystals</a></td></tr>
                                <tr class="leftmenueven"><td colspan="2" <?=$HTTP_GET_VARS['broadCat']=="N"?'style="font-weight:bold;"':''?>><input id="broadCatN" type="radio" <?=$HTTP_GET_VARS['broadCat']=="N"?'checked':''?> name="filterC" value="N" onclick="if(this.checked)location.href='<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=N') ?>'"/>&nbsp;<a href="<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=N') ?>" <?=$HTTP_GET_VARS['broadCat']=="N"?'style="font-weight:bold;"':''?>>Natural Crystals</a></td></tr>
                                <tr class="leftmenuodd"><td colspan="2" <?=$HTTP_GET_VARS['broadCat']=="T"?'style="font-weight:bold;"':''?>><input id="broadCatT" type="radio" <?=$HTTP_GET_VARS['broadCat']=="T"?'checked':''?> name="filterC" value="T" onclick="if(this.checked)location.href='<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=T') ?>'"/>&nbsp;<a href="<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=T') ?>" <?=$HTTP_GET_VARS['broadCat']=="T"?'style="font-weight:bold;"':''?>>Tumbled Stones</td></tr>
                                <tr class="leftmenueven"><td colspan="2" <?=$HTTP_GET_VARS['broadCat']=="V"?'style="font-weight:bold;"':''?>><input id="broadCatV" type="radio" <?=$HTTP_GET_VARS['broadCat']=="V"?'checked':''?> name="filterC" value="V" onclick="if(this.checked)location.href='<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=V') ?>'"/>&nbsp;<a href="<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat')).'broadCat=V') ?>" <?=$HTTP_GET_VARS['broadCat']=="V"?'style="font-weight:bold;"':''?>>Other / Accessories</a></td></tr>
                                <tr class="leftmenuodd"><td colspan="2" <?php if(!isset($HTTP_GET_VARS['broadCat']))echo'style="font-weight:bold;padding-bottom:8px;border-bottom:1px solid #8C8C8C;"'; else echo 'style="padding-bottom:8px;border-bottom:1px solid #8C8C8C;"'?>><input type="radio" <?php if(!isset($HTTP_GET_VARS['broadCat']))echo'checked'?> name="filterC" value="" onclick="if(this.checked)location.href='<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat'))) ?>'"/>&nbsp;<a href="<?= tep_href_link('advanced_search_result.php', tep_get_all_get_params(array('broadCat'))) ?>" <?php if(!isset($HTTP_GET_VARS['broadCat']))echo'style="font-weight:bold;"'?>>All</a></td></tr>
								<tr class="leftmenueven"><td colspan="2" class="main" style="font-weight:bold;" >Display Options</td></tr>
								<tr class="leftmenuodd"><td><input type="radio" name="products_display" value="1" checked="checked" id="dis_summary" onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display'))) ?>'">&nbsp;<label for="dis_summary" <?php if ($HTTP_GET_VARS['products_display'] != 'detail')echo 'style="font-weight:bold;"'; ?>>Summary</label></td><td><input type="radio" disabled="disabled" name="products_display" id="dis_details" value="1" onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display')) . 'products_display=detail') ?>'">&nbsp;<label for="dis_details">Details</label></td></tr>
								<tr class="leftmenuodd"><td <?php if ($img_value == 'yes')echo 'style="font-weight:bold;"';?>><input type="radio" id="display_images" name="hide_images" value="<?php echo $value; ?>" <?php if ($img_value == 'yes') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $img_value; ?>';document.text_only.submit();}">&nbsp;<label for="display_images">Images</label></td><td <?php if ($img_value == 'no')echo 'style="font-weight:bold; background-color:#BCD2F8;"'; ?>><input id="hide_images" type="radio" name="hide_images" value="<?php echo $img_value; ?>" <?php if ($img_value == 'no') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $img_value; ?>';document.text_only.submit();}">&nbsp;<label for="hide_images">Text Only</label></td>
								</tr>
								<tr class="leftmenueven"><td <?php if ($print_view == 'on')echo 'style="font-weight:bold;"'; ?> colspan="2"><input type="checkbox" name="print_link"  id="print_link" value="1" onclick="showPrintPage();" <?php if ($print_view == 'on')echo 'CHECKED'; ?>/>&nbsp;<label for="print_link">Print View</label></td></tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <?php }elseif((stripos(basename($_SERVER['SCRIPT_NAME']),'articles')!==false && isset($HTTP_GET_VARS['search']) && $HTTP_GET_VARS['tPath'] != '3') || stripos(basename($_SERVER['SCRIPT_NAME']),'article_info.php')!==false ){
            ?>
            <tr>
                <td valign="bottom">
                     <div class="glossymenuHeader" style="width: 190px;"><a class="menuitem submenuleftheader" href="javascript:void(0);">Filter / Options</a>
                         <div class="submenuleft">
                         	<table class="submenuRight" cellpadding="0" cellspacing="0">
								<tr class="leftmenueven"><td colspan="2" class="main" style="font-weight:bold;" >Display Options</td></tr>
							<?php if(stripos(basename($_SERVER['SCRIPT_NAME']),'article_info.php')!==false ){ ?>
								<tr class="leftmenuodd"><td><input type="radio" name="products_display" value="1" <?php if(stripos(basename($_SERVER['SCRIPT_NAME']),'article_info.php')===false) echo ' checked="checked"'; else echo ' disabled="disabled"'; ?> id="dis_summary" onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display'))) ?>'">&nbsp;<label for="dis_summary" <?php if (stripos(basename($_SERVER['SCRIPT_NAME']),'article_info.php')===false)echo 'style="font-weight:bold;"'; ?>>Summary</label></td><td><input type="radio" name="products_display" id="dis_details" value="1" <?php if(stripos(basename($_SERVER['SCRIPT_NAME']),'article_info.php')!==false ) echo ' checked="checked"'; else echo ' disabled="disabled"'; ?> onclick="if(this.checked)location.href='<?= tep_href_link(basename($_SERVER['SCRIPT_NAME']), tep_get_all_get_params(array('products_display')) . 'products_display=detail') ?>'">&nbsp;<label for="dis_details" <?php if (stripos(basename($_SERVER['SCRIPT_NAME']),'article_info.php')!==false)echo 'style="font-weight:bold;"'; ?>>Details</label></td></tr>
						 		<tr class="leftmenuodd"><td <?php if ($value == 'yes')echo 'style="font-weight:bold;"'; ?>><input type="radio" id="display_images" name="hide_images" value="<?php echo $value; ?>" <?php if ($value == 'yes') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}">&nbsp;<label for="display_images">Images</label></td><td <?php if ($value == 'no')echo 'style="font-weight:bold;"'; ?>><input type="radio" name="hide_images" id="hide_images" value="<?php echo $value; ?>" <?php if ($value == 'no') echo 'CHECKED'; ?> onclick="if(this.checked){document.text_only.hide_images.value='<?php echo $value; ?>';document.text_only.submit();}">&nbsp;<label for="hide_images">Text Only</label></td></tr>
								<?php } ?>
                                <tr class="leftmenueven"><td <?php if ($print_view == 'on')echo 'style="font-weight:bold"'; ?> colspan="2"><input type="checkbox" name="print_link"  id="print_link" value="1" onclick="showPrintPage();" <?php if ($print_view == 'on')echo 'CHECKED'; ?>/>&nbsp;<label for="print_link">Print View</label></td></tr>
                         </table>
                         </div>
                     </div>
                </td>
            </tr>
            <?php
            }*/
            ?>
		<tr>
                <td valign="bottom">
                    <div class="glossymenuHeader"><a class="menuitem submenuleftheader" href="javascript:void(0);">Metaphysical Guides</a>
                        <div class="submenuleft">
							<table class="submenuAff" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td>
                            			<a href="<?= tep_href_link('articles.php', 'tPath=3'); ?>">HC Metaphysical Guide</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="<?= tep_href_link('article_info.php', 'articles_id=1009'); ?>">Crystal Cautions</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="<?= tep_href_link('article_info.php', 'articles_id=1035'); ?>">Crystal Formations</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="<?= tep_href_link('article_info.php', 'articles_id=1020'); ?>">Issues &amp; Ailments Guide</a>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</td>
			</tr>
			<tr>
                <td valign="bottom">
                    <div class="glossymenuHeader"><a class="menuitem submenuleftheader" href="javascript:void(0);">Articles &amp; Fun</a>
                        <div class="submenuleft">

                            <ul>
                                <li  class="left_menu_li">
                      <a href="http://www.healingcrystals.com/Beginner_s_Reference_Guide_Articles_11218.html">Beginner References</a>

                                </li>
                                <li  class="left_menu_li">
                                <a href="http://www.healingcrystals.com/Current_Updates_Topics_17.html">Current Updates</a>
                                     
                                </li>
                                <li class="left_menu_li">
                                <a href="<?= tep_href_link('articles.php','show_categories=1'); ?>">Article Categories</a>
                                <span class="left_menu_toggle11 left_toggle_icon" ></span>
                                <ul  class="left_toggle_list11 left_nav_listU">
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=17'); ?>">Current Updates</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=1'); ?>">Crystal Healing Articles</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=10'); ?>">Crystal Recommendations</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=14'); ?>">Crystal Reference Library</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=sixteen'); ?>">Sacred Geometry</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=15'); ?>">Chakra Crystal Articles</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=6'); ?>">Astrology Crystals</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=2'); ?>">Newsletter Archive</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=5'); ?>">Customer Comments</a></li>
                                                <li onmouseover="document.getElementById('sixteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'tPath=9'); ?>">About Us</a></li>
												<li class="left_menu_li left_sub_menu">
                                                <a href="<?= tep_href_link('popular_articles.php'); ?>">Popular Articles</a>
                                                <span class="left_menu_toggle12 left_toggle_icon" ></span>
                                                <ul class="left_toggle_list12 left_nav_listU left_sub_list">
																<li onmouseover="document.getElementById('fourteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('article_info.php', 'articles_id=1164'); ?>">Creating a Sacred Space</a></li>
																<li onmouseover="document.getElementById('fourteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('articles.php', 'search=pets&amp;key=title'); ?>">Crystals for Pets/Animals</a></li>
																<li onmouseover="document.getElementById('fourteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('article_info.php', 'articles_id=1154'); ?>">Similar Stones</a></li>
																<li onmouseover="document.getElementById('fourteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('article_info.php', 'articles_id=11'); ?>">Clearing Crystals</a></li>
																<li onmouseover="document.getElementById('fourteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('article_info.php', 'articles_id=176'); ?>">Programming Crystals</a></li>
																<li onmouseover="document.getElementById('fourteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('article_info.php', 'articles_id=506'); ?>">Crystals for Protection</a></li>
																<li onmouseover="document.getElementById('fourteen-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('article_info.php', 'articles_id=1183'); ?>">Clearing Negative Energies</a></li>
															</ul>

												</li>
												<li class="left_menu_li left_sub_menu">
                                                <a href="<?= tep_href_link('articles_new.php'); ?>">Most Recent Articles</a>
                                                 <span class="left_menu_toggle13 left_toggle_icon" ></span>
                                                <ul class="left_toggle_list13 left_nav_listU left_sub_list">
																<?php
																$articles_new_query = tep_db_query("select distinct a.articles_id, ad.articles_name from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad, articles_to_topics a2t where (a.articles_date_available IS NULL or a.articles_date_available <= now()) and a.articles_status = '1' and a.publish_on_hc = '1' and a.articles_id = ad.articles_id and a2t.articles_id = a.articles_id and ad.language_id = '" . (int) $languages_id . "' order by a.articles_date_added desc, ad.articles_name limit 5");
																while ($articles_new_array = tep_db_fetch_array($articles_new_query)) {
																	echo '<li onmouseover="document.getElementById(\'fifteen-ddheader\').style.background=\'#81A5FF\'"><a href="' . tep_href_link('article_info.php', 'articles_id=' . $articles_new_array['articles_id']) . '">' . $articles_new_array['articles_name'] . '</a></li>';
																}
																?>
															</ul>

												</li>
                                            </ul>

                                </li>
                                <li class="left_menu_li">
                                <a href="/cards.php">Crystal Divination Cards</a>

                                </li>
								<li class="left_menu_li">
                                <a href="/quotes-welcome.html">Inspiration</a>

                                </li>
				<li class="left_menu_li">
                <a href="/contests.html">Contests & Games</a>

                                </li>
								<li class="left_menu_li">
                                <a href="/Crystal_Books_and_Resources_Articles_152.html">Book Reviews</a>

                                </li>
                                <li class="left_menu_li">
                                <a href="<?= tep_href_link('newsfeed.php'); ?>">Newsfeed</a>
                                         <span class="left_menu_toggle14 left_toggle_icon" ></span>

                                <ul class="left_toggle_list14 left_nav_listU">
                                                <li onmouseover="document.getElementById('twelve-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('newsfeed.php'); ?>">View Newsfeed</a></li>
                                                <li onmouseover="document.getElementById('twelve-ddheader').style.background='#81A5FF'"><a href="<?= tep_href_link('newsfeed.xml'); ?>">Subscribe to Newsfeed</a></li>
                                            </ul>

                                </li>

                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <div class="glossymenuHeader"><a class="menuitem submenuleftheader" href="javascript:void(0);">Community</a>
                        <div class="submenuleft"><table class="submenuAff" cellpadding="0" cellspacing="0" width="100%">
                                <tr><td><a href="http://www.facebook.com/crystaltalk">Facebook</a></td></tr>
                                <tr><td><a href="<?= tep_href_link('article_info.php', 'articles_id=2793'); ?>">Twitter and More</a></td></tr>
                                <tr><td><a href="http://www.youtube.com/user/healingcrystals#p/u">YouTube Channel</a></td></tr>
                                <tr><td><a href="http://pinterest.com/crystaltalk/">Pinterest</a></td></tr>
                                <tr><td><a href="https://plus.google.com/118159989747072814756/posts">Google+</a></td></tr>
                                <tr><td><a href="http://crystaltalk.wordpress.com">Wordpress Blog</a></td></tr>
                                <tr><td><a href="<?= tep_href_link('links.php', 'lPath=9') ?>">Article of the Day</a></td></tr>
                                <tr><td><a href="<?= tep_href_link('links.php', 'lPath=10') ?>">Site of the Day</a></td></tr>
                                <tr><td><a href="<?= tep_href_link('links.php') ?>">Link Partners</a></td></tr>
                            </table></div>
                    </div>
                </td>
            </tr>
            <?php
            /*	$listlinkx = mysql_connect(DB_SERVER, 'healingc_survey', 'survey124HC');
				if ($listlinkx) mysql_select_db('healingc_survey');
				else die('-');
          if (basename($PHP_SELF) == 'index2.php') {

				$surveyquery = mysql_query("select question, qid, s.sid, gid from lime_surveys s, lime_questions q where q.sid = s.sid and short_survey = '1'");
			//	if(mysql_num_rows($surveyquery)>0 && (isset($_COOKIE['osC_AdminEmail']) && $_COOKIE['osC_AdminEmail']!='')){
			 if(mysql_num_rows($surveyquery)>0 ){
            	$survey = mysql_fetch_array($surveyquery);
            ?>
            <tr>
                <td valign="bottom">
                    <div class="glossymenuHeader" style="width:190px;margin-bottom:5px;"><a class="menuitemNE menuitem" href="javascript:void()">Weekly Survey</a>
						<div class="submenuleftX" id="shortSurveyDiv"><form name="shortSurvey" id="shortSurvey" method="post" action="#">
							<table class="submenuAff" cellpadding="0" cellspacing="0" width="100%">
	                             <tr><td><?php echo $survey['question']; ?><input type="hidden" name="surveyid" value="<?php echo $survey['sid']; ?>"/><input type="hidden" name="questionid" value="<?php echo $survey['qid']; ?>"/><input type="hidden" name="groupid" value="<?php echo $survey['gid']; ?>"/></td></tr>
	                             <?php
	                             $answers_query = mysql_query("select * from lime_answers where qid = '".$survey['qid']."' order by sortorder ASC");
	                             while($answers = mysql_fetch_array($answers_query)){
	                             	//print_r($answers);
	                           		echo '<tr><td>'.tep_draw_radio_field('answer',$answers['code']).'&nbsp;'.$answers['answer'].'</td></tr>';
	                             }
                                     echo '<tr><td align="right"><input type="submit" name="Save" value="Save"/></td></tr>';
	                             ?>
	                        </table></form>
	                     </div>
	               </div>
                </td>
            </tr>
            <?php
				}
               }
            mysql_close($listlinkx);
            tep_db_connect();*/
            ?>
            <tr>
                <td valign="bottom">
                    <div class="glossymenuHeader" style="width:190px;margin-bottom:5px;"><a class="menuitemNE menuitem" href="<?php echo tep_href_link('articles.php','tPath=2')?>">Monthly Newsletter</a>
					<form NAME="nLetter" ACTION="/subscribe.php" METHOD="get">
                        <div  class="submenuleftContent">
                    <table border="0" cellspacing="0" cellpadding="0"><tr><td colspan="2"><input type="text"  style="width:100px; font-size: 14px; height: 24px;" name="email_address" id="nlEmail"/></td><td> <div class="glossymenuHeader" style="width:70px;"><a class="menuitemC" href="javascript:void(0);" onclick="document.nLetter.submit();">Sign Up</a></div></td></tr></table>
					</div></form></div>
                </td>
            </tr>
            <tr>
                <td valign="bottom">
                    <div class="glossymenuHeader" style="width:190px;margin-bottom:5px;"><a class="menuitemNE menuitem" href="javascript:void(0);">Popular Tags</a>
                        <div  class="submenuleftContent"><table class="submenuAff" cellpadding="0" cellspacing="0" width="100%">
                            <?php
                            $popular_tag_query = tep_db_query("select tag_name from taglist order by tag_usage desc,rand() limit 11");

                            if (tep_db_num_rows($popular_tag_query)) {
                                $tag_array = '';
                                while ($popular_tag = tep_db_fetch_array($popular_tag_query)) {


									$tags_array .= '<tr><td><a href="' . tep_href_link('tags.php', 'tag_name=' . $popular_tag['tag_name']) . '" class="tagsLink">' . $popular_tag['tag_name'] . '</a></td></tr>';
                                }
                            }
                            echo $tags_array; ?>
							</table>
                        </div>
                    </div>
                </td>
            </tr>
         <?php /*<tr>
                <td valign="bottom">
                    <div class="glossymenuHeader"><a class="menuitemNE menuitem" href="javascript:void(0);">Affiliate Program</a>
                            <div class="submenuleftContent"><table class="submenuAff" cellpadding="0" cellspacing="0" width="100%">
								<?php   if (tep_session_is_registered('affiliate_id')) { ?>
									<tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL') . '">' . BOX_AFFILIATE_SUMMARY . '</a>'; ?>
										</td>
									</tr>
                                                                        <tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS). '">' . 'Create Banner' . '</a>'; ?>
										</td>
									</tr>
                                                                         <tr>
										<td>
											<?php echo '<a href="' . tep_href_link('affiliate_coupon.php'). '">' . 'Create Coupon' . '</a>'; ?>
										</td>
									</tr>


											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'SSL'). '">' . BOX_AFFILIATE_PAYMENT . '</a>'; ?>

									<tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL'). '">' . BOX_AFFILIATE_CLICKRATE . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_SALES, '', 'SSL'). '">' . BOX_AFFILIATE_SALES . '</a>'; ?>
										</td>
									</tr>


											<?php //echo '<a href="' . tep_href_link(FILENAME_CONTACT_US). '">' . BOX_AFFILIATE_CONTACT . '</a>'; ?>
									<tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_ACCOUNT, '', 'SSL'). '">' . 'Account Info' . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_FAQ). '">' . 'Affiliate FAQ' . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_TERMS, '', 'SSL') . '">' . 'Affiliate Terms' . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_LOGOUT). '">' . BOX_AFFILIATE_LOGOUT . '</a>'; ?>
										</td>
									</tr>
								<?php }else{ ?>

                                                                        <tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE, '', 'SSL') . '">' . 'Login' . '</a>'; ?>
										</td>
									</tr>

									<tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_TERMS, '', 'SSL') . '">' . 'Terms' . '</a>'; ?>
										</td>
									</tr>
                                                                        <tr>
										<td>
											<?php echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_FAQ). '">' . 'Affiliate FAQ' . '</a>'; ?>
										</td>
									</tr>

								<?php } ?>
								</table>
                            </div>
                     </div>
                </td>
            </tr> */ ?>
        </table>
    </td>
</tr>
