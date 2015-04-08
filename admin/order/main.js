

function saveSupplier(supplierID, orderProductID) {

  var status = '';

  if ($("#supplier_" + supplierID).prop('checked') == true) {
    status = 'TRUE';
  } else {
    status = 'FALSE';
  }

  $.ajax({url: 'ajax.SaveSupplier.php',
    data: {supplierID: supplierID, orderProductID: orderProductID, status: status}, //Modify this
    type: 'post',
    success: function(output) {
      alert(output);
      var result = $.parseJSON(output);
      if (result.error == 0) {
        alert(result.error_text);
      } else {
        alert(result.error_text);
      }
    }
  });

}





function showProductInfo(inventoryID) {

  $.ajax({url: 'ajax.GetProductInfo.php',
    data: {inventoryID: inventoryID}, //Modify this
    type: 'post',
    success: function(output) {
      //alert(output);
      var result = $.parseJSON(output);
      if (result.error == 0) {
        //do nothing
        $('#productTitle').text(result.product_title);
        $('#inventoryTitle').text(result.inventory_title);
        $('#supplier').html(result.supplier_selectbox);
        $('#product_id').val(result.product_id);
        $('#unit_price').val(result.unit_price);
        $('#unit_discount').val(result.unit_discount);
        $('#tax').val(result.tax);
      } else {
        alert(result.error_text);
      }
    }
  });

}