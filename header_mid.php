<div class="headerBar navbar-inverse">
    <div class="container">

 <div class="row">
 <a class="brand navbar-brand" href="<?php echo baseUrl(); ?>"> <img height="48" src="<?php echo baseUrl(); ?>images/bajaree.com-Logo.png" alt="Bajaree"> </a>
        <ul class="nav navbar-nav">
            <!-- Classic list -->
            <li class="searhLi hidden-xs">
                <div class="input-append searchBar ">
                    <form action="<?php echo baseUrl(); ?>search" method="get">
                        <input required="true" placeholder="Search for products..."  name="key" type="text" class="span2 searchField" id="appendedInputButton" value="<?php if (isset($_GET['key'])) {
    echo trim($Key);
} ?>">

       
                        <button class="btn searchBtn" type="submit"> </button>
                    </form>
                </div>
            </li>
            <li class="hr-nav hover"> <a href="<?php echo baseUrl(); ?>my-wishlist" class="myList"> My List </a> </li>

            <?php if (basename($_SERVER['PHP_SELF']) == 'cart.php') { ?>
              <li class="hr-nav hover"> <a href="<?php echo baseUrl(); ?>my-cart" class="myCart"> My Cart</a> </li>
                <!--              dont show cart-->
            <?php } elseif (basename($_SERVER['PHP_SELF']) == 'checkout1.php' OR basename($_SERVER['PHP_SELF']) == 'checkout2.php' OR basename($_SERVER['PHP_SELF']) == 'checkout3.php') { ?>
                <li class="hr-nav hover"> <a href="<?php echo baseUrl(); ?>my-cart" class="myCart"> My Cart</a> </li>
            <?php } else { ?>
                <li class="hr-nav hover"> <a class="myCart" id="myCart" data-toggle="modal" data-target="#ModalCart">My Cart</a> </li>
            <?php } ?>

            <?php if (checkUserLogin()): ?>
                <?php
                $accountName = getSession('FirstName');
                $sepString = explode(" ",$accountName);
                $firstName = $sepString[0];
                $countString = strlen($firstName);
                if($countString > 7):
                  $firstName = substr($firstName, 0, 7);
                endif;
                ?>
                <li class="logBtn logBtnFirst hidden-xs" id="loginDiv"> <a href="<?php echo baseUrl(); ?>my-account" class=" btn-bj btn-log"><?php echo $firstName; ?></a> </li>
                <li class="logBtn hidden-xs" id="signupDiv"> <a href="javascript:void(0)" class=" btn-bj btn-signup" onClick="userLogout();"> Logout </a> </li>
                <?php else: ?>
                <li class="logBtn logBtnFirst hidden-xs" id="loginDiv"> <a class=" btn-bj btn-log" data-toggle="modal" data-target="#ModalLogin" id="signinPopup"> Login </a> </li>
                <li class="logBtn hidden-xs" id="signupDiv"> <a class=" btn-bj btn-signup" data-toggle="modal" data-target="#ModalSignup"> Sign Up </a> </li>
<?php endif; ?>
        </ul>
    </div>
</div>
</div>