/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//showing all address against the user from database
function showAllAddresses(addressArray){
  var lengthAddressArray = addressArray.length;
  var addressHTML = '';
  
 if(lengthAddressArray > 0){ 
  for(var i = 0; i < lengthAddressArray; i++){
      //console.log(addressArray);
      addressHTML += '<div class="panel panel-default">';
      addressHTML += '<div class="panel-body"><div class="col-md-6 pull-left">';
      addressHTML += '<h5> '+addressArray[i].UA_title+' <span class="label label-info collapsed" data-toggle="collapse" data-target="#addressDetails_'+addressArray[i].UA_id+'"> View </span> <span class="label label-danger"> edit </span> </h5>';
      addressHTML += '';
      addressHTML += '<div id="addressDetails_'+addressArray[i].UA_id+'" class="collapse hrTop">';
      addressHTML += '<p>'+addressArray[i].UA_address+'<br>'+addressArray[i].area_name+', '+addressArray[i].city_name+'-'+addressArray[i].UA_zip+', '+addressArray[i].country_name+'.<br>Phone: '+addressArray[i].UA_phone;
      addressHTML += '</div></div>';
      addressHTML += '';
      addressHTML += '<div class="addressCheckin col-md-6 pull-right text-right">';
      addressHTML += '<label class="checkbox-inline">';
      addressHTML += '<input type="radio" id="inlineCheckbox1" name="shipping" value="'+addressArray[i].UA_id+'"> Delivery';
      addressHTML += '</label>';
      addressHTML += '<label class="checkbox-inline">';
      addressHTML += '<input type="radio" id="inlineCheckbox2" name="billing" value="'+addressArray[i].UA_id+'"> Billing';
      addressHTML += '</label>';
      addressHTML += '</div>';
      addressHTML += '</div>';
      addressHTML += '</div>';
    }
 } else {
   addressHTML += '<div class="panel panel-default">';
   addressHTML += '<div class="panel-body">';
   addressHTML += '<h5>No Address found. Click "Add New" to add new address.</h5>';
   addressHTML += '</div>';
   addressHTML += '</div>';
 }
 
 addressHTML += '<div class="row clearfix">'; 
 addressHTML += '<div class="col-lg-12 clearfix">'; 
 addressHTML += '<a class="btn btn-site pull-left addNewAdderss" id="AddNewAddressButton" > <i class="fa fa-plus"></i> Add New </a>'; 
 addressHTML += '<button type="submit" class="btn btn-site pull-right" name="submit">Next <i class="fa fa-long-arrow-right"></i></button>'; 
 addressHTML += '</div>'; 
 addressHTML += '</div>';
  $('#showAllAddresses').html(addressHTML);
//  $('#miniCartTotalPrice').text(' Total : '+currencySign+' '+totalPrice.toFixed(2));
//  $('#cartTotalPrice').text(currencySign+' '+totalPrice.toFixed(2));
}





function addNewAdd(){
  
  var Title = $("#inputTitle").val();
  var LastName = $("#inputLname").val();
  var Phone = $("#inputPhone").val();
  var Address = $("#inputAddress").val();
  var Zip = $("#inputZip").val();
  var Area = $("#selectArea option:selected").val();
  var City = $("#inputCity").val();
  var Country = $("#inputCountry").val();
  var error = 0;
  
  
  if(Title == '' || Title == null){
//    $('#title').addClass("has-error has-feedback");
    errorMessage("Addrees name is required");
    error = 1;
  } else {
//    $('#title').addClass("has-success has-feedback");
  }
  
  if(Phone == '' || Phone == null){
//    $('#phone').addClass("has-error has-feedback");
    error = 1;
    errorMessage("Phone is required");
  } else {
//    $('#phone').addClass("has-success has-feedback");
  }
  
  if(Address == '' || Address == null){
//    $('#address').addClass("has-error has-feedback");
    error = 1;
    errorMessage("Address is required");
  } else {
//    $('#address').addClass("has-success has-feedback");
  }
  
  if(Zip == '' || Zip == null){
//    $('#zip').addClass("has-error has-feedback");
/* Not required 
 *     error = 1;
    errorMessage("Zip/Postal Code is required");
 * */

  } else {
//    $('#zip').addClass("has-success has-feedback");
  }
  
  if(Area == '' || Area == null){
//    $('#area').addClass("has-error has-feedback");
    error = 1;
    errorMessage("Area is required");
  } else {
//    $('#area').addClass("has-success has-feedback");
  }
  
  
  
  if(error == 0){
    $.ajax({url: baseUrl + 'ajax/checkout1/Ajax.AddNewAddress.php',
      data: {Title: Title, Phone: Phone, Address: Address, Zip: Zip, Area: Area, City: City, Country: Country, Action:'AddAddress'}, //Modify this
      type: 'post',
      success: function(output) {
        //alert(output);
        var result = $.parseJSON(output);
        if(result.error == 0){
          
          successMessage(result.error_text);
          setTimeout(function() {
            $('#newAddressAddForm').slideToggle("slow");
            
            $(".addNewAdderss").click(function() {
              // alert('done');
                $('.cancelAddress').slideToggle("slow", function() {

                    // Animation complete.
                });

                $('.addNewAddressform').slideToggle("slow", function() {
                    //alert('done2');
                });
                $('.saveNewAdderss').slideToggle("slow", function() {


                });
            });
            
            $("#inputTitle").val('');
            $("#inputFname").val('');
            $("#inputMname").val('');
            $("#inputLname").val('');
            $("#inputPhone").val('');
            $("#inputAddress").val('');
            $("#inputZip").val('');
            
            
          }, 2700);
          showAllAddresses(result.AllAddress);
          
          
          
        } else {
          errorMessage(result.error_text);
          
        }
      }
    });
  }
}
