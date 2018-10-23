<script type="text/javascript" language="javascript"><!--
var selected;
var selectedShipping;
var submitter = null;
function submitFunction() {
   submitter = 1;
   }

function selectRowEffectShipping(object, buttonSelect) {
  if (!selectedShipping) {
    if (document.getElementById) {
      selectedShipping = document.getElementById('defaultSelectedShipping');
    } else {
      selectedShipping = document.all['defaultSelectedShipping'];
    }
  }

  if (selectedShipping) selectedShipping.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selectedShipping = object;

// one button is not an array
  if (document.checkout_payment.shipping[0]) {
    document.checkout_payment.shipping[buttonSelect].checked=true;
  } else {
    document.checkout_payment.shipping.checked=true;
  }
}

function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;

// one button is not an array
  if (document.checkout_payment.payment[0]) {
    document.checkout_payment.payment[buttonSelect].checked=true;
  } else {
    document.checkout_payment.payment.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

//begin cvv contribution
function popupWindow(url) {
window.open(url,'popupWindow','toolbar=no,location=no,directories=no status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=450,screenX=150,screenY=150,top=150,left=150')
}
//end cvv contribution

//--></script>
<?php echo $payment_modules->javascript_validation(); ?>