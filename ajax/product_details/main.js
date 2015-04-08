/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


//generating image div from the array
function generateImageDiv(imageArray){
  var curTime = new Date().getTime();
  var countImg = imageArray.length;
  var imageHtml = '';
  var singleImageHtml = '';
  if(countImg > 0){
    singleImageHtml += '<div style="position: absolute; height: 100%; width: 100%; z-index: 100;"></div>';
    singleImageHtml += '<img id="multizoom2" alt="'+imageArray[0].PI_file_name+'?t='+curTime+'" title="" src="'+ baseUrl +'upload/product/original/'+imageArray[0].PI_file_name+'?t='+curTime+'"/>';
    for(var i = 0; i < countImg; i++){
      imageHtml += '<a href="'+ baseUrl +'upload/product/original/'+imageArray[i].PI_file_name+'?t='+curTime+'" data-large="'+ baseUrl +'upload/product/original/'+imageArray[i].PI_file_name+'?t='+curTime+'" data-title="'+imageArray[i].PI_file_name+'?t='+curTime+'"><img src="'+ baseUrl +'upload/product/small/'+imageArray[i].PI_file_name+'?t='+curTime+'" title="'+imageArray[i].PI_file_name+'"/></a>';
    }
  } else {
    singleImageHtml += '<img id="multizoom2" alt="" title="" src="'+ baseUrl +'upload/product/original/default.jpg"/>';
    imageHtml += '<a href="'+ baseUrl +'upload/product/original/default.jpg" data-large="'+ baseUrl +'upload/product/original/default.jpg" data-title=""><img src="'+ baseUrl +'upload/product/small/default.jpg" title=""/></a>';
  }
  $('#singleImageDiv').html(singleImageHtml);
  $('#multiImage').html(imageHtml);
  
  
/*Reinit zoom*/
  $('#multizoom2').addimagezoom({// multi-zoom: options same as for previous Featured Image Zoomer's addimagezoom unless noted as '- new'
        descArea: '#description2', // description selector (optional - but required if descriptions are used) - new
        disablewheel: true, // even without variable zoom, mousewheel will not shift image position while mouse is over image (optional)
        zoomrange: [3, 10],
        magnifiersize: [350, 350],
        cursorshadecolor: '#fdffd5',
        //	innerzoommagnifier: true,
        cursorshade: true,
        cursorshadeborder: '1px solid #DDDDDD',
    });
/*//Reinit zoom*/  

}





//Show Inventory information using select box

function ShowInventoryInfo(ProductID) {

  var InventoryID = $("#inventory_title option:selected").val();

  $.ajax({url: baseUrl + 'ajax/product_details/InventoryInfoShow.php',
    data: {ProductID: ProductID, InventoryID: InventoryID, Action: 'GetInventoryInfo'}, //Modify this
    type: 'post',
    success: function(output) {
      //alert(output);
      var result = $.parseJSON(output);
      
      if (result.error == 0) {
        $("#productSize").text(result.size);
        //checking if old_price exist in database
        if (result.old_price > 0) {
          $("#productOldPrice").slideDown("slow");
          $("#productOldPrice").text(result.currencySign + ' ' + result.old_price);
        } else {
          $("#productOldPrice").slideUp("slow");
        }

        //checking if product already exist in temporary cart
        if (result.tempcartquantity > 0) {
          $("#cartCounter_" + ProductID).html("<b>" + result.tempcartquantity + "</b>");
          $("a#addToCart_" + ProductID).addClass("active");
          $("#AddToCartText_" + ProductID).text("ADD ONE MORE");
        } else {
          $("#cartCounter_" + ProductID).html("<b></b>");
          $("a#addToCart_" + ProductID).removeClass("active");
          $("#AddToCartText_" + ProductID).text("ADD TO CART");
        }
        
        //checking if product already exist in wish list
        if (result.wishlistCheck) {
          $("a#btnAddToWishlist_" + ProductID).addClass("active");
          $("a#btnAddToWishlist_" + ProductID).removeAttr("onClick");
          $("#wishlistBtn_" + ProductID).text("ADDED TO LIST");
        } else {
          $("a#btnAddToWishlist_" + ProductID).removeClass("active");
          $("a#btnAddToWishlist_" + ProductID).attr("onClick", "AddToWishlist('"+ ProductID +"')");
          $("#wishlistBtn_" + ProductID).text("ADD TO MY LIST");
        }
        
        generateImageDiv(result.productImage);

        $("#productCurrentPrice").text(result.currencySign + ' ' + result.current_price);
        
        

      }
    }
  });
}


//Show Inventory information using select box



//add to cart JSON

function AddToCartProductDetails(ProductID) {
  var InventoryID = $("#inventory_title option:selected").val();

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
       
        successMessage("Product added to cart")
        generateMiniCart(result.fullTempCart,result.currencySign);
      } else {// Email address not verified
//        toasterrorSettings.text=result.error_text; //echo "executeCheckProduct error: " . mysqli_error($con);
//        $().toastmessage('showToast', toasterrorSettings);
                errorMessage(result.error_text)
      }
    }
  });
}

//add to cart JSON