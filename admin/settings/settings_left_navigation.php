<div class="leftNav">
    <ul id="menu">
        <li class="tables"><a href="#" title="" class="exp"><span>Settings Module</span></a>
            <ul class="sub">
                <?php if (checkAdminAccess('admin/settings/index.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/index.php'); ?>" title="">General Settings</a></li>                 
                <?php endif; /* (checkAdminAccess('admin/settings/index.php')) */ ?>
                <?php if (checkAdminAccess('admin/settings/image.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/image.php'); ?>" title="">Image Settings</a></li>                 
                <?php endif; /* (checkAdminAccess('admin/settings/image.php')) */ ?>
                <?php if (checkAdminAccess('admin/settings/image.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/settings_delivery.php'); ?>" title="">Delivery Option</a></li>                 
                <?php endif; /* (checkAdminAccess('admin/settings/image.php')) */ ?>
                <?php if (checkAdminAccess('admin/settings/settings_menu.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/settings_menu.php'); ?>" title="">Menu</a></li>                 
                <?php endif; /* (checkAdminAccess('admin/settings/settings_menu.php')) */ ?>

                <?php if (checkAdminAccess('admin/settings/settings_option.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/settings_option.php'); ?>" title="">Options Create</a></li>               
                <?php endif; /* (checkAdminAccess('admin/settings/settings_option.php')) */ ?>

                <?php if (checkAdminAccess('admin/settings/settings_option_list.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/settings_option_list.php'); ?>" title="">Options List</a></li>                   
                <?php endif; /* (checkAdminAccess('admin/settings/settings_option_list.php')) */ ?>
                    
                <?php if (checkAdminAccess('admin/settings/settings_option_list.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/social_settings.php'); ?>" title="">Social Settings</a></li>                   
                <?php endif; /* (checkAdminAccess('admin/settings/settings_option_list.php')) */ ?>    

                <?php if (checkAdminAccess('admin/settings/phpmailer_setting.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/phpmailer_setting.php'); ?>" title="">PHPmailer Setting</a></li>                                              
                <?php endif; /* (checkAdminAccess('admin/settings/phpmailer_setting.php')) */ ?> 
                    
                <?php if (checkAdminAccess('admin/settings/time_slot.php')): ?>
                    <li><a href="<?php echo baseUrl('admin/settings/time_slot.php'); ?>" title="">Time Slot</a></li>                                              
                <?php endif; /* (checkAdminAccess('admin/settings/phpmailer_setting.php')) */ ?>     
            </ul>
        </li>

    </ul>

    <div class="leftCol">
        <div class="title">
            <h5>Note</h5>

        </div>
        <div class="leftColInner">
            This is Product Settings Module : color, size, tags, tax clasess, category 
        </div>
    </div>

</div>