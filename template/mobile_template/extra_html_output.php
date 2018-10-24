<?php



////

// The HTML form submit button wrapper function

// Outputs a button in the selected language

  function tep_template_image_submit($image, $alt = '', $parameters = '') {

    global $language;



    $image_submit = '<input type="image" src="' . tep_output_string(STATIC_URL.DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/buttons/' . $language . '/' .  $image) . '"  alt="' . tep_output_string($alt) . '"';



    if (tep_not_null($alt)) $image_submit .= ' title=" ' . tep_output_string($alt) . ' "';



    if (tep_not_null($parameters)) $image_submit .= ' ' . $parameters;



    $image_submit .= '>';



    return $image_submit;

  }



////

// Output a function button in the selected language

  function tep_template_image_button($image, $alt = '', $parameters = '') {

    global $language;



    return tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/buttons/' . $language . '/' .  $image, $alt, '', '', $parameters);

  }





  function table_image_border_top($left, $right,$header){

if (MAIN_TABLE_BORDER == 'yes'){

?>

  <tr>

<td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php

// BOF: WebMakers.com Added: Show Featured Products

if (SHOW_HEADING_TITLE_ORIGINAL!='yes') {

?>

                     <tr>

                      <td bgcolor="#99AECE"><table width="100%" bordercolor="#42ADE8" border="0" cellspacing="0" cellpadding="1">

                          <tr>



                            <td><table width="100%" bordercolor="#42ADE8" border="0" cellspacing="0" cellpadding="1">

                                <tr>

                                  <td bgcolor="#f8f8f9"><table width="100%" border="0" cellspacing="0" cellpadding="4">

                                      <tr>

                                        <td class="pageHeading"><?php echo $header;?></center></td>

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

<?php

}

?>

  <tr>

<td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">



                     <tr>

                      <td bgcolor="#99AECE"><table width="100%" bordercolor="#42ADE8" border="0" cellspacing="0" cellpadding="1">

                          <tr>



                            <td><table width="100%" bordercolor="#42ADE8" border="0" cellspacing="0" cellpadding="1">

                                <tr>

                                  <td bgcolor="#f8f8f9"><table width="100%" border="0" cellspacing="0" cellpadding="4">

                                      <tr>

                                        <td>



<?php

}



}

  function table_image_border_bottom(){

if (MAIN_TABLE_BORDER == 'yes'){

?>

</td>

                                      </tr>

                                    </table></td>

                                </tr>



                              </table></td>

                          </tr>

                          



      </table></td>

  </tr>

      </table></td>

  </tr>



      </table></td>

  </tr>

<?php

}

}

?>