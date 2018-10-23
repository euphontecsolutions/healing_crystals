 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style>
      .grey-text{
          color:#9e9e9e !important;
      }
      TEXTAREA{
          width:100%;
      }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php echo tep_draw_form('contact_us', tep_href_link('contact_us_mobile.php', 'action=send', 'SSL'), 'post', 'onSubmit="return checkForm();"'); ?>
<!--<form name="contact_us" action="http://localhost/contact_us.php?action=send" method="post" onsubmit="return checkForm();">-->
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">



    <?php



    // BOF: Lango Added for template MOD
    #  9/8/08 edit by Bob <http://www.site-webmaster.com>: removed capatcha anti spam code

    if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
        $header_text = '&nbsp;';
//EOF: Lango Added for template MOD
        ?>




        <?php

        function generateCode($characters) {
            /* list all possible characters, similar looking characters and vowels have been removed */
            $possible = '23456789bcdfghjkmnpqrstvwxyz';
            $code = '';
            $i = 0;
            while ($i < $characters) {
                $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
                $i++;
            }
            $_SESSION['security_code'] = $code;
            return $code;
        }


        if($HTTP_GET_VARS['sc_error']==1){
            echo '<tr>
          <td class="formAreaTitle"><span class="inputRequirement">Security Code entered does not match!</span></td>
        </tr>';
        }

// BOF: Lango Added for template MOD
    }else{
        $header_text = HEADING_TITLE;
    }
    // EOF: Lango Added for template MOD
    function tep_cfg_get_zone_name($zone_id) {
        $zone_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . (int)$zone_id . "'");
        if (!tep_db_num_rows($zone_query)) {
            return $zone_id;
        } else {
            $zone = tep_db_fetch_array($zone_query);
            return $zone['zone_name'];
        }
    }
    // BOF: Lango Added for template MOD
    if (MAIN_TABLE_BORDER == 'yes'){
        table_image_border_top(false, false, $header_text);
    }

    if ($messageStack->size('contact') > 0) {
        ?>      <tr>
            <td><?php echo $messageStack->output('contact'); ?></td>
        </tr>
        <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <?php
    }
    if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'success')) {
        ?>
        <tr>
            <td ><?php $pageTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'PAGE_TEMPLATE_CONTACT_CONFIRMATION'");
                $pageTemplateArray = tep_db_fetch_array($pageTemplateQuery);
                echo $pageTemplateArray['page_and_email_templates_content']; ?></td>
        </tr>
        <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <tr>
            <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                    <tr class="">
                        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                    <!--<td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_template_image_button('button_continue.gif', ' Continue ') . '</a>'; ?></td>-->
                                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                </tr>
                            </table></td>
                    </tr>
                </table></td>
        </tr>
        <?php
    } else {
        ?>
        <tr>
            <td ><?php
                $key = 'PAGE_TEMPLATE_CONTACT_US';
                //        $day = strtolower(date('l'));
                //        $time = date('G');
                //      $controller_query = tep_db_query("select count(*) as total from contact_us_page_controller where lower(day) = '".$day."' and starting_time < '".$time."' and ending_time > '".$time."'");
                //      $controller_array = tep_db_fetch_array($controller_query);
                $countQ = tep_db_query("select count(*) as total from online_phone_reps where 1");
                $countA = tep_db_fetch_array($countQ);

                if($countA['total']>0)$key ='PAGE_TEMPLATE_CONTACT_US_OPEN';
                $pageTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = '".$key."'");
                $pageTemplateArray = tep_db_fetch_array($pageTemplateQuery);
                //echo $pageTemplateArray['page_and_email_templates_content']; ?></td>
        </tr>
        <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <tr>
            <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="contentbox">
                    <tr class="">
                        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                <?php if(isset($_SESSION['affiliate_id'])&& $_SESSION['affiliate_id']!=''){
                                    $default_query = tep_db_query("select affiliate_firstname, affiliate_lastname, affiliate_email_address from affiliate_affiliate where affiliate_id = '".$_SESSION['affiliate_id']."'");
                                    $default_array = tep_db_fetch_array($default_query);
                                    $name = $default_array['affiliate_firstname'] . ' ' . 	$default_array['affiliate_lastname'];
                                    $email = $default_array['affiliate_email_address'];
                                }else{
                                    $name = '';
                                    $email = '';
                                }
                                ?>

                                <tr>
                                    <td class="mainCO"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tr>
                                                <td class="mainCO"><?php echo ENTRY_NAME; ?></td>
                                                <!-- <td align="right"><?php echo tep_template_image_submit('button_submit.gif', ' Submit '); ?><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>-->
                                            </tr></table></td>
                                </tr>
                                <tr>
                                    <td class="mainCO"><?php echo tep_draw_input_field('name',$name,'class="form-control"'); ?></td>
                                </tr>
                                <tr>
                                    <?php error_bool($err, "email"); ?><?php echo ENTRY_EMAIL; ?><font color="red">*</font></td>
                                </tr>
                                <tr>
                                    <td class="mainCO"><?php echo tep_draw_input_field('email', $email, 'size=30 class="form-control"'); ?></td>
                                </tr>
                                <tr>
                                    <SCRIPT language="JavaScript">
                                        <!--
                                        function HideMenus()
                                        {
                                            setTimeout("HideOpenMenus()",1500);
                                        }
                                        function HideOpenMenus()
                                        {
                                            document.getElementById('whyspan').style.display = 'none';
                                        }
                                        //-->
                                    </SCRIPT>
                                    <?php error_bool($err, "email"); ?>Re-enter Email: <font color="red">*</font> </td>
                                </tr>
                                <tr>
                                    <td class="mainCO"><?php echo tep_draw_input_field('email_verify', $email, 'size=30 class="form-control"'); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                                </tr>
                                <tr>
<!--                                    <td colspan="2">--><?php //echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?><!--</td></tr>-->

                                <tr>
                                    <?php error_bool($err, "s_code"); ?><?php echo "Security Code:"; ?><font color="red">*</font></td>
                                </tr>
                                <tr>

                                    <td>
                                        <span class="captcha_code" id="captcha_code"><?php echo generateCode(5); ?></span>&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mainCO"> <input id="s_code" name="s_code" type="text" size="30" class="form-control" /></td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;"><?php //echo TEXT_QUESTIONS; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                                </tr>
                                <tr>
                                    <td class="mainCO"><?php echo ENTRY_ENQUIRY; ?><font color="red">*</font></td>
                                </tr>
                                <tr>
                                    <td class="mainCO"><?php echo tep_draw_textarea_field('enquiry', 'soft', 50, 15); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                                </tr>
                            </table></td>
                    </tr>
                </table></td>
        </tr>

        <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <?php
// BOF: Lango Added for template MOD
        if (MAIN_TABLE_BORDER == 'yes'){
            table_image_border_bottom();
        }
// EOF: Lango Added for template MOD
        ?>
        <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
        </tr>
        <tr>
            <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                    <tr class="">
                        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                    <td align="right"><?php echo tep_template_image_submit('mob_submit.png', ' Submit ','style="margin-top: -75px;"'); ?></td>
                                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                </tr>
                            </table></td>
                    </tr>
                </table></td>
        </tr>
        <?php
    }
    ?>
    <script language="javascript">

        <!--

        function checkForm() {
            // alert(document.getElementById("captcha_code").innerText);
            if (document.contact_us.email.value == '') {
                alert ('Please enter your email.')
                return false;
            }
            else if (document.contact_us.email_verify.value == '') {
                alert ('Please enter your verify email.')
                return false;
            }
            else if (document.contact_us.email.value != document.contact_us.email_verify.value) {
                alert ('Please double check your email addresses to make sure that they are entered correctly.')
                return false;
            }else if(document.contact_us.s_code.value==''){
                alert('Please enter the Security Code.');
                return false;
            }else if(document.getElementById("captcha_code").innerText != document.contact_us.s_code.value){
                alert('Your Security Code does not match.');
                return false;
            }else if(document.contact_us.enquiry.value.length == ''){
                alert('Please enter your comment.');
                return false;
            }
            else if(document.contact_us.enquiry.value.length < 10){
                alert('Your comment length should be greater than 10.');
                return false;
            }
            else
            {

                return true;

            }

        }

        //-->

    </script>
    <style type="text/css">
        .captcha_code { display: inline-block; background-image: url('/templates/content/img_captcha.jpg');
            padding: 6px 15px;
            font-weight: bold;
            background-size: cover;
            font-size: 28px;}
    </style>
</table></form>