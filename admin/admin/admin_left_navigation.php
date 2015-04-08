<div class="leftNav">
    <ul id="menu">
            <li class="dash"><a href="#" title="" class="exp"><span>Admin Module Menu</span><!--<span class="numberLeft">6</span>--></a>
            <ul class="sub">
                <?php if (checkAdminAccess('admin/admin/admin_create.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/admin/admin_create.php'); ?>" title="">Create Admin</a></li>
                <?php endif; /* (checkAdminAccess('admin/admin/admin_create.php')) */ ?>
                <?php if (checkAdminAccess('admin/admin/index.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/admin/index.php'); ?>" title="">Admin List</a></li>
                <?php endif; /* (checkAdminAccess('admin/admin/index.php')) */ ?>
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