<script>
    $(document).ready(function() {
        $('.adminClass').addClass('collapse-open');

        /*setTimeout(function(){
         $('.adminClass').addClass('collapse-open');}, 1500);*/
    })
</script>

<div class="leftNav">
    <ul id="menu">
            <li class="dash"><a href="#" id="adminClass" title="" <?php if (getCurrentDirectory() == 'admin') {
    echo 'class="active"';
} else {
    echo 'class="exp"';
} ?>><span>Promotion Module Menu</span><!--<span class="numberLeft">6</span>--></a>
            <ul class="sub">
                <li><a href="<?php echo baseUrl('admin/promotion/promotion_create.php'); ?>" title="">Create Promotion</a></li>
                <li><a href="<?php echo baseUrl('admin/promotion/index.php'); ?>" title="">Promotion List</a></li>
            </ul>
        </li>
    </ul>

    <div class="leftCol">
        <div class="title">
            <h5>Note</h5>

        </div>
        <div class="leftColInner">
            This is promotion module. You can create, update and see the list of promotion offers in this module.
        </div>
    </div>

</div>