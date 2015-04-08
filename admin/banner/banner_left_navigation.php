<div class="leftNav">
    <ul id="menu">
            <li class="dash"><a href="#" title="" class="exp"><span>Banner Module Menu</span><!--<span class="numberLeft">6</span>--></a>
            <ul class="sub">
                <?php if (checkAdminAccess('admin/banner/banner_create.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/banner/banner_create.php'); ?>" title="">Create Banner</a></li>                 
                <?php endif; /* (checkAdminAccess('admin/banner/banner_create.php')) */ ?>

                <?php if (checkAdminAccess('admin/banner/index.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/banner/index.php'); ?>" title="">Banner List</a></li>               
                <?php endif; /* (checkAdminAccess('admin/banner/index.php')) */ ?>

            </ul>
        </li>
    </ul>

    <div class="leftCol">
        <div class="title">
            <h5>Note</h5>

        </div>
        <div class="leftColInner">
            This is admin module. You can create, update and see the list of admin in this module.
        </div>
    </div>

</div>