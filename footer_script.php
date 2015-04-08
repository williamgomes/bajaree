<!--  javascript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 


<!-- jQuery bootstrap   --> 
<script src="<?php echo baseUrl(); ?>js/bootstrap.min.js"></script> 

<script type='text/javascript' src="<?php echo baseUrl(); ?>js/holder.js"></script> 
<script src="<?php echo baseUrl(); ?>js/jquery.inview.js"></script> 
<script src="<?php echo baseUrl(); ?>js/jquery.easing.1.3.js"></script> 
<script src="<?php echo baseUrl(); ?>js/jquery.mCustomScrollbar.concat.min.js"></script> 
<script src="<?php echo baseUrl(); ?>js/tnm.carousel.min.js"></script> 
<script type='text/javascript' src="<?php echo baseUrl(); ?>js/carousel.js"></script>
<script type="text/javascript" src="<?php echo baseUrl(); ?>js/jquery.toastmessage.js"></script>
<script type='text/javascript' src="<?php echo baseUrl(); ?>js/bootstrap-datepicker.js"></script>
<script type='text/javascript' src="<?php echo baseUrl(); ?>js/script.js"></script>
<script type='text/javascript' src="<?php echo baseUrl(); ?>js/jquery.minimalect.min.js"></script>
<script type='text/javascript' src="<?php echo baseUrl(); ?>js/jquery.placeholder.js"></script>

<script>
  function checkQuantity() {
    var c = 0;
    var quantity = 0;
    var perCount = 0;
    var countClass = 0;
    countClass = $('.cartQuantity').length;
    $('.cartQuantity').each(function() {
      var perCount = $(this).text();
      var quantity = parseInt(perCount);
      //alert(quantity);
      if (quantity == 0) {
        $(this).addClass("shake");
        c = 1;
      }
    });
    //alert(c);

    if (c === 0 && countClass > 0) {
      window.location = baseUrl + 'checkout-step-1';
    } else {
      if (countClass === 0) {
        toasterrorSettings.text = "You must add a product before checkout."; //echo "executeCheckProduct error: " . mysqli_error($con);
        $().toastmessage('showToast', toasterrorSettings);
      } else {
        toasterrorSettings.text = "Product Quantity must be greater than 0."; //echo "executeCheckProduct error: " . mysqli_error($con);
        $().toastmessage('showToast', toasterrorSettings);
      }
    }
  }
</script>


<script type="text/javascript">

  $(document).ready(function() {


    $(".indgsj select").minimalect();
    //Create an array of titles


  });
</script>

<script type="text/javascript">
$(document).ready(function() {
  $('input, textarea').placeholder();
});  
</script>
