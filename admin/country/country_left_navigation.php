<div class="leftNav">
    <ul id="menu">
            <li class="dash"><a href="#" title="" class="exp"><span>Country Module</span><!--<span class="numberLeft">6</span>--></a>
            <ul class="sub">
                <?php if (checkAdminAccess('admin/country/add_country.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/country/add_country.php'); ?>" title="">Add New Country</a></li>
                <?php endif; /* (checkAdminAccess('admin/admin/admin_create.php')) */ ?>    
                <?php if (checkAdminAccess('admin/country/index.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/country/index.php'); ?>" title="">Country List</a></li>
                <?php endif; /* (checkAdminAccess('admin/admin/admin_create.php')) */ ?>    
                <?php if (checkAdminAccess('admin/country/add_city.php')): ?>    
                    <li><a href="<?php echo baseUrl('admin/country/add_city.php'); ?>" title="">Add New City</a></li>
                <?php endif; /* (checkAdminAccess('admin/admin/admin_create.php')) */ ?>    
                <?php if (checkAdminAccess('admin/country/city_list.php')): ?>    
                    <li><a href="<?php echo baseUrl('admin/country/city_list.php'); ?>" title="">City List</a></li>
                <?php endif; /* (checkAdminAccess('admin/admin/admin_create.php')) */ ?>    
                <?php if (checkAdminAccess('admin/country/add_city.php')): ?>    
                    <li><a href="<?php echo baseUrl('admin/country/add_area.php'); ?>" title="">Add New Area</a></li>
                <?php endif; /* (checkAdminAccess('admin/admin/admin_create.php')) */ ?>    
                <?php if (checkAdminAccess('admin/country/city_list.php')): ?>    
                    <li><a href="<?php echo baseUrl('admin/country/area_list.php'); ?>" title="">Area List</a></li>
                <?php endif; /* (checkAdminAccess('admin/admin/admin_create.php')) */ ?>    
            </ul>
        </li>
    </ul>

    <div class="leftCol">
        <div class="title">
            <h5>Note</h5>

        </div>
        <div class="leftColInner">
            This is Country Module. In here you can add new country and  edit existing country. Also can add city under a country.
        </div>
    </div>

</div>