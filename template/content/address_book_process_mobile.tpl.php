   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style type="text/css">
    
table.infoBox tbody tr.infoBoxContents td table {
  display: flex;
  flex-direction: column;
}

table.infoBox tbody tr.infoBoxContents td table tbody tr {
  display: flex;
  flex-direction: row;
  width: 100%;
  justify-content: space-between;
  margin: 10px;
}

table.infoBox tbody tr.infoBoxContents td table tbody tr:nth-child(3) {
  display: none;
}

table.infoBox tbody tr.infoBoxContents td table tbody tr:nth-child(5) {
  display: none;
}

table.infoBox tbody tr.infoBoxContents td table tbody tr td:first-child {
  flex-shrink: 2;
  flex-grow: 1;
  flex-basis: 50%;
}

table.infoBox tbody tr.infoBoxContents td table tbody tr td:nth-child(2) {
  flex-shrink: 1;
  flex-grow: 1;
  flex-basis: 60%;
}

input[type="text"] {
  width: 90%;
  font-size: 17px;
  font:menu;
  padding: 5px;
}
select {
  width: 90%;
  font-size: 17px;
  font:menu;
  padding: 5px;
}

b {
  font-size: 15px;
  font-weight: 700;
}

*:focus {
    outline:none;
}

* {
  text-decoration: none !important;
}

input[type="image"] {
  width: 37%;
}

td.inputRequirement {
  display: none;
}

td > img {
  display: none;
}

.container {
  margin-top: 20px;
}

.flecxe {
  display: flex;
  flex-direction: column;
  margin:5px 0px 5px 0px;
  padding: 5px;
}
  </style>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://www.copy.healingcrystals.com/hybrid_api/bootstrap-3.3.7/js/dropdown.js"></script>
<div class="container">
<?php  if (!isset($HTTP_GET_VARS['delete'])) echo tep_draw_form('addressbook', tep_href_link('address_book_process_mobile.php', (isset($HTTP_GET_VARS['edit']) ? 'edit=' . $HTTP_GET_VARS['edit'] : ''), 'SSL'), 'post', 'onSubmit="return check_form(addressbook);"'); ?>
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;';
//EOF: Lango Added for template MOD
 if (sizeof($navigation->snapshot) > 0) {
        $back_link = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
      } else {
        $back_link = tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');
      }
?>
   
          <tr  class="flecxe">
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
           <tr style="border: 0px;"><td align="left"><a href="<?php echo $back_link; ?>" class="btn btn-info"  style="background-color: #4c6aafad !important; color: #001abc;float: left;">&laquo;  Back </a>
            <!-- <td><?php echo '<a class="btn btn-info" href="' . $back_link . '">' .IMAGE_BUTTON_BACK . '</a>'; ?></td>  -->
        </td></tr>
        </table></td>
      </tr>
<!--       <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php /*if (isset($HTTP_GET_VARS['edit'])) { echo HEADING_TITLE_MODIFY_ENTRY; } elseif (isset($HTTP_GET_VARS['delete'])) { echo HEADING_TITLE_DELETE_ENTRY; } else { echo HEADING_TITLE_ADD_ENTRY; } ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_address_book.gif', (isset($HTTP_GET_VARS['edit']) ? HEADING_TITLE_MODIFY_ENTRY : HEADING_TITLE_ADD_ENTRY), HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);*/ ?></td>
          </tr>
        </table></td>
      </tr> -->
<!--       <tr>
        <td><?php //echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->
<?php
// BOF: Lango Added for template MOD
}else{
if (isset($HTTP_GET_VARS['edit'])) { $header_text = HEADING_TITLE_MODIFY_ENTRY; } elseif (isset($HTTP_GET_VARS['delete'])) { $header_text = HEADING_TITLE_DELETE_ENTRY; } else { $header_text = HEADING_TITLE_ADD_ENTRY; }
}
// EOF: Lango Added for template MOD
?>


<?php
  if ($messageStack->size('addressbook') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('addressbook'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
}
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD

  if (isset($HTTP_GET_VARS['delete'])) {
?>
      <tr class="flecxe">
        <td class="main"><b><?php echo DELETE_ADDRESS_TITLE; ?></b></td>
      </tr>
      <tr class="flecxe panel">
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="Contents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="flecxe">
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main" width="100%" valign="top"><?php echo DELETE_ADDRESS_DESCRIPTION; ?></td>
                <td align="left" width="100%" valign="top"><table border="0" cellspacing="0" cellpadding="2">
                  <tr class="flecxe">
                    <td class="main" align="center" valign="top"><b><?php echo SELECTED_ADDRESS; ?></b><br><?php echo tep_image(DIR_WS_IMAGES . 'arrow_south_east.gif'); ?></td>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" valign="top"><?php echo tep_address_label($customer_id, $HTTP_GET_VARS['delete'], true, ' ', '<br>'); ?></td>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="Contents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
               <!--  <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> -->
             <!--    <td><?php echo '<a class="btn btn-info" href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' .  IMAGE_BUTTON_BACK . '</a>'; ?></td> -->
                <td><?php echo '<a class="btn btn-info btn-block" style="background-color: #4c6aafad !important; color: #001abc;" href="' . tep_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $HTTP_GET_VARS['delete'] . '&action=deleteconfirm', 'SSL') . '">' . IMAGE_BUTTON_DELETE . '</a>'; ?></td>
               <!--  <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> -->
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td><?php include(DIR_WS_MODULES . 'address_book_details.php'); ?></td>

      </tr>
      <tr><?php echo tep_draw_hidden_field('action', 'process'); ?>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
    if (isset($HTTP_GET_VARS['edit']) && is_numeric($HTTP_GET_VARS['edit'])) {
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="Contents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
              <!--   <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> -->
                <!-- <td><?php echo '<a class="btn btn-info" href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' .IMAGE_BUTTON_BACK . '</a>'; ?></td> -->
                <td ><?php echo tep_draw_hidden_field('action', 'update') . tep_draw_hidden_field('edit', $HTTP_GET_VARS['edit']) . '<button class="btn btn-success btn-block" type="submit">'. IMAGE_BUTTON_UPDATE .'</button>';?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
    } else {
     /* if (sizeof($navigation->snapshot) > 0) {
        $back_link = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
      } else {
        $back_link = tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');
      }*/
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="Contents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
               
                 
                <td ><?php echo '<button class="btn btn-success btn-block" type="submit">' .IMAGE_BUTTON_CONTINUE. '</button>'; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>

<?php
    }
  }
?>
    </table><?php if (!isset($HTTP_GET_VARS['delete'])) echo '</form>'; ?>

</div> 