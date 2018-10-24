<?php
/*
  $Id: boxes.tpl.php,v 1.1.1.1 2003/09/18 19:06:13 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class tableBox {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }

  class infoBox extends tableBox {
    function infoBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxContents($contents) {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

  class infoBoxHeading extends tableBox {
    function infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';

		$rigth_corner = tep_draw_separator('spacer.gif', '11', '14');

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="14" class="infoBoxHeading"',
                                         'text' => $contents[0]['image']),
                                   array('params' => 'width="100%" height="14" class="infoBoxHeading"',
                                         'text' => $contents[0]['text']));

      $this->tableBox($info_box_contents, true);
    }
  }

   class infoBoxLeft extends tableBox {
    function infoBoxLeft($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxLeftContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBoxLeft"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxLeftContents($contents) {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="infoBoxLeftContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

  class infoBoxLeftHeading extends tableBox {
    function infoBoxLeftHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';

		$rigth_corner = tep_draw_separator('spacer.gif', '11', '14');

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="14" class="infoBoxLeftHeading"',
                                         'text' => $contents[0]['image']),
                                   array('params' => 'width="100%" height="14" class="infoBoxLeftHeading"',
                                         'text' => $contents[0]['text']));

      $this->tableBox($info_box_contents, true);
    }
  }

  class popupBox extends tableBox {
    function popupBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->popupBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="popupBox"';
      $this->tableBox($info_box_contents, true);
    }

    function popupBoxContents($contents) {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="popupBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="popupBoxContents"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

  class popupBoxHeading extends tableBox {
    function popupBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';

/*      if ($left_corner == true) {
        $left_corner = tep_image(DIR_WS_IMAGES . 'infobox/corner_left.gif');
      } else {
        $left_corner = tep_image(DIR_WS_IMAGES . 'infobox/corner_right_left.gif');
      }
      if ($right_arrow == true) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image(DIR_WS_IMAGES . 'infobox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner == true) {
        $right_corner = $right_arrow . tep_image(DIR_WS_IMAGES . 'infobox/corner_right.gif');
      } else {
        $right_corner = $right_arrow . tep_draw_separator('pixel_trans.gif', '11', '14');
      }
*/
			$rigth_corner = tep_draw_separator('spacer.gif', '11', '14');

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="14" class="popupBoxHeading"',
                                         'text' => $contents[0]['image']),
                                   array('params' => 'width="100%" height="14" class="popupBoxHeading"',
                                         'text' => $contents[0]['text']));

      $this->tableBox($info_box_contents, true);
    }
  }


  class infoboxFooter extends tableBox {
    function infoboxFooter($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
      $this->table_cellpadding = '0';
      if ($left_corner) {
        $left_corner = tep_image(DIR_WS_IMAGES. 'pixel_trans.gif');
      } else {
        $left_corner = tep_image(DIR_WS_IMAGES. 'pixel_trans.gif');
      }
      if ($right_arrow) {
        $right_arrow = '<a class="infoBoxContents" href="' . $right_arrow . '">' . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner) {
        $right_corner = $right_arrow . tep_image(DIR_WS_IMAGES. 'pixel_trans.gif');
      } else {
        $right_corner = $right_arrow . tep_image(DIR_WS_IMAGES. 'pixel_trans.gif');
      }

      $info_box_contents = array();

	# 10/28/08 edit by Bob <www.site-webmaster.com>:
	# removed misssing background image from info box:


      $info_box_contents[] = array(array('params' => ' class="infoBoxHeading"', 'text' => $left_corner),
 						array('params' => ' class="infoBoxHeading" nowrap', 'text' => $right_corner));


       # OLD
#       $info_box_contents[] = array(array('params' => ' class="infoBoxHeading"', 'text' => $left_corner),
#                                    array('params' => 'background="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/backgroundfb.gif" width="100%" ', 'text' => $contents[0]['text']),
#  						array('params' => ' class="infoBoxHeading" nowrap', 'text' => $right_corner));




      $this->tableBox($info_box_contents, true);
    }
  }

  class contentBox extends tableBox {
    function contentBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="contentbox"';
      $this->tableBox($info_box_contents, true);
    }

    function contentBoxContents($contents) {
      $this->table_cellpadding = '4';
      $this->table_parameters = 'class="infoboxcontents"';
      return $this->tableBox($contents);
    }
  }

  class contentBoxHeading extends tableBox {
    function contentBoxHeading($contents) {
      $this->table_width = '100%';
      $this->table_cellpadding = '0';

      $info_box_contents = array();
      $info_box_contents[] = array(
																	 array('params' => 'height="14" class="infoBoxHeading"',
                                         'text' => $contents[0]['image']),
                                   array('params' => 'height="14" class="infoBoxHeading" width="100%"',
                                         'text' => $contents[0]['text'])
                                   );

      $this->tableBox($info_box_contents, true);
    }
  }

  class errorBox extends tableBox {
    function errorBox($contents) {
      $this->table_data_parameters = 'class="errorBox"';
      $this->tableBox($contents, true);
    }
  }

  class productListingBox extends tableBox {
    /*function productListingBox($contents) {
      $this->table_parameters = 'class="productListing"';
      $this->tableBox($contents, true);
    }*/
	function productListingBox($contents, $id='') {
		$this->table_parameters = 'class="productListing"';
		if($id != '') $this->table_parameters .= 'id="'.$id.'"';
		$this->tableBox($contents, true);
	}
  }



  class infoBoxNews extends tableBox {
    function infoBoxNews($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContentsNews($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBoxNews"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxContentsNews($contents) {
      $this->table_cellpadding = '2';
      $this->table_parameters = 'class="infoBoxContentsNews"';
      $info_box_contents = array();
     // $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="infoBoxContentsNews"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));

      }
    //  $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }
?>