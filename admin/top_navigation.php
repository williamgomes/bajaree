<!-- Top navigation bar -->
<div id="topNav">
    <div class="fixed">
        <div class="wrapper">
            <div class="welcome"><a href="<?php
                if (getSession('admin_id')) {
                    echo baseUrl('admin/admin/admin_change_password.php?id=' . base64_encode(getSession('admin_id')));
                } else {
                    echo 'javascript:void(0);';
                }
                ?>" title=""><img src="<?php echo baseUrl('admin/images/userPic.png'); ?>" alt="" /></a><span><?php
                                        if (getSession('admin_name')) {
                                            echo getSession('admin_name');
                                        } else {
                                            echo 'Unknown Admin';
                                        }
                                        ?></span></div>
            <div class="userNav">
                <ul>



                    <li class="dd3"><img src="<?php echo baseUrl('admin/images/icons/custom/others.png'); ?>" height='11' width='11' alt="profile" /><span>Others</span>
                        <ul class="menu_body">
                            <?php if (checkAdminAccess('admin/file_manager/index.php')): ?>
                                <li><a href="<?php echo baseUrl('admin/file_manager/index.php'); ?>" >File Manager</a></li>
                            <?php endif; /* (checkAdminAccess('admin/file_manager/index.php')) */ ?>
                            <?php if (checkAdminAccess('admin/banner/index.php')): ?>
                                <li><a href="<?php echo baseUrl('admin/banner/index.php'); ?>" >Banner</a></li>
                            <?php endif; /* (checkAdminAccess('admin/banner/index.php')) */ ?>
                        </ul>
                    </li>


                    <li class="dd"><img src="<?php echo baseUrl('admin/images/icons/topnav/settings.png'); ?>" alt="profile" /><span>Settings</span>
                        <ul class="menu_body">
                            <?php if (checkAdminAccess('admin/settings/index.php')): ?>
                                <li><a href="<?php echo baseUrl('admin/settings/index.php'); ?>" >Website Settings</a></li>
                            <?php endif; /* checkAdminAccess('admin/settings/index.php') */ ?>

                        </ul>
                    </li>
                    <li class="dd1"><img src="<?php echo baseUrl('admin/images/icons/topnav/profile.png'); ?>" alt="profile" />
                        <span><?php
                            if (getSession('admin_email')) {
                                echo getSession('admin_email');
                            } else {
                                echo 'Unknown Admin';
                            }
                            ?>
                        </span>
                        <ul class="menu_body">

                            <li><a href="<?php echo baseUrl('admin/admin/admin_change_password.php'); ?>" >Change Password</a></li>
                            <li><a href="<?php echo baseUrl('admin/logout.php'); ?>" >Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="fix"></div>
        </div>
    </div>
</div>