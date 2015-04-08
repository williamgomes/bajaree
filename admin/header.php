<link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
<script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>



<!-- Script and style for Light box 2 -->
<script src="<?php echo baseUrl('js/lightbox/js/jquery-1.10.2.min.js'); ?>"></script>
<script src="<?php echo baseUrl('js/lightbox/js/lightbox-2.6.min.js'); ?>"></script>
<link href="<?php echo baseUrl('js/lightbox/css/lightbox.css'); ?>" rel="stylesheet" />
<!-- End Script and Style for Light box 2 -->


<!--tree view -->
<script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>"></script>
<script src ="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type = "text / javascript" ></script>


<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload, editor -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/spinner/ui.spinner.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery-ui.min.js'); ?>"></script>  
<script type="text/javascript" src="<?php echo baseUrl('admin/js/fileManager/elfinder.min.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/jquery.wysiwyg.js'); ?>"></script>
<!-- start link for new nersion tinymc(4.0.7) editor some code are at the last of this file to use the editor you have to set class="tm" at <textarea> -->

<script src="<?php echo baseUrl('admin/js/tinymce/tinymce.min.js'); ?>"></script>
<!--tinymce editor -->


<script type="text/javascript" src="<?php echo baseUrl('admin/js/dataTables/jquery.dataTables.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/dataTables/colResizable.min.js'); ?>"></script>
<!--Effect on left error menu, top message menu -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/forms.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/autogrowtextarea.js'); ?>"></script>
<!--Effect on left error menu, top message menu, File upload -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/autotab.js'); ?>"></script>
<!--Effect on left error menu, top message menu -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/jquery.validationEngine.js'); ?>"></script>
<!--Effect on left error menu, top message menu-->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/colorPicker/colorpicker.js'); ?>"></script>
<!--Effect on left error menu, top message menu -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.html5.js'); ?>"></script>
<!--Effect on file upload-->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.html4.js'); ?>"></script>
<!--No effect-->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/jquery.plupload.queue.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/ui/jquery.tipsy.js'); ?>"></script>
<!--Effect on left error menu, top message menu,  -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/jBreadCrumb.1.1.js'); ?>"></script>
<!--Effect on left error menu, File upload -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/cal.min.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.collapsible.min.js'); ?>"></script>
<!--Effect on left error menu, File upload -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.ToTop.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.listnav.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.sourcerer.js'); ?>"></script>
<!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/ui/jquery.jgrowl.js'); ?>"></script>
<!--jquery.jgrowl.js:Black pop up message -->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/custom.js'); ?>"></script>
<!--Effect on left error menu, top message menu, body-->   
<!--Needed for alert boxes-->
<script type="text/javascript" src="<?php echo baseUrl('admin/js/ui/jquery.jgrowl.js'); ?>"></script>
<script type="text/javascript" src="<?php echo baseUrl('admin/js/ui/jquery.alerts.js'); ?>"></script>
<!--Needed for alert boxes-->




<!-- start script for tinymce a url is also used for it in this page -->
<script>
    var baseUrl = '<?php echo baseUrl(); ?>';
    
    
    
    tinymce.init({
        selector: "textarea.tm",
        forced_root_block: '',
        theme: "modern",
        width: 695,
        height: 200,
        relative_urls: false,
        remove_script_host: false,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
        extended_valid_elements: "span"
    });
</script>
<!-- End script for tinymce a url is also used for it in this page -->
