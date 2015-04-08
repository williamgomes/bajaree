/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */





/*Checking valid email*/
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/*Checking valid email*/



/*Login and Signup script*/

//User Signup script
function UserSignup() {
  
    var email = $('input#signup_email').val();
    var password = $('input#signup_password').val();
    var first_name = $('input#signup_user_first_name').val();
    var phone_start = $('#signup_selectbasic option:selected').val();
    var phone_end = $('input#signup_phone').val();
    var phone = phone_start + '' + phone_end;
    var error = '';
    
    if (first_name == '' || first_name == 'First Name') {
        error = "Name required.";
        errorMessage(error);
    } 
    
    if (email == '' || email == 'Email') {
        error = "Email required.";
        errorMessage(error);
    } 
    
    if (!validateEmail(email)) {
        error = "Please provide a valid Email.";
        errorMessage(error);
    } 
    
    if (password == '' || password == 'Password') {
        error = "Password required.";
        errorMessage(error);
    } 
    
    if (phone_end == '' || phone_end == 'Mobile Number') {
        error = "Mobile Number required.";
        errorMessage(error);
    } 
    
    
    
    if(error == '') {
        
        $('#signupSumit').addClass("active");
        $('#signupSumit').html('<i class="fa fa-spinner fa-spin"></i> Loading');
        $('#signupSumit').attr('disabled');
      
        $.ajax({url: baseUrl + 'ajax/index/signup.php',
            data: {email: email, password: password, first_name: first_name, phone: phone, action: 'signup'}, //Modify this
            type: 'post',
            success: function(output) {
                var result = $.parseJSON(output);
                if (result.error == 0) {
                    success = "Signup process was successful.";
                    $('#signupSumit').removeClass("active");
                    $('#signupSumit').html(' Submit ');
                    $('#signupSumit').removeAttr('disabled');
                    $('input#signup_email').val('');
                    $('input#signup_password').val('');
                    $('input#signup_user_first_name').val('');
                    
                    setTimeout(function() {
                        $("#signupClose").click();
                    }, 600);
                    
                    successMessage(success)
                    var fName = first_name.split(' ')[0];
                    if(fName.length > 7){
                      var userName = jQuery.trim(fName).substring(0, 7);
                      $("#loginDiv").html('<a href="' + baseUrl + 'my-account" class=" btn-bj btn-log"> ' + userName + ' </a>');
                    } else {
                      $("#loginDiv").html('<a href="' + baseUrl + 'my-account" class=" btn-bj btn-log"> ' + fName + ' </a>');
                    }
                    $("#signupDiv").html('<a href="javascript:void(0)" class=" btn-bj btn-signup"  onClick="userLogout();"> Logout </a>');
                    
                    
                    //redirecting or refreshing page
                    var pageName = document.location.pathname.match(/[^\/]+$/)[0];
                    if(pageName == "user-signin-signup" || pageName == "my-wishlist"){
                      window.location.reload();
                    }
                } else if (result.error > 0) {
                  
                    $('#signupSumit').removeClass("active");
                    $('#signupSumit').html(' Submit ');
                    $('#signupSumit').removeAttr('disabled');
                    error = result.error_text;
                    errorMessage(error);

                }

            }
        });
    }
}

//User Signup script






$(function() {

  //press enter on text area..

  $('#signup_email').keypress(function(e) {
    var key = e.which;
    if (key == 13)  // the enter key code
    {
      UserSignup();
    }
  });
  
  $('#signup_password').keypress(function(e) {
    var key = e.which;
    if (key == 13)  // the enter key code
    {
      UserSignup();
    }
  });
  
  $('#signup_user_first_name').keypress(function(e) {
    var key = e.which;
    if (key == 13)  // the enter key code
    {
      UserSignup();
    }
  });
});



//User Login script

function UserLogin() {

    var password = $('input#login_password').val();
    var emailadd = $('input#login_email').val();
    var remember = "no";
    
    //checking if checkbox was checked or not
    if($("#remember_me").prop('checked') == true){
      remember = "yes";
    }
    var error = '';
    var success = '';

    if (emailadd == '' || emailadd == 'Email') {
        error = "Email is required.";
        errorMessage(error);
    } else if (!validateEmail(emailadd)) {
        error = "Please provide a valid Email.";
        warningMessage(error);
    } else if (password == '' || password == 'Password') {
        error = "Password is required.";
        errorMessage(error);
    } else {
        $.ajax({url: baseUrl + 'ajax/index/signin.php',
            data: {email: emailadd, password: password, action: 'signin', remember: remember}, //Modify this
            type: 'post',
            success: function(output) {
                var result = $.parseJSON(output);
                if (result.error == 0) {
                    success = "Signed In.";
                    successMessage(success);
                    $("#loginClose").click();
                    
                    var first_name = result.name;
                    var fName = first_name.split(' ')[0];
                    if(fName.length > 7){
                      var userName = jQuery.trim(fName).substring(0, 7);
                      $("#loginDiv").html('<a href="' + baseUrl + 'my-account" class=" btn-bj btn-log"> ' + userName + ' </a>');
                    } else {
                      $("#loginDiv").html('<a href="' + baseUrl + 'my-account" class=" btn-bj btn-log"> ' + fName + ' </a>');
                    }
                    
                    $("#signupDiv").html('<a href="javascript:void(0)" class=" btn-bj btn-signup" onClick="userLogout();"> Logout </a>');
                    
                    //redirecting or refreshing page
                    var pageName = document.location.pathname.match(/[^\/]+$/)[0];
                    if(pageName == "user-signin-signup" || pageName == "my-wishlist"){
                      window.location.reload();
                    }

                } else if (result.error > 0) {
                    errorMessage(result.error_text);
                }

            }
        });
    }
}
//User Login script




$(function() {

  //press enter on text area..

  $('#login_password').keypress(function(e) {
    var key = e.which;
    if (key == 13)  // the enter key code
    {
      UserLogin();
    }
  });
  
  $('#login_email').keypress(function(e) {
    var key = e.which;
    if (key == 13)  // the enter key code
    {
      UserLogin();
    }
  });
  
});

/*//Login and Signup script*/


/*Minicart Generation Script*/

function generateMiniCart(cartArray, currencySign) {
    var lengthCartArray = cartArray.length;
    var cartHTML = '';
    var totalPrice = 0;
    var totalDiscount = 0;

    if (lengthCartArray > 0) {
        for (var i = 0; i < lengthCartArray; i++) {
            totalPrice += parseFloat(cartArray[i].TC_product_total_price);
            totalDiscount += parseFloat(cartArray[i].TC_discount_amount);
            //console.log(cartArray);
            cartHTML += '<tr class="cartProduct" id="cartItem_' + cartArray[i].TC_id + '">';
            cartHTML += '<td width="20%" class="cartImg">';
            if (cartArray[i].PI_file_name == null) {
                cartHTML += '<img src="' + baseUrl + 'upload/product/small/default.jpg" alt="' + cartArray[i].product_title + '">';
            } else {
                cartHTML += '<img src="' + baseUrl + 'upload/product/small/' + cartArray[i].PI_file_name + '" alt="' + cartArray[i].product_title + '">';
            }
            cartHTML += '</td>';
            cartHTML += '<td width="42%" class="cartProductDescription">';
            cartHTML += '<h4>';
            cartHTML += '<a target="_blank" href="' + baseUrl + 'product/' + cartArray[i].product_id + '/' + cartArray[i].product_title.replace(/\s/g, "_") + '">' + cartArray[i].product_title + '</a>';
            cartHTML += '<span>' + cartArray[i].PI_inventory_title + '</span>';
            cartHTML += '</h4>';
            cartHTML += '<div class="priceglobal">';
            if (cartArray[i].TC_per_unit_discount > 0) {
                cartHTML += '<span class="current-price">' + currencySign + ' ' + intToFloat(cartArray[i].TC_unit_price - cartArray[i].TC_per_unit_discount) + '</span>';
                cartHTML += '<span class="old-price">' + currencySign + ' ' + intToFloat(cartArray[i].TC_unit_price) + '</span><br/>';
                cartHTML += '<span class="save-price"> save ' + currencySign + ' ' + intToFloat(cartArray[i].TC_per_unit_discount) + '</span>';
            } else {
                cartHTML += '<span>' + currencySign + ' ' + intToFloat(cartArray[i].TC_unit_price) + '</span>';
            }
            cartHTML += '</div>';
            cartHTML += '</td>';
            cartHTML += '<td width="18%" align="center"><div class="quantity">';
            cartHTML += '<a href="javascript:void(0)" onClick="tmpCartIncrease(' + cartArray[i].TC_id + ');" title="Increase"><img src="' + baseUrl + 'images/increase.png" alt="increase"></a>';
            if (cartArray[i].TC_product_quantity > 0) {
                cartHTML += '<span id="tempCartQuantity_' + cartArray[i].TC_id + '"><span class="cartQuantity">' + cartArray[i].TC_product_quantity + '</span></span>';
            } else {
                cartHTML += '<span id="tempCartQuantity_' + cartArray[i].TC_id + '"><span class="cartQuantity" style="color:red; font-weight: bold;">' + cartArray[i].TC_product_quantity + '</span></span>';
            }
            cartHTML += '<a style="padding:0;" href="javascript:void(0)" title="Decrease" onClick="tmpCartDecrease(' + cartArray[i].TC_id + ');"><img src="' + baseUrl + 'images/decrease.png" alt="decrease"></a>';
            cartHTML += '</div></td>';
            cartHTML += '<td width="10%" align="center" class="subtotal"><strong>' + currencySign + ' ' + intToFloat(cartArray[i].TC_product_total_price - cartArray[i].TC_discount_amount) + '</strong></td>';
            cartHTML += '<td width="10%" align="center"><a id="deleteTempCart_' + cartArray[i].TC_id + '" class="cartProductDelete" href="javascript:void(0)" onClick="deleteFromCart(' + cartArray[i].TC_id + ',' + cartArray[i].product_id + ');">delete</a></td>';
            cartHTML += '</tr>';
        }
    } else {
        cartHTML += '<tr class="emptyMessage text-center padding-bottom-10"><td colspan="5"><h4 class="modal-title text-left" id="myModalLabel">Nothing added to cart yet.</h4></td></tr>';
    }
    $('#miniCart').html(cartHTML);
    $('#miniCartTotalPrice').text(' Subtotal : ' + currencySign + ' ' + intToFloat(totalPrice));
    $('#cartTotalPrice').text(currencySign + ' ' + intToFloat(totalPrice));
    $('#cartTotalDiscount').text(currencySign + ' ' + intToFloat(totalDiscount));
    $('#cartGrandTotal').text(currencySign + ' ' + intToFloat(totalPrice - totalDiscount));

    updateFooterDeleveryBar(totalPrice);
}

/*Minicart Generation Script*/

function updateFooterDeleveryBar(totalShopping) {
    var minimum_shopping_amount = $("#footerDeliveryHiddenData .minimum_shopping_amount").val();
    var minimum_shopping_charge = $("#footerDeliveryHiddenData .minimum_shopping_charge").val();
    if (totalShopping > 0) {
        var percentage = (100 * totalShopping) / minimum_shopping_amount;
        if (percentage > 100) {
            percentage = 100;
        }
    }else{
         percentage = 0;
    }
    
    $(".bottom-nav .abs-car").attr('data-parchent',percentage);
    if(percentage >=100){
         $(".bottom-nav .abs-car .carBefore").html('<img  class="show" src="'+baseUrl+'images/dok.png">');
    }else{
         $(".bottom-nav .abs-car .carBefore").html('<img  class="hide" src="'+baseUrl+'images/dok.png"> ৳ '+totalShopping);
    }
   
    $(".bottom-nav .abs-car").css('width',percentage+'%');
    if (totalShopping ==0){
            $(".bottom-nav .deliveryText").html('Free Delivery On Order ৳ '+(minimum_shopping_amount)+'+ ');
    }else if (totalShopping < minimum_shopping_amount){
            $(".bottom-nav .deliveryText").html('৳ '+(minimum_shopping_amount-totalShopping)+' More To Free Delivery');
    }else{
            $(".bottom-nav .deliveryText").html(' You unlocked free delivery!');
    }

}
//add to cart JSON

function AddToCart(ProductID, InventoryID) {

    $.ajax({url: baseUrl + 'ajax/Ajax.AddToCart.php',
        data: {ProductID: ProductID, InventoryID: InventoryID, Action: 'AddToCart'}, //Modify this
        type: 'post',
        success: function(output) {
            //alert(output);
            var result = $.parseJSON(output);

            if (result.error == 0) {
                $("#cartCounter_" + ProductID).html("<b>" + result.quantity + "</b>");
                $("a#addToCart_" + ProductID).addClass("active");
                $("#AddToCartText_" + ProductID).text("ADD ONE MORE");
                generateMiniCart(result.fullTempCart, result.currencySign);
                successMessage("Product added to cart successfully.");
            } else {// Email address not verified
                toasterrorSettings.text = result.error_text; //echo "executeCheckProduct error: " . mysqli_error($con);
                $().toastmessage('showToast', toasterrorSettings);
            }

        }
    });
}

//add to cart JSON



/*Add to Wishlist JSON*/

function AddToWishlist(ProductID) {

    var InventoryID = $("#inventory_title option:selected").val();

    $.ajax({url: baseUrl + 'ajax/Ajax.AddToWishlist.php',
        data: {ProductID: ProductID, InventoryID: InventoryID, Action: 'AddToWishlist'}, //Modify this
        type: 'post',
        success: function(output) {
            //alert(output);
            var result = $.parseJSON(output);

            if (result.error == 0) {
                $('#btnAddToWishlist_' + ProductID).addClass('active');
                $('#wishlistBtn_' + ProductID).text("ADDED TO LIST");
                successMessage("Product added to your Wishlist successfully.");
            } else if (result.error == 1) {// User is not signed in
                $("#loginError").show("slow");
                $('#loginError').text(result.error_text);
                setTimeout(function() {
                    $('#loginError').slideUp("slow");
                }, 2500);
                $('#signinPopup').click();
            }

        }
    });
}

/*Add to Wishlist JSON*/


/*Delete from cart*/
function deleteFromCart(TempCartID, ProductID) {
    $.ajax({url: baseUrl + 'ajax/Ajax.DeleteCartItem.php',
        data: {TempCartID: TempCartID, Action: 'DeleteItem'}, //Modify this
        type: 'post',
        success: function(output) {
            //alert(output);
            var result = $.parseJSON(output);
            if (result.error == 0) {
                $('#cartItem_' + TempCartID).css({// this is just for style
                    "background": "#DDDDDD"
                });
                $('#cartItem_' + TempCartID).slideUp("slow");
                //code for change "Add to cart" button look
                $("#cartCounter_" + ProductID).html("<b>" + "</b>");
                $("a#addToCart_" + ProductID).removeClass("active");
                $("#AddToCartText_" + ProductID).text("ADD TO CART");
                generateMiniCart(result.fullTempCart, result.currencySign);
                successMessage("Product deleted from cart.")
            } else {
                alert(result.error_text);
            }
        }
    });
}
/*Delete from cart*/


/*Logout function*/

function userLogout() {
    $.ajax({url: baseUrl + 'ajax/Ajax.UserLogout.php',
        data: {Action: 'Logout'}, //Modify this
        type: 'post',
        success: function(output) {
            //alert(output);
            var result = $.parseJSON(output);
            if (result.error == 0) {
                window.location.reload();
            } else {

            }
        }
    });
}

/*Logout function*/


/*Temp Cart Increase Button Function*/
function tmpCartIncrease(tmpCartID) {
    var Quantity = $('#tempCartQuantity_' + tmpCartID).text();
    var tmpCartQuantity = parseInt(Quantity);
    //alert(tmpCartQuantity);
    $.ajax({url: baseUrl + 'ajax/Ajax.ChngTmpCartQuantity.php',
        data: {TmpCartID: tmpCartID, CartQuantity: tmpCartQuantity, Action: 'Increase'}, //Modify this
        type: 'post',
        success: function(output) {
            //alert(output);
            var result = $.parseJSON(output);
            if (result.error == 0) {
                $('#tempCartQuantity_' + tmpCartID).html('<span class="cartQuantity">' + result.quantity + '</span>');
                $('#miniCartTotalPrice').text(' Subtotal : ' + result.currencySign + ' ' + result.wholeCartPrice);
                $('#tmpCartTotalPrice_' + tmpCartID).html('<strong>' + result.currencySign + ' ' + result.totalPrice + '</strong>');
                $('#cartTotalPrice').text(result.currencySign + ' ' + result.cartSubTotal);
                $('#cartGrandTotal').text(result.currencySign + ' ' + result.wholeCartPrice);
                $('#cartTotalDiscount').text(result.currencySign + ' ' + result.cartTotalDiscount);
                $('#trTax').html('<td>Tax</td><td><strong class="free">'+ result.currencySign +' '+ result.TotalTax +'</strong></td>');
                 updateFooterDeleveryBar(result.wholeCartPrice);
                 successMessage("Product quantity increased.")
            } else {
                errorMessage(result.error_text);
            }
        }
    });
}
/*Temp Cart Increase Button Function*/



/*Temp Cart Increase Button Function*/
function tmpCartDecrease(tmpCartID) {
    var Quantity = $('#tempCartQuantity_' + tmpCartID).text();
    var tmpCartQuantity = parseInt(Quantity);
    //alert(tmpCartQuantity);
    $.ajax({url: baseUrl + 'ajax/Ajax.ChngTmpCartQuantity.php',
        data: {TmpCartID: tmpCartID, CartQuantity: tmpCartQuantity, Action: 'Decrease'}, //Modify this
        type: 'post',
        success: function(output) {
            //alert(output);
            var result = $.parseJSON(output);
            if (result.error == 0) {
                if (result.quantity > 0) {
                    $('#tempCartQuantity_' + tmpCartID).html('<span class="cartQuantity">' + result.quantity + '</span>');
                } else {
                    $('#tempCartQuantity_' + tmpCartID).html('<span class="cartQuantity" style="color:red; font-weight: bold;">' + result.quantity + '</span>');
                }
                $('#miniCartTotalPrice').text(' Subtotal : ' + result.currencySign + ' ' + result.wholeCartPrice);
                $('#tmpCartTotalPrice_' + tmpCartID).html('<strong>' + result.currencySign + ' ' + result.totalPrice + '</strong>');
                $('#cartTotalPrice').text(result.currencySign + ' ' + result.cartSubTotal);
                $('#cartGrandTotal').text(result.currencySign + ' ' + result.wholeCartPrice);
                $('#cartTotalDiscount').text(result.currencySign + ' ' + result.cartTotalDiscount);
                $('#trTax').html('<td>Tax</td><td><strong class="free">'+ result.currencySign +' '+ result.TotalTax +'</strong></td>');
                  updateFooterDeleveryBar(result.wholeCartPrice);
                  successMessage("Product quantity decreased.")
            } else {
                errorMessage(result.error_text);
            }
        }
    });
}
/*Temp Cart Increase Button Function*/




/*Discount Coupon apply code*/
function discountCoupon() {

    var couponID = $('#couponNo').val();
    $.ajax({url: baseUrl + 'ajax/Ajax.ApplyCoupon.php',
        data: {CouponID: couponID, Action: 'ApplyCoupon'}, //Modify this
        type: 'post',
        success: function(output) {
          //alert(output);
          var result = $.parseJSON(output);
          if(result.error == 0){
            successMessage(result.msg_text);
            
            var discountHtml = '';
            discountHtml += '<td align="left">Discount</td>';
            discountHtml += '<td align="left">'+ result.discount_amount +'</td>';
            
            $("#cartTotalDiscount").html(discountHtml);
            $("#grandTotal").html(result.total_amount);
          } else {
            errorMessage(result.error_text);
            
            $("#cartTotalDiscount").html('');
            $("#grandTotal").html(result.total_amount);
          }
        }
    });
}

/*Discount Coupon apply code*/

/*get Parameter value*/
/*
 * 
 * @param {string} name
 * @returns {@exp;@call;decodeURIComponent|String}
 */
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
/*get Parameter value*/


var divClone = '';


$( document ).ready(function() {
    divClone = $("#timeSlotTable").clone();
});


//function setCloneDiv(divName){
//  $(divName).replaceWith(divClone.clone());
//}
/*
 * 
 * @param {checkbox}
 * @returns {HTML}
 */
function applyExpress() {
  
  var timeSlotHtml = '';
  
    $.ajax({url: baseUrl + 'ajax/Ajax.ApplyExpress.php',
        data: {Action: 'ApplyExpress'}, //Modify this
        type: 'post',
        success: function(output) {
          //alert(output);
          var result = $.parseJSON(output);
          if(result.error == 0){
            if($("#express").prop('checked') == true){
                $('#delText').text('Express Delivery');
                $('#delAmount').html('<strong>'+ result.express_charge +'</strong>');
                $("#grandTotal").html(result.total_amount);
                successMessage("Express Delivery added. Extra " + result.express_charge + " will be charged.");
                
                timeSlotHtml += '<tr class="TimingRow">';
                timeSlotHtml += '<td align="center"><label class="btn btn-primary-full btn-primary active">';
                timeSlotHtml += '<input name="timeslot" type="radio" value="' + result.time_slot_hidden_val + '" checked="checked">';
                timeSlotHtml += '' + result.time_slot + '';
                timeSlotHtml += '</label>';
                timeSlotHtml += '</td>';
                timeSlotHtml += '</tr>';
                
                $('#hiddenSlot').val(result.time_slot_hidden_val);
                $("#timeSlotTable").html(timeSlotHtml);
                
//                $('#divTimeSlot').fadeOut('slow');
            } else {
              if(result.delivery_charge > 0){
                $('#delText').text('Delivery');
                $('#delAmount').html('<strong>'+ result.delivery_charge_with_sign +'</strong>');
                $("#grandTotal").html(result.total_amount_before);
                successMessage("Express Delivery removed.");
//                $('#divTimeSlot').fadeIn('slow');
              } else {
                $('#delText').text('Delivery');
                $('#delAmount').html('<strong>FREE!</strong>');
                $("#grandTotal").html(result.total_amount_before);
                successMessage("Express Delivery disabled.");
//                $('#divTimeSlot').fadeIn('slow');
              }
              
              $("#timeSlotTable").replaceWith(divClone.clone());
            }
            
          } else {
            errorMessage(result.error_text);
            
            $("#cartTotalDiscount").html('');
            $("#grandTotal").html(result.total_amount);
          }
        }
    });
}
/*get Parameter value*/


/*Time Slot Checking Javascript*/

function putTimeSlot(id){
  var timeValue = $('input:radio[name=timeslot]:checked').val();
  $('#hiddenSlot').val(timeValue);
}
/*Time Slot Checking Javascript*/


/*Time Slot Checking Javascript*/

function updatePhoneThanku(orderno) {
  
  var phoneNo = $("#billingPhone").val();
    $.ajax({url: baseUrl + 'ajax/Ajax.UpdateContactThanku.php',
        data: {OrderID: orderno, Phone : phoneNo}, //Modify this
        type: 'post',
        success: function(output) {
          //alert(output);
          var result = $.parseJSON(output);
          if(result.error == 0){
           successMessage(result.success_text);
          } else {
            errorMessage(result.error_text);
          }
        }
    });
}
/*Time Slot Checking Javascript*/
