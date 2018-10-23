<?php
/*
  $Id: shipping.php,v 1.1.1.1 2003/09/18 19:05:13 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class shipping {
    var $modules;

// class constructor
    function shipping($module = '') {
// BOF: WebMakers.com Added: Downloads Controller
      global $language, $PHP_SELF, $cart;
// EOF: WebMakers.com Added: Downloads Controller

      if (defined('MODULE_SHIPPING_INSTALLED') && tep_not_null(MODULE_SHIPPING_INSTALLED)) {
        $this->modules = explode(';', MODULE_SHIPPING_INSTALLED);

        $include_modules = array();

        if ( (tep_not_null($module)) && (in_array(substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)), $this->modules)) ) {
          $include_modules[] = array('class' => substr($module['id'], 0, strpos($module['id'], '_')), 'file' => substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)));
        } else {
          reset($this->modules);
// BOF: WebMakers.com Added: Downloads Controller - Free Shipping and Payments
// Show either normal shipping modules or free shipping module when Free Shipping Module is On
          // Free Shipping Only
          if ( (tep_get_configuration_key_value('MODULE_SHIPPING_FREESHIPPER_STATUS')=='1' and $cart->show_weight()==0) && (!tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] == '')) {
            $include_modules[] = array('class'=> 'freeshipper', 'file' => 'freeshipper.php');
          }elseif((tep_get_configuration_key_value('MODULE_SHIPPING_RETAILPICKUP_STATUS')=='1') && (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] != '')){
              $include_modules[] = array('class'=> 'retailPickUp', 'file' => 'retailPickUp.php');
          }else {
          // All Other Shipping Modules
            while (list(, $value) = each($this->modules)) {
              $class = substr($value, 0, strrpos($value, '.'));
              // Don't show Free Shipping Module
              //if ($class !='freeshipper') {
                $include_modules[] = array('class' => $class, 'file' => $value);
              //}
              }
            }
// EOF: WebMakers.com Added: Downloads Controller - Free Shipping and Payments
        }

        for ($i=0, $n=sizeof($include_modules); $i<$n; $i++) {
          include_once(DIR_WS_LANGUAGES . $language . '/modules/shipping/' . $include_modules[$i]['file']);
          include_once(DIR_WS_MODULES . 'shipping/' . $include_modules[$i]['file']);

          $GLOBALS[$include_modules[$i]['class']] = new $include_modules[$i]['class'];
        }
      }
    }

    function quote($method = '', $module = '') {
      global $total_weight, $shipping_weight, $shipping_quoted, $shipping_num_boxes, $order, $cart;

      $quotes_array = array();
      
      $shipping_surcharge = $cart->shipping_surcharge();

      if (is_array($this->modules)) {
        $shipping_quoted = '';
        $shipping_num_boxes = 1;
        $shipping_weight = $total_weight;


        if ($shipping_weight > SHIPPING_MAX_WEIGHT) { // Split into many boxes
          $shipping_num_boxes = ceil($shipping_weight/SHIPPING_MAX_WEIGHT);
          $shipping_weight = $shipping_weight/$shipping_num_boxes;
        }
        
        if (SHIPPING_BOX_WEIGHT >= $shipping_weight*SHIPPING_BOX_PADDING/100) {
          $shipping_weight = $shipping_weight+SHIPPING_BOX_WEIGHT;
        } else {
          $shipping_weight = $shipping_weight + ($shipping_weight*SHIPPING_BOX_PADDING/100);
        }
        

        $include_quotes = array();

        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if (tep_not_null($module)) {
            if ( ($module == $class) && ($GLOBALS[$class]->enabled) ) {

              $include_quotes[] = $class;
            }
          } elseif ($GLOBALS[$class]->enabled) {
            $include_quotes[] = $class;
          }
        }

        $size = sizeof($include_quotes);

        for ($i=0; $i<$size; $i++) {
          $quotes = $GLOBALS[$include_quotes[$i]]->quote($method);
          /*
          $order_total = $cart->show_total();
          if ($order_total > 100) {
          if ($order->delivery['country_id'] != STORE_COUNTRY) {
           for ($j=0, $n2=sizeof($quotes['methods']); $j<$n2; $j++) {
              $quotes['methods'][$j]['cost'] = $quotes['methods'][$j]['cost'] + 8;
            }
           }
          }
          */

          if ($shipping_surcharge > 0 && sizeof($quotes['methods']) > 0) {
			 for ($j=0, $n2=sizeof($quotes['methods']); $j<$n2; $j++) {
              $quotes['methods'][$j]['cost'] = $quotes['methods'][$j]['cost'] + $shipping_surcharge;
            }
		  }
		  
          if (is_array($quotes)) $quotes_array[] = $quotes;
        }
      }

      return $quotes_array;
    }

    function cheapest() {
      if (is_array($this->modules)) {
        $rates = array();

        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $quotes = $GLOBALS[$class]->quotes;
            for ($i=0, $n=sizeof($quotes['methods']); $i<$n; $i++) {
              //if (isset($quotes['methods'][$i]['cost']) && tep_not_null($quotes['methods'][$i]['cost']) && ($quotes['methods'][$i]['id'] != 'First-Class Mail International Package')) {
                $rates[] = array('id' => $quotes['id'] . '_' . $quotes['methods'][$i]['id'],
                                 'title' => $quotes['module'] . ' (' . $quotes['methods'][$i]['title'] . ')',
                                 'cost' => $quotes['methods'][$i]['cost']);
              //}
              }
            }
          }

        $cheapest = false;
        for ($i=0, $n=sizeof($rates); $i<$n; $i++) {
          if (is_array($cheapest)) {
            if ($rates[$i]['cost'] < $cheapest['cost']) {
              $cheapest = $rates[$i];
            }
          } else {
            $cheapest = $rates[$i];
          }
        }

        return $cheapest;
      }
    }
  }
?>
