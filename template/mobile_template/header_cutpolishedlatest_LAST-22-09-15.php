<?php
if (DOWN_FOR_MAINTENANCE_HEADER_OFF == 'false') {
    if (SITE_WIDTH != '100%') {
?>
<div id="fb-root"></div>
<style type="text/css">
    
  .community ul{
     
    list-style: none outside none;
    padding: 0;
    margin : 0px;
    }
  .community  ul li{
/*        float: left;*/
    /*     width: 100px;*/
        
     /*    line-height: 21px;*/
    
        color:#0000ff;
    }
    .community li ul li a{
        display: block;
        padding: 5px 10px;
        text-decoration: none;
         width:140px;
    }
     .community li ul li a:hover{
        background-color:#c1d3ff;
    }
   .community ul li ul{
         background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top,  #ffffff 0%, #ffffff 38%, #c1d3ff 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(38%,#ffffff), color-stop(100%,#c1d3ff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffffff 0%,#ffffff 38%,#c1d3ff 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffffff 0%,#ffffff 38%,#c1d3ff 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffffff 0%,#ffffff 38%,#c1d3ff 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffffff 0%,#ffffff 38%,#c1d3ff 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#c1d3ff',GradientType=0 ); /* IE6-9 */

       position: absolute;
    width: 160px;
    z-index: 9;
    border: 2px solid #000000;
/*    margin-top:3px;*/
    margin-left:-3px;
     display: none;
/*     border-radius:8px;*/
    }
   .community ul li:hover ul{
        display: block; /* display the dropdown */
    }
    .metaphysical ul{
    list-style: none outside none;
    padding: 0;
     margin:0px;
    }
    .metaphysical li ul{
         background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top,  #ffffff 0%, #ffffff 38%, #c1d3ff 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(38%,#ffffff), color-stop(100%,#c1d3ff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffffff 0%,#ffffff 38%,#c1d3ff 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffffff 0%,#ffffff 38%,#c1d3ff 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffffff 0%,#ffffff 38%,#c1d3ff 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffffff 0%,#ffffff 38%,#c1d3ff 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#c1d3ff',GradientType=0 ); /* IE6-9 */

       position: absolute;
    width: 225px;
    z-index: 9;
    border: 2px solid #000000;
/*   margin-top:3px;*/
    margin-left:-88px;
     display: none;
/*      border-radius:8px;*/
    }
    .metaphysical li ul li a{ 
        display: block;
        padding: 5px 10px;
        text-decoration: none;
    }
    .metaphysical li ul li a:hover{ 
         background-color:#c1d3ff;
    }
    .metaphysical ul li:hover ul{
        display: block; /* display the dropdown */
    }
    
    </style>
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
                         $rotating_array = array();
             $rotating_query = tep_db_query("SELECT * FROM configuration where configuration_group_id = 905");
          while($rotating = tep_db_fetch_array($rotating_query)){  
      $rotating_array[$rotating['configuration_key']] = $rotating['configuration_value'];
  }  
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
                }).mouseout(function()  {
                    //Put back the title attribute's value
                    $(this).attr('title',$('.tipBodyLarge').html());
                    //Remove the appended headerTT template
                    $(this).children('div#shoppingCartTT').remove();
                });
                //BOF:mod 20110920 #403 
                var left_correction = 300;
                /*rotating_messages_timer = setInterval('rotate_message()', 5500);
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
//                })
                        //.mouseover(function(e){
//                        document.getElementById('info').src="images/info_over.gif";
                }).mouseout(function(e){
//                    document.getElementById('info').src="images/info.gif";
                    $('div#div_rotating_messages').css('display', 'none');
                });*/
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
                                /*cur_rotating_message++;
				$('td#rotating_message_container span').fadeOut('slow', function(){
					if (cur_rotating_message>=rotating_messages_count){
						cur_rotating_message = 0;
                                                
					}
					$(this).html('');
                                        var rotHtml = rotating_messages[cur_rotating_message];
					$(this).html(rotHtml);
					$(this).fadeIn('slow', function(){});
				});*/
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
     
     function shoppingbagShow(){
         var minibagtable = '#mini-bag-table';
         var ending_right = ($(window).width() - ($(minibagtable).offset().left + $(minibagtable).outerWidth()));
         //alert(ending_right);
         $('#mini-bag-section').css('right',ending_right);
         $('#mini-bag-section').css('display','block');
         
     }
     function shoppingbagHide(){
         $('#mini-bag-section').css('display','none');
         
     }
      $(document).ready(function(){
            $('#showcommunity').toggle(function(){
                 qpos = $(this).position();
                 qtop = qpos.top+101;
                 qleft = qpos.left+777;
                 $('#community').css("top",qtop);
                 $('#community').css("left",qleft);
                 $('#community').show();
                // alert(qleft);
            },function(){
                 $('#community').hide();
                // alert(qleft);
            });
        });
      </script>
        
      <table id="wholecontent" width="100%" cellpadding="0" cellspacing="0" border="0" align="left">
          <tr>
              <td align="center" class="backgroundgradient">
        <table class="wrapper" style="background:none;" cellpadding="0" cellspacing="0" border="0"  align="left" width="100%">
            <tr>
<!--                <td  align="left" style=" width:10%; max-width:10%;" class="backgroundgradientcolorlefttoright" >
                    &nbsp;
                </td>-->
                <td align="left" style=" width:80%; max-width: <?php echo SITE_WIDTH; ?>; ">
                    <table align="center" class="maintable" style="max-width: <?php echo SITE_WIDTH - 10; ?>; " cellspacing="0" cellpadding="0" BORDER="0" width="<?php echo SITE_WIDTH; ?>" >
                        <tr>
                            <td align="left"  width="100%">
                                <table align="left" border="0" width="100%" style="max-width: <?php echo SITE_WIDTH - 10; ?>; " cellpadding="0" cellspacing="0">
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
                                                <td> 
                                                    <table cellspacing="0"  border="0"  cellpadding="0" width="1020" align="center">
                                                        
                                                                                <tr>
      <td ><table width="100%" cellspacing="0" cellpadding="0">
                                    <tr>
                                             <td valign="top"><a href="index.php"><img src="templates/New4/images/header/mandala_122x120.png" style="width: 100px; " alt="">   </a></td></tr>

</table></td>
    <td>
        <table width="100%" cellspacing="0" cellpadding="0" align="right" >
       
                                                                            <tr>
                                                                                <td colspan="2" style="padding-left:65px;" >
                                                                                    <table align="center" cellspacing="0" cellpadding="0" class ="textleft" id="wrapper">
                                                                                        <tr>
                                                                                            
                                                                                         <?php if (tep_session_is_registered('customer_id')) {?>
                                                                                            <td valign="bottom" style="font-size:13px; padding-bottom:2px;"><a  style="color:#000000;" href="<?php echo tep_href_link("account.php", '', 'SSL'); ?>"> Account</a> /<a  style="color:#000000;" href="<?php echo tep_href_link("logoff.php", '', 'SSL'); ?>"> Sign Out</a>&nbsp;&nbsp;&nbsp;|</td>
                                                <?php }else{ ?>
                                                    <td valign="bottom" style="font-size:13px; padding-bottom:2px; "><a  style="color:#000000; " href="<?php echo tep_href_link("login.php", '', 'SSL'); ?>">Account / Sign In&nbsp;&nbsp;&nbsp;|</a>   </td>     
                                            <?php    } ?>      
                                                                                                                                   
                                                    <td style="font-size:13px;"><a style="color:#000000;" href="https://www.facebook.com/crystaltalk">&nbsp;&nbsp;&nbsp;<img src="templates/New4/images/header/Facebook-icon.png" title="Facebook" style="width:20px; height:20px;"></a>&nbsp;<a href="http://www.youtube.com/user/healingcrystals"><img src="templates/New4/images/header/youtube.logo.png" title="You Tube" style="width:20px; height:20px;"></a>&nbsp;<a href="https://twitter.com/crystaltalk"><img src="templates/New4/images/header/twitter.jpg" title="Twitter" style="width:20px; height:20px;"></a>&nbsp;<a href="http://instagram.com/healingcrystals#"><img src="templates/New4/images/header/instagram-icon.png" title="Instagram" style="width:20px; height:20px;"></a>&nbsp;<a href="http://healingcrystals-crystaltalk.tumblr.com/"><img src="templates/New4/images/header/tumblr-icon.png" title="Tumblr" style="width:20px; height:20px;"></a><span class="icons1"><b> / </b></span><a class="icons" style="color:#000000;" href="<?php echo tep_href_link("Facebook__Twitter__Pinterest_and_more_Social_Media_Sites_Articles_2793.html"); ?>">More</a>&nbsp;&nbsp;&nbsp;<span class="icons1"><b>|</b></span></td>          
<!--      <td style="font-size:13px;"><a style="color:#14116c;" href="http://copy.healingcrystals.com/About_Us_Articles_1111.html">&nbsp;&nbsp;&nbsp;About Us&nbsp;&nbsp;&nbsp;|</a></td>-->
      <td valign="bottom" style="font-size:13px; padding-bottom:3px;"><a style="color:#000000;" href="<?php echo tep_href_link("FAQ_-_Summary_Articles_1109.html"); ?>">&nbsp;&nbsp;&nbsp;FAQ&nbsp;&nbsp;&nbsp;|</a></td>
      <td valign="bottom" style="font-size:13px; padding-bottom:3px;"><a style="color:#000000;" href="<?php echo tep_href_link("contact_us.php"); ?>">&nbsp;&nbsp;&nbsp;Contact Us&nbsp;&nbsp;&nbsp;</a></td> </tr>
<!--       <td style="font-size:13px;"><a style="color:#14116c;" href="http://copy.healingcrystals.com/shopping_cart.php#wishlist">&nbsp;&nbsp;&nbsp;Wish List&nbsp;&nbsp;&nbsp;</a></td>     -->
                                                                                    </table></td>
                      <td >
                                                                                    <table align="right" cellspacing="0" cellpadding="0" class ="textleft" id="wrapper">
                                                                                        <tr>                                                               
      <td style="font-size:13px;">
           <table id="mini-bag-table" width="100%" style=" background: url('templates/New4/images/header/shopping_button.png') no-repeat;  background-size:cover; width:227px; height: 28px;" cellspacing="0" cellpadding="0"><tr>
               <td onmouseout="shoppingbagHide()" onmouseover="shoppingbagShow();" style="height:28px; width:144px;"><a style="color:#14116c;" href="<?php echo tep_href_link("shopping_cart.php"); ?>"><div  style=" margin-left:124px; ">(<?php echo $cart->count_contents(); ?>)</div></a>
                  
               </td>
               <td><a style="color:#14116c;" href="<?php echo tep_href_link("checkout_payment.php", '', 'SSL'); ?>"><div>&nbsp;</div></a></td>
              
              <div onmouseout="shoppingbagHide()" onmouseover="shoppingbagShow();"  class="mini-bag-section" id="mini-bag-section" styl="display:none;">
			<div onmouseover="shoppingbagShow();"  class="mini-bag-section-content clearfix">
				<div onmouseover="shoppingbagShow();"  class="mini-bag-section-content-top">
					<div onmouseover="shoppingbagShow();"  class="item-message"></div>
					<a title="Close" href="#" name="Close - Mini" class="ir sprite sprite-close" id="mini-bag-close" onclick="shoppingbagHide(); return false;">X</a>
				</div>
				<div onmouseover="shoppingbagShow();"   class="mini-bag-section-content-scroll">
					<ul class="clearfix"><li class="mini-bag-item empty-item">
        <div ><?php if($cart->count_contents()>0){ echo 'Items:'. $cart->count_contents().
'<br/> Total Amount : $' . $cart->show_total();} else{ echo 'There are currently no items in your Shopping Bag.';  } ?></div>
</li></ul>
				</div>
				<div onmouseover="shoppingbagShow();"  class="mini-bag-section-content-bottom clearfix"></div>
			</div>
		</div>     
               </tr></table>
       </td>  
         
                                                                                        
                                                                                        
                                                                    </tr></table>
                                                                                         
                                                                                </td>
                                                                            </tr>
                                                                           
                                                        <tr>
                                                      <td colspan="3"><table width="100%" cellspacing="0" cellpadding="0"><tr>      

<!--                            <td ><table width="100%" cellspacing="0" cellpadding="0">
                                    <tr>
                                             <td valign="top"><a href="http://copy.healingcrystals.com"><img src="templates/New4/images/header/mandala1.jpg" style="width: 120px; " alt="">   </a></td></tr>

                                </table></td>-->
                          <td width="70%" valign="top"><table width="100%" cellspacing="0" cellpadding="0">
                                    <tr>
                                             <td valign="top" align="right"><a href="index.php"><img src="templates/New4/images/header/text_logo_540x75.png"  onmouseover="tooltip.show();" onmouseout="tooltip.hide();" style="width: 540px; padding-left:30px;" alt="">   </a></td></tr>
<!--                                    <tr>
                                             <td valign="top" align="center"><img src="templates/New4/images/header/tag_line.jpg" style="width: 485px; " alt=""></td></tr>-->

</table></td>

                              <td width="30%" valign="bottom" >
                                  

                                                                        <form NAME="quick_find" ACTION="<?php echo tep_href_link("advanced_search_result.php"); ?>" METHOD="get"  id="auto_off">
                                                                        <table cellspacing="0"  border="0"  cellpadding="0" width="100%">
                                                                            
                                                                            <tr align="center" >
                                                                                <td style=" padding-left:70px; height:27px; z-index:999;">

                                                                                        <table cellspacing="0" cellpadding="0" border="0" id="menu1" style=" background: url('templates/New4/images/header/searchbar_225x31.png') no-repeat;  width:225px; height:31px;"> 
                                                                   
                                                                                            <tr>
                                                                                                
                                                                                                <td valign="top">
                                                                                                    <div class="glossymenuHeader" style="float: left; display: inline; ">
   <a href="javascript:void(0);" onclick="document.quick_find.submit();"><div style=" height: 25px; width: 21px;">&nbsp;</div></a>                                                                                              </div>
                                                                                                    <div  valign="bottom" align="center" nowrap >
                                                                                                        <INPUT type="hidden" id="searchtextDD" name="dropdown" onclick="searchddshow = true;" value="Search Products..." >
                                                                                                        <INPUT type="text" maxLength="30" style="width:153px; font-size: 14px; color:#000000; background: transparent; outline:none;border:0px none; height: 27px; padding:8px; padding-bottom:4px;" id="ya" name="keywords" value="Search Products..." onclick="if(this.value=='Search Products...' || this.value=='Search Articles...' || this.value=='Search MPD...' ){this.value=''}" onblur="if(this.value==''){this.value=$('#searchtextDD').val();}">
                                                                                                        <br>
                                                                                                        <div id="box_search"></div>

                                                                                                    </div>
                                                                                                </td>
                                                                                                <td valign="bottom" align="left" > 
                                                                                                    <div style=" width:20px; cursor: default;float: left;height:23px; "><a onclick="searchddshow = true;" href="javascript:void(0);" style="text-decoration:none;"><div style="padding: 1px; height: 25px; width: 20px;">&nbsp;</div>
                                                                                                        </a>

                                                                                                    </div>

                                                                                                </td>                                            
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding-right: 132px;" valign="top">
                                                                                        <table cellspacing="0" cellpadding="0" border="0"  align="right">
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <div style="position: absolute; width: 225px; overflow: hidden; margin-left: -94px; margin-top:-13px; z-index:99;">
                                                                                                        <ul id="searchdropdown" style="font-size:14px; font-weight:normal; border:1px solid #363636; display:none;background: none repeat scroll 0px 0px white; margin-top: 0px; cursor:default; padding-left: 3px;  color: #868686; width: 219px;">
                                                                                                            <li onclick="$('#searchtextDD').val('Search Catalog...');$('#ya').val('Search Products...');">Search Product Catalog</li>
                                                                                                            <li onclick="$('#searchtextDD').val('Search Articles...');$('#ya').val('Search Articles...');">Search Article Database</li>
                                                                                                            <li onclick="$('#searchtextDD').val('Search MPD...');$('#ya').val('Search MPD...');">Search Metaphysical Directory</li>
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                <td width="100%" colspan="3" align="left" valign="middle"  style="cursor:pointer; vertical-align:middle; height:38px;z-index:9; Padding-left:73px;">     
                                                                                         <div id="demo"><marquee style="width:220px;"><?php echo implode('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$rotating_array); ?></marquee>
                                                                                             </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                            
                                                                        </form>
                                  
                                                                    </td>   
                                                                    
                                            </tr></table></td></tr>
                                                         </table>
</td>
                                                                            </tr>
<!--                                                     <tr>
                                                          <td colspan="2" align="center" style="font-style: italic;">
                                                         Promoting education and the use of crystals to support healing       
                                                            </td>  
                                                        </tr>-->
                                                        <tr>
                                                            <td colspan="3" width="100%" style="border-bottom: 1px solid #000000; ">
                                                                <table  width="100%" cellspacing="0" cellpadding="0"><tr>
                                                                        <td  style="font-weight: bold; font-size:15px; padding-left:12px; padding-right:17px;">
                                                               <div class="community"> <ul><li style=" width:136px;">  <a style="color:#000000;" href="<?=tep_href_link('categories.html');?>">Catalog & Specials</a>
                                              <ul>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("specials.html"); ?>">On Sale Today</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("clearance-crystals.html"); ?>">Clearance Items</a></li>
                                                   <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("products-by-assortments.html"); ?>">Assortments</a></li>                                                  
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("products-by-bestsellers.html"); ?>">Best Sellers</a></li>
                                                                                                   
                                                                                                     <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("discover-products.html"); ?>">Discover</a></li>
                                                                                                      <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("new_arrivals.php"); ?>">New Arrivals</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("other-and-accessories.html"); ?>">Other / Accessories</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("tags.html"); ?>">Products Tags</a></li>
                                                                                                     <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("categories.html"); ?>">Catalog</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("Healing_Crystals_Directory_Articles_5990.html"); ?>">Site Guide</a></li>                                                                                
                                                                                              </ul>
                                                                             
                                                                        </li></ul> </div>                    
                                                            </td>
                                                                        <td style="font-weight: bold; font-size:15px; padding-right:22px;">
                                                                           <div class="community"> <ul><li style="width:111px; height:18px;"> <a style="color:#000000; " href="<?=tep_href_link('products.php','category=J&amp;show=shape');?>"> Crystal Jewelry </a>
                                         <ul>
                                             <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("crystal-jewelry-by-bracelets-shape.html"); ?>">Bracelets</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("crystal-jewelry-by-necklaces-shape.html"); ?>">Necklaces</a></li>
                                                                                                     <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("crystal-jewelry-by-pendants-shape.html"); ?>">Pendants</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("crystal-jewelry-by-shape.html"); ?>">By Shape</a></li>
                                                                                                     <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("crystal-jewelry-by-stone.html"); ?>">By Stone type</a></li>
                                                                                              </ul>
                                                                                                                                  
                                                                        </li></ul> </div>                                               
                                                                                       </td>
                                                         <td  style="font-weight: bold; font-size:15px; padding-right:22px;">
                                                              <div class="community"> <ul><li style="width:110px; height:18px;"> <a style="color:#000000; " href="<?=tep_href_link('products.php','category=C&amp;show=shape');?>">Cut & Polished</a>
                                                                          <ul>
                                                                               <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-angels-shape.html"); ?>">Angels</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-cabochons-shape.html"); ?>">Cabochons</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-geometric_shapes-shape.html",'sort_view=stone'); ?>">Geometric Shapes</a></li>
                                                                                                    
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-hearts-shape.html"); ?>">Hearts</a></li>
                                                                                                   
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-spheres-shape.html"); ?>">Spheres</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-towers-shape.html"); ?>">Towers</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-wands-shape.html"); ?>">Wands</a></li>                                                                                                                                                                                   <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-shape.html"); ?>">By Shape</a></li>   
                                                                                                       <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cut-and-polished-crystals-by-stone.html"); ?>">By Stone Type</a></li>                                                               
                                                                                              </ul>
                                                                             
                                                                        </li></ul> </div>  
                                                                          </td>  
                                                            <td style="font-weight: bold; font-size:15px; padding-right:22px;">
                                                                <div class="community"> <ul><li style=" width:196px; height:18px;"> <a style="color:#000000;" href="<?=tep_href_link('products.php','category=N&amp;show=shape');?>">Natural Crystals & Minerals</a>                                                                   
                                                                          <ul>
                                                                              <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("natural-crystals-and-minerals-by-chips-shape.html"); ?>">Chips</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("natural-crystals-and-minerals-by-chunks-shape.html"); ?>">Chunks</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("natural-crystals-and-minerals-by-clusters-shape.html"); ?>">Clusters</a></li>
                                                                                                    
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("natural-crystals-and-minerals-by-points-shape.html"); ?>">Points</a></li>
                                                                                                    
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("products.php",'show=shape&amp;shape=Specimen&amp;category=N'); ?>">Specimens</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("natural-crystals-and-minerals-clear-quartz-only-by-shape.html"); ?>">Clear Quartz (Only)</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("natural-crystals-and-minerals-by-shape.html"); ?>">By Shape</a></li>                                                           
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("natural-crystals-and-minerals-by-stone.html"); ?>">By Stone Type</a></li>                                                           
                                                                                              </ul>
                                                                             
                                                                        </li></ul> </div>       
                                                                            </td>                                                            
                                                         <td style="font-weight: bold; font-size:15px; padding-right:22px;">
                                                          <div class="community"> <ul><li style="width:117px; height:18px;">   <a style="color:#000000; " href="<?=tep_href_link('products.php','category=T&amp;show=stone');?>">Tumbled Stones</a>
                                                                  <ul>
                                                                      <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("products.php",'show=shape&amp;shape=Chips&amp;category=T'); ?>">Tumbled Chips</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("tumbled-stones-and-gemstones-by-tumbled-shape.html"); ?>">Tumbled Stones</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("tumbled-stones-and-gemstones-by-gallets-shape.html"); ?>">Gallets</a></li>
                                                                                                    
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("tumbled-stones-and-gemstones-by-shape.html"); ?>">By Shape</a></li>
                                                                                                    
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("tumbled-stones-and-gemstones-by-stone.html"); ?>">By Stone Type</a></li>                  
                                                                                              </ul>
                                                                             
                                                                        </li></ul> </div>        
                                                                      </td>  
                                                            
                                                            <td style="font-weight: bold; font-size:15px; padding-right:22px;">
                                                                <div class="community"> <ul><li style="width:78px; height:18px;"><a style="color:#000000; " href="<?php echo tep_href_link("Facebook__Twitter__Pinterest_and_more_Social_Media_Sites_Articles_2793.html"); ?>">Community</a>

                     
                                                                                                <ul>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("contests.html"); ?>">Contests</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("Current_Updates_Topics_17.html"); ?>">Current Updates</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("subscribe.php"); ?>">Newsletter/Daily Nugget</a></li>
                                                                                              
                                                                                                   
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="https://www.facebook.com/crystaltalk">Facebook</a></li>
                                                                                                    
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="https://plus.google.com/u/0/118159989747072814756/posts">Google+</a></li>
                                                                                                   
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="http://instagram.com/healingcrystals#">Instagram</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="http://www.pinterest.com/crystaltalk/">Pinterest</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="http://healingcrystals-crystaltalk.tumblr.com/">Tumblr</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="https://twitter.com/crystaltalk">Twitter</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="http://www.youtube.com/user/healingcrystals">You Tube</a></li>
                                                                                                   <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("video_submission.php"); ?>">Submit a Video</a></li>
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                </ul>
                                                                                                                                  
                                                                        </li></ul> </div> </td>
                                                            <td  style="font-weight: bold; font-size:15px; padding-right:17px;">
                                                       <div class="metaphysical"> <ul><li style="width:126px; height:18px;"><a style="color:#000000;" href="<?=tep_href_link('Beginner_s_Reference_Guide_Articles_11218.html');?>">Metaphysical Info</a>
                     
                                                                                                <ul>
                                                                                                    
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("articles.php",'show_categories=1'); ?>">Article Archive</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("Book_Reviews_Topics_27.html"); ?>">Book Reviews</a></li>
                                                                                                    
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold"href="<?php echo tep_href_link("Crystal_Helpers--Physical_Issues_Articles_1020.html"); ?>">Issues & Ailments Guide</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("cards.php"); ?>">Crystal Divination Cards</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold"href="<?php echo tep_href_link("Crystal_Formations_Articles_1035.html"); ?>">Crystal Formations Guide</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("Crystal_Safeguards_Articles_1009.html"); ?>">Crystal Safeguards</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("quotes-welcome.html"); ?>">Inspirational Quotes</a></li>                                                                                                                                                                                        <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("Metaphysical_Directory_Crystal_Guide_Topics_3.html"); ?>">Metaphysical Directory</a></li>
                                                                                                    <li><a style="font-size:14px; color:#000000; font-weight:bold" href="<?php echo tep_href_link("Beginner_s_Reference_Guide_Articles_11218.html"); ?>">References & Resources</a></li>
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                </ul>
                                                                                                                                  
                                                                        </li></ul> </div>     
                                                            </td>
                                                                    </tr></table> </td>   
                                                        </tr>
                                                    </table>
                                                </td> 
                                            </tr>
                                            </table>
<!--                                       <table cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" height="1">
                                                    <IMG height="1" src="<?=STATIC_URL?><?= DIR_WS_TEMPLATES . TEMPLATE_NAME ?>/images/header/spacer.gif" width="1" border="0" ALT="">
                                                </td>
                                            </tr>                                           
                                        </tbody>
                                    </table>-->
                                                        
                                     
			                                                          
<?php
}
?>