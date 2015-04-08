
<?php echo get_option("GOOGLE_ANALYTICS"); ?>

<script type="text/javascript">

/*Function for Toast Message*/

function successMessage(message){
  toastsuccessSettings.text=message;
  $().toastmessage('showToast', toastsuccessSettings);
}
function errorMessage(message){
  toasterrorSettings.text=message;
  $().toastmessage('showToast', toasterrorSettings);
}
function warningMessage(message){
  toastwarningSettings.text=message;
  $().toastmessage('showToast', toastwarningSettings);
}

/*Function for Toast Message*/



</script>

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo baseUrl(); ?>ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo baseUrl(); ?>ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo baseUrl(); ?>ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo baseUrl(); ?>ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="<?php echo baseUrl(); ?>ico/favicon.png">

<script>
    var baseUrl = '<?php echo baseUrl(); ?>';
    
  
/* toastmessage start */
    var Success = 'Empty message',
        toastsuccessSettings = {
            text: Success,
            sticky: false,
            position: 'top-right',
            type: 'success',
            closeText: '',
            close: function() {
               // console.log("toast is closed ...");
            }
        };
  var error = 'Empty message',
        toasterrorSettings = {
            text: error,
            sticky: false,
            position: 'top-right',
            type: 'error',
            closeText: '',
            close: function() {
              //  console.log("toast is closed ...");
            }
		
        };
		
  var warning = 'Empty message',
        toastwarningSettings = {
            text: warning,
            sticky: false,
            position: 'top-right',
            type: 'warning',
            closeText: '',
            close: function() {
              //  console.log("toast is closed ...");
            }
        };
        
/* toastmessage end */ 

</script>
<!-- bootstrap styles -->
<link href="<?php echo baseUrl(); ?>css/bootstrap.css" rel="stylesheet">
<!-- menu styles -->
<link href="<?php echo baseUrl(); ?>css/style.css" rel="stylesheet">
<link href="<?php echo baseUrl(); ?>css/menu.css" rel="stylesheet">
<link href="<?php echo baseUrl(); ?>css/cart.css" rel="stylesheet">
<link href="<?php echo baseUrl(); ?>css/font-awesome.css" rel="stylesheet">
<link href="<?php echo baseUrl(); ?>css/datepicker.css" rel="stylesheet" />
<link href="<?php echo baseUrl(); ?>css/jquery.mCustomScrollbar.css" rel="stylesheet">
<link href="<?php echo baseUrl(); ?>css/carousel.css" rel="stylesheet">
<link href="<?php echo baseUrl(); ?>css/carousel-theme.css" rel="stylesheet">
<link href="<?php echo baseUrl(); ?>css/jquery.toastmessage.css" rel="stylesheet" type="text/css" />
<link href="<?php echo baseUrl(); ?>css/jquery.minimalect.min.css" rel="stylesheet">

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<link href="<?php echo baseUrl(); ?>css/ie.css" rel="stylesheet" type="text/css"/>
    <![endif]-->


<!--[if lt IE 8]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<link href="<?php echo baseUrl(); ?>css/ie.css" rel="stylesheet" type="text/css"/>
    <![endif]-->

<!--[if lt IE 7]>
	<link href="<?php echo baseUrl(); ?>css/ie.css" rel="stylesheet" type="text/css"/>
    <![endif]-->


<script type='text/javascript' src="<?php echo baseUrl(); ?>js/jquery-1.10.0.min.js"></script> 
<script type='text/javascript' src="<?php echo baseUrl(); ?>js/custom.javascript.js"></script>





<script type='text/javascript'>
    
//system message on toast 


    $(document).ready(function() {
        var message = '<?php echo $msg; ?>';
        var error = '<?php echo $err; ?>';
        var warning = '<?php echo $warning; ?>';
        if(message !=""){
              successMessage(message);
        }
        if(error !=""){
              errorMessage(error);
        }
        if(warning !=""){
               warningMessage(warning);
        }
      
       
       
    });
</script>


