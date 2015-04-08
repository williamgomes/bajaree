/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function deleteWishlist(WishlistID){
  $.ajax({url: baseUrl + 'ajax/wishlist/deleteWishlist.php',
    data: {WishlistID:WishlistID, Action:'DeleteWishlist'}, //Modify this
    type: 'post',
    success: function(output) {
      //alert(output);
      var result = $.parseJSON(output);
      if(result.error == 0){
        $('#wishlistItem_'+WishlistID).css({ // this is just for style
            "background": "#DDDDDD"
        });
        $('#wishlistItem_'+WishlistID).slideUp("slow");
        if(result.quantity == 0){
          $('#generateWishList').html('<tr class="cartProduct"><td colspan="5" class="emptyWishlist text-center"><h4>No item found.</h4></td></tr>');
        }
      } else {
        alert(result.error_text)
      }
    }
  });
}
