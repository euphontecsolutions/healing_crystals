<?php
/*
  $Id: header.php,v 1.42 2003/06/10 18:20:38 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 */

// WebMakers.com Added: Down for Maintenance
// Hide header if not to show
if (DOWN_FOR_MAINTENANCE_HEADER_OFF == 'false') {
    if (SITE_WIDTH != '100%') {
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=316348330467";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>
        <script type="text/javascript">
			<?php 
			//BOF:mod 20110920 #403
                        function clean_message($string, $clean_from_start = true){
                            $string = trim($string);
                            $lookup_values = array('<p>', '</p>', '&nbsp;');
                            $look_for = null;
                            
                            foreach($lookup_values as $val){
                                if ($clean_from_start){
                                    if (substr($string, 0, strlen($val))==$val){
                                        $look_for = $val;
                                        $look_for_length = strlen($val);
                                        break;
                                    }
                                } else {
                                    if (substr($string, (-1) * strlen($val))==$val){
                                        $look_for = $val;
                                        $look_for_length = strlen($val);
                                    }
                                }
                            }

                            if (!empty($look_for)){
                                if ($clean_from_start){
                                    while(substr($string, 0, $look_for_length)==$look_for){
                                        $string = trim(substr($string, $look_for_length));
                                    }
                                } else {
                                    while(substr($string, (-1) * $look_for_length)==$look_for){
                                        $string = trim(substr($string,0, (-1) * $look_for_length));
                                    }
                                }
                                return clean_message($string, $clean_from_start);
                            } else {
                                return $string;
                            }
                        }
                        
                        function remove_immediate_tag_enclosing_delimiter(&$string, $delimiter = '[BREAK]'){
                            $pos = stripos($string, '>' . $delimiter . '</span>');
                            if ($pos!==false){
                                $before_content = substr($string, 0, $pos);
                                $pos_01 = strrpos($before_content, '<');
                                if ($pos_01!==false){
                                    $before_content = trim(substr($before_content, 0, $pos_01));
                                }
                                $after_content = substr($string, $pos + strlen($delimiter) + 2);
                                $pos_02 = strpos($after_content, '>');
                                if ($pos_02!==false){
                                    $after_content = trim(substr($after_content, $pos_02+1));
                                }
                                $string = $before_content . $delimiter . $after_content;
                                remove_immediate_tag_enclosing_delimiter($string, $delimiter);
                            }
                        }
                        $sql = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key='ROTATING_HEADER_MESSAGES'");
                        if (tep_db_num_rows($sql)){
                            $info = tep_db_fetch_array($sql);
                            $rotating_messages = $info['page_and_email_templates_content'];
                        }
                        $temp = str_ireplace('[break]', '[BREAK]', $rotating_messages);
                        //$temp = str_ireplace('[break]', '[BREAK]', ROTATING_MESSAGES);
                        remove_immediate_tag_enclosing_delimiter($temp);
                        
                        $temp = htmlspecialchars_decode(str_replace("\r\n", "", $temp));
                        $rotating_messages = explode("[BREAK]", $temp);
                        for($i=0; $i<count($rotating_messages); $i++){
                            $temp = $rotating_messages[$i];
                            $temp = clean_message($temp, true);
                            $temp = clean_message($temp, false);
                            $rotating_messages[$i] = $temp;
                        }
			echo 'var rotating_messages_count = ' . count($rotating_messages) . ';' . "\n";
			echo 'var rotating_messages = new Array();' . "\n";
                        $rotating_messages_combined = '';
			for($i=0; $i<count($rotating_messages); $i++){
                            $rotating_messages_combined .= '<div style="margin:20px 5px 20px 5px;">' . $rotating_messages[$i] . '</div>';
                            echo 'rotating_messages[' . $i . '] = "' . str_replace('"', '\\"', $rotating_messages[$i]) . '";' . "\n";
			}
                        $rotating_messages_combined = '<div id="div_rotating_messages" style="display:none;position:absolute;background-color:#ffffff;z-index:1000;border:5px solid #eeeeee;border-top-width:10px;">' . $rotating_messages_combined . '</div>';
			echo 'var rotating_messages_timer;' . "\n";
			echo 'var cur_rotating_message = 0;' . "\n";
			//EOF:mod 20110920 #403 
			?>
            var tx ='';
            var checkDiv = new Array(0,0,0,0,0);
            $(document).ready(function() {
                //Select all anchor tag with rel set to headerTT
                $('a[rel=headerTT]').mouseover(function(e) {
                    //Grab the title attribute's value and assign it to a variable
                    var tip = $(this).attr('title');
                    //Remove the title attribute's to avoid the native headerTT from the browser
                    $(this).attr('title','');
                    //Append the headerTT template and its value
                    $(this).append('<div id="headerTT"><div class="tipHeader"><\/div><div class="tipBody">' + tip + '<\/div><div class="tipFooter"><\/div><\/div>');
                    //Set the X and Y axis of the headerTT
                    $('#headerTT').css('top', e.pageY + 10 );
                    $('#headerTT').css('left', e.pageX + 20 );
                }).mousemove(function(e) {
                    //Keep changing the X and Y axis for the headerTT, thus, the headerTT move along with the mouse
                    $('#headerTT').css('top', e.pageY + 10 );
                    $('#headerTT').css('left', e.pageX + 20 );
                }).mouseout(function() {
                    //Put back the title attribute's value
                    $(this).attr('title',$('.tipBody').html());
                    //Remove the appended headerTT template
                    $(this).children('div#headerTT').remove();
                });
                 $('a[rel=shoppingCartTT]').mouseover(function(e) {
                    //Grab the title attribute's value and assign it to a variable
                    var tip = $(this).attr('title');
                    //Remove the title attribute's to avoid the native headerTT from the browser
                    $(this).attr('title','');
                    //Append the headerTT template and its value
                    $(this).append('<div id="shoppingCartTT"><div class="tipHeader"><\/div><div class="tipBodyLarge" style="text-decoration:none;">' + tip + '<\/div><div class="tipFooter"><\/div><\/div>');
                    //Set the X and Y axis of the headerTT
                    $('#shoppingCartTT').css('top', e.pageY + 10 );
                    $('#shoppingCartTT').css('left', e.pageX + 20 );
                }).mousemove(function(e) {
                    //Keep changing the X and Y axis for the headerTT, thus, the headerTT move along with the mouse
                    $('#shoppingCartTT').css('top', e.pageY + 10 );
                    $('#shoppingCartTT').css('left', e.pageX + 20 );
                }).mouseout(function() {
                    //Put back the title attribute's value
                    $(this).attr('title',$('.tipBodyLarge').html());
                    //Remove the appended headerTT template
                    $(this).children('div#shoppingCartTT').remove();
                });
                //BOF:mod 20110920 #403 
                var left_correction = 300;
                rotating_messages_timer = setInterval('rotate_message()', 5500);
                $('td[id=rotating_message_container]').click(function(e){
                    if($('div#div_rotating_messages').css('display')=='none'){
                        $('div#div_rotating_messages').css('display', '');
                    }else{
                        $('div#div_rotating_messages').css('display', 'none');
                    }
                    $('div#div_rotating_messages').css('top', e.pageY + 10 );
                    $('div#div_rotating_messages').css('left', e.pageX - 20 - left_correction );
                }).mousemove(function(e){
//                    $('div#div_rotating_messages').css('display', '');
                    $('div#div_rotating_messages').css('top', e.pageY + 10 );
                    $('div#div_rotating_messages').css('left', e.pageX - 20 - left_correction );
                }).mouseover(function(e){
                        document.getElementById('info').src="images/info_over.gif";
                        $('info').css('height', '15px');
                }).mouseout(function(e){
//                    document.getElementById('info').src="images/info.gif";
                    $('div#div_rotating_messages').css('display', 'none');
                    $('div#div_rotating_messages').css('height', '15px');
                });
                $("#fbLogo").mouseover(function(e){   
                    $('#fbContent').show();                    
                    $('#fbContent').css('top', e.pageY + 10 );
                    $('#fbContent').css('left', e.pageX - 20 - left_correction );
                }).mousemove(function(e){
                    $('#fbContent').css('top', e.pageY + 10 );
                    $('#fbContent').css('left', e.pageX - 20 - left_correction );
                }).mouseout(function(e){
                    $('#fbContent').hide();
                });
                //EOF:mod 20110920 #403 
            });
			//BOF:mod 20110920 #403 
			function rotate_message(){
                                cur_rotating_message++;
				$('td#rotating_message_container span').fadeOut('slow', function(){
					if (cur_rotating_message>=rotating_messages_count){
						cur_rotating_message = 0;
                                                
					}
					$(this).html('');
                                        var rotHtml = rotating_messages[cur_rotating_message];
					$(this).html(rotHtml);
					$(this).fadeIn('slow', function(){});
				});
			}
			//EOF:mod 20110920 #403 
        </script>
        <script type="text/javascript">
        $(document).ready(function(){
            $('#showquicklinks').toggle(function(){
                 qpos = $(this).position();
                 qtop = qpos.top+101;
                 qleft = qpos.left+777;
                 $('#quicklinks').css("top",qtop);
                 $('#quicklinks').css("left",qleft);
                 $('#quicklinks').show();
                // alert(qleft);
            },function(){
                 $('#quicklinks').hide();
                // alert(qleft);
            });
        });
        var searchddshow ;
        searchddshow = false;
        $(document).ready(function(){
            $('#wholecontent').click(function () {
                //alert(searchddshow);
                if($('#searchdropdown').css('display')=='block' && searchddshow == true){
                    //alert('hiii');
                    $('#searchdropdown').css('display','none');
                    searchddshow = false;
                }else if(searchddshow == true){
                    //alert('hiii12');
                    $('#searchdropdown').css('display','block');
                    searchddshow = false;
                }else{
                    //alert('hiii1234');
                    $('#searchdropdown').css('display','none');
                    searchddshow = false;
                }
            })
        });
        
      // $(document).ready(function(){
          // alert('hiii');
         /* $('#showquicklinks').click(function(){
              //alert('hii');
              var quick_pleft;
              var quick_ptop;
              quick_pos = $(this).position();
              quick_ptop = quick_pos.top + 101;
              quick_pleft = quick_pos.left + 823;
              alert(quick_pleft);
          });*/
      // $('#showquicklinks').click(function(){
      //  pos = $(this).position();
      //  ptop = pos.top+101;
      //  pleft = pos.left+823;
        //alert(ptop);
     // alert(pleft);
   //  if($('#quicklinks').css('display') == 'block'){
   //         $('#quicklinks').hide();
    //    }else{
    //        $('#quicklinks').css("top",ptop);
    //        $('#quicklinks').css("left",pleft);
    //        $('#quicklinks').show();
     //   }
    //   });
       
       /*$('#quicklinks').mouseleave(function(){ 
        $('#quicklinks').hide();
       });*/
       /*$('#showSkuBag').
       $('body:not(#skubag,#showSkuBag)').hover(function(){
        //alert('34');
        $('#arrowsku').hide(); 
        $('#skubag').hide();
       });*/
       
     // });
      </script>
      <table id="wholecontent" width="100%" cellpadding="0" cellspacing="0" border="0" align="left">
          <tr>
              <td align="left" class="backgroundgradient">
        <table  cellpadding="0" cellspacing="0" border="0"  align="left" width="100%">
            <tr>
                
                <td align="center" style=" width:80%; max-width: <?php echo SITE_WIDTH; ?>px; ">
                    <table align="center" class="maintable"  cellspacing="0" cellpadding="0" BORDER="0" width="<?php echo SITE_WIDTH; ?>" >
                        <tr>
                            <td align="left"  width="100%">
                                <table align="left" border="0" width="100%"  cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                    <?php } ?>
									<?php if (tep_session_is_registered('customer_id')) {
										$existingOrderQuery = tep_db_query("select orders_id from orders where customers_id = '".$customer_id."' and orders_status = '2' order by date_purchased DESC LIMIT 1");
                    					if(tep_db_num_rows($existingOrderQuery)){
											$existingOrderArray = tep_db_fetch_array($existingOrderQuery);
											$pageTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'PAGE_TEMPLATE_OPEN_ORDER_TEXT'");
    										$pageTemplateArray = tep_db_fetch_array($pageTemplateQuery);
											$pageTemplateArray['page_and_email_templates_content'] = str_replace('{order_id}', $existingOrderArray['orders_id'], $pageTemplateArray['page_and_email_templates_content']);
									?>
									<table cellspacing="0" cellpadding="0" width="100%" border="0">
									  <tr>
									    <td align="center" width="100%">
										<?php echo $pageTemplateArray['page_and_email_templates_content']; ?>
										</td>
									  </tr>
									</table>
                                    <?php
										}
									  }
                                    // include_once ( $_SERVER["DOCUMENT_ROOT"] . '/includes/banner-top-store-wide.php');
									
                                    if (HEADER_MESSAGE_ACTIVATED == 'yes') {
                                        include_once ( DIR_FS_CATALOG . '/includes/banner-top-store-wide.php');
                                    }
                                    ?>
                                    <table cellspacing="0" align="center" cellpadding="0" width="100%"  border="0" >
                                        <tbody>
                                            <tr>
                                                <td style="background-image: url('templates/New4/images/header/header_10-30.jpg'); background-repeat: no-repeat;
}"> 
                                                    <table cellspacing="0"  border="0"  cellpadding="0" width="100%">
                                                        <tr>
                                                            <td style="padding: 2px 2px 2px 19px;  height: 82px; width: 82px;">
                                                                <a href="http://www.healingcrystals.com">
                                                                    <table cellspacing="0"  border="0"  cellpadding="0" width="100%">
                                                                        <tr>
                                                                            <td width="80" height="80">&nbsp;</td>
                                                                        </tr>
                                                                    </table>
                                                                </a>                                                             
                                                            </td>
                                                            <td>
                                                            <table>
                                                                <tr>
                                                                    <td colspan="2"  width="100%" align="right">
                                                                        <table align="right" cellspacing="0" cellpadding="0" width="100%" border="0">
                                                                            <tr>
                                                                                <td width="20%">&nbsp;</td>
                                                                                <td width="80%" colspan="4" align="right" valign="top" id="rotating_message_container" style="max-height:20px; padding-bottom:3px; padding-right: 10px; cursor:pointer;">
                                                                                    <span><a href="http://www.healingcrystals.com/FAQ_-_Summary_Articles_1109.html"><?php echo $rotating_messages[0]; ?></a>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 65px;" valign="top">
                                                                        <a href="http://www.healingcrystals.com">
                                                                            <table cellspacing="0"  valign="top" border="0"  cellpadding="0" width="100%">
                                                                                <tr>
                                                                                    <td width="420" valign="top" height="63">&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                        </a>                                                                
                                                                    </td>
                                                                    <td style=" height: 65px;" valign="top">

                                                                        <form NAME="quick_find" ACTION="/advanced_search_result.php" METHOD="get"  id="auto_off">
                                                                        <table cellspacing="0"  border="0"  cellpadding="0" width="100%">
                                                                            <tr>
                                                                                <td width="295" height="65">

                                                                                        <table cellspacing="0" cellpadding="0" border="0" id="menu1" style="margin-left:18%;">                             
                                                                                            <tr>
                                                                                                <td valign="top">
                                                                                                    <div class="glossymenuHeader" style="float: left; display: inline; padding-bottom: 3px; padding-top: 1px; padding-left: 43px;">
                                                                                                        <a href="javascript:void(0);" onclick="document.quick_find.submit();"><div style="text-decoration:none; height: 25px; width: 20px;"></div></a>                                                                                            
                                                                                                    </div>
                                                                                                    <div  valign="bottom" align="center" nowrap style=" padding-left: 63px; padding-top: 1px;">
                                                                                                        <INPUT type="hidden" id="searchtextDD" name="dropdown" onclick="searchddshow = true;" value="Search Products..." >
                                                                                                        <INPUT type="text" maxLength="30" style="width:153px; font-size: 14px; background: transparent; outline:none;border:0px none; height: 25px; padding:4px;" id="ya" name="keywords" value="Search Products..." onclick="if(this.value=='Search Products...' || this.value=='Search Articles...' || this.value=='Search MPD...' ){this.value=''}" onblur="if(this.value==''){this.value=$('#searchtextDD').val();}">
                                                                                                        <br>
                                                                                                        <div id="box_search"></div>

                                                                                                    </div>
                                                                                                </td>
                                                                                                <td valign="bottom" align="left" style="padding-bottom:32px; "> 
                                                                                                    <div style=" width:20px; cursor: default;float: left;height:23px; padding-top:0px;"><a onclick="searchddshow = true;" href="javascript:void(0);" style="text-decoration:none;"><div style="padding: 1px; height: 25px; width: 20px;">&nbsp;</div>
                                                                                                        </a>

                                                                                                    </div>

                                                                                                </td>                                            
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding-right: 87px;" valign="top">
                                                                                        <table cellspacing="0" cellpadding="0" border="0"  align="right">
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <div style="position: absolute; width: 225px; overflow: hidden; margin-left: -113px; margin-top: -36px;">
                                                                                                        <ul id="searchdropdown" style="font-size:14px; font-weight:normal; border:1px solid #363636; display:none;background: none repeat scroll 0px 0px white; margin-top: 0px; cursor:default; padding-left: 3px;  color: #868686; width: 219px;">
                                                                                                            <li onclick="$('#searchtextDD').val('Search Catalog...');if($('#ya').val() == '' || $('#ya').val() == 'Search Articles...' || $('#ya').val() == 'Search MPD...'){$('#ya').val('Search Products...');}">Search Product Catalog</li>
                                                                                                            <li onclick="$('#searchtextDD').val('Search Articles...');if($('#ya').val() == '' || $('#ya').val() == 'Search MPD...' || $('#ya').val() == 'Search Products...'){$('#ya').val('Search Articles...');}">Search Article Database</li>
                                                                                                            <li onclick="$('#searchtextDD').val('Search MPD...');if($('#ya').val() == '' || $('#ya').val() == 'Search Articles...' || $('#ya').val() == 'Search Products...'){$('#ya').val('Search MPD...');}">Search Metaphysical Directory</li>
                                                                                                             <!-- html added by dipak kumar burnwal for Advanced Search link start -->
                                                                                                              <li onclick="location.href='advanced_search.php';">Advanced Search</li>
                                                                                                              <!-- html added by dipak kumar burnwal for Advanced Search link end -->
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                        </table>
                                                                        </form>
                                                                    </td>
                                                                    </tr>
                                                                    </table>
                                                            </td>
                                                            <td style=" height: 50px; width:50px;">
                                                                <a href="http://www.facebook.com/crystaltalk">
                                                                    <table cellspacing="0"  border="0"  cellpadding="0" width="100%">
                                                                        <tr>
                                                                            <td width="55" height="50">&nbsp;</td>
                                                                        </tr>
                                                                    </table>
                                                                </a>                                                               
                                                            </td>
                                                            <td style=" height: 82px; width:117px;">
                                                                <table cellspacing="0"  border="0"  cellpadding="0" width="100%">
                                                                    <tr>
                                                                        <td width="25" height="100">
                                                                            <table cellspacing="0"  border="0"  cellpadding="0" width="100%">
                                                                                <tr>
                                                                                    <td style="height:73px; margin-top:2px; margin-bottom:2px;">
                                                                                        <a href="/shopping_cart.php" class="headernavigationShoppingCart" id="shoppingCart">
                                                                                        <table cellspacing="0"  border="0"  cellpadding="0" width="100%" style="height:69px;">
                                                                                            <tr>
                                                                                                <td>
                                                                                                    
                                                                                                        <div style=" margin-left:59px; position:absolute; color:#ffffff;"><?php echo $cart->count_contents().'&nbsp;Item';if($cart->count_contents()>1)echo's'; ?></div>
                                                                                                    
                                                                                        </table>
                                                                                            </a>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="glossymenuHeader">
                                                                                            <a class="menuitemH submenuheader"  href="javascript:void(0);" >&nbsp;</a>
                                                                                            <div class="submenu" style="width:200px; margin-left:-5px;"   onmouseout="if(checkDiv[2]==0){checkDiv[2]=1;}" onmouseover="$(this).bind('mouseenter',function(){clearTimeout(tx)});">
                                                                                                <ul>
                                                                                                    <li><a href="http://www.healingcrystals.com/categories.html">Catalog</a></li>
                                                                                                    <li><a href="http://www.healingcrystals.com/account.php">Account / Login</a></li>
                                                                                                    <?php if (tep_session_is_registered('customer_id')) {?>                                             <li><a href="http://www.healingcrystals.com/logoff.php">Logoff</a></li>                           <?php } ?>
                                                                                                    <li><a href="http://www.healingcrystals.com/articles.php?show_categories=1">Articles & Newsletter Archive</a></li>
                                                                                                    <li><a href="http://www.healingcrystals.com/Facebook__Twitter_and_more_Social_Media_Sites_Articles_2793.html">Community & Social Media</a></li>
                                                                                                    <li><a href="<?= tep_href_link('cards.php'); ?>">Crystal Oracle Cards</a></li>
                                                                                                    <li><a href="http://www.healingcrystals.com/Crystal_Helpers--Physical_Issues_Articles_1020.html">Issue & Ailment Guide</a></li>
                                                                                                    <li><a href="http://www.healingcrystals.com/Metaphysical_Directory_Crystal_Guide_Topics_3.html">Metaphysical Directory</a></li>
                                                                                                    <li><a href="http://www.healingcrystals.com/Healing_Crystals_Directory_Articles_5990.html">Directory / Sitemap</a></li>
                                                                                                    <li><a href="http://www.healingcrystals.com/FAQ_-_Summary_Articles_1109.html">Shipping - Returns - FAQ</a></li>
                                                                                                    <li><a href="http://www.healingcrystals.com/About_Us_Articles_1111.html">About Us</a></li>
                                                                                                    <li><a href="<?= tep_href_link('contact_us.php'); ?>">Contact</a></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" height="1">
                                                    <IMG height="1" src="<?=STATIC_URL?><?= DIR_WS_TEMPLATES . TEMPLATE_NAME ?>/images/header/spacer.gif" width="1" border="0" ALT="">
                                                </td>
                                            </tr>                                           
                                        </tbody>
                                    </table>
                                                        
                                     
			                                                          
<?php
}
?>