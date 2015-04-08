
            //alert(stickyNavTop);
	$('.footer').bind('inview', function (event, visible) {
							if (visible == true) {
								
							 $('.bottom-nav').addClass('stickyF'); 
								
				}
				
				else{
					
						 $('.bottom-nav').removeClass('stickyF'); 
					}
		  	});
			
		
			
			 $(".fclose").click(function() {
        $('.bottom-nav').toggleClass("stickyF", function() { });
		$('.bottom-nav').toggleClass("isclose", function() { });
    });
					




// end top footer


//function converting integer to float number
function intToFloat(integer) {
    var twoPlacedFloat = parseFloat(integer).toFixed(2);
    return twoPlacedFloat;
}


$(document).ready(function() {

$('#edit_date').datepicker({
    format: 'yyyy-mm-dd'
   });




    $(".addAddressLink").click(function() {
        $('.addressBox').slideToggle("slow", function() {
            // Animation complete.
        });
    });
    $("#addNewAddressCancel").click(function() {
        $('#newAddressAddForm').slideToggle("slow", function() {
            // Animation complete.
        });
    });


    $(".addNewAdderss").click(function() {
        //alert('done');
        $('.cancelAddress').slideToggle("slow", function() {

            // Animation complete.
        });

        $('.addNewAddressform').slideToggle("slow", function() {
            //alert('done2');
            // Animation complete.
        });
//        $('.addNewAdderss').slideToggle("slow", function() {
//            // Animation complete.
//        });

        $('.saveNewAdderss').slideToggle("slow", function() {
            // Animation complete.


        });
    });


//    $(".cancelAddress").click(function() {
//        $('.addNewAddressform').slideToggle("slow", function() {
//            // Animation complete.
//        });
//    });

    $("a.btncart").click(function() {
        $(this).addClass("active");
    });

//    $('.btnwishlist').click(function() {
//        $(this).addClass('active');
//    });




    $('a.scrollto, a#arrow_down').click(function(e) {
        $('html,body').scrollTo(this.hash, this.hash);
        e.preventDefault();
    });

    $(window).bind('scroll', function(e) {
        parallaxScroll();
    });

    function parallaxScroll() {
        var scrolledY = $(window).scrollTop();
        $('.slider1').css('background-position', 'center -' + ((scrolledY * 0.2)) + 'px');
        $('.slider2').css('background-position', 'center -' + ((scrolledY * 0.2)) + 'px');
        $('.slider3').css('background-position', 'center -' + ((scrolledY * 0.2)) + 'px');
    }


/*category lazy loading*/
 jQuery('.hide_category').bind('inview', function(event, visible) {
        if (visible == true) {

          
           /* category  loading  */
            var numItems = $('.hide_category').length;

            if (numItems > 0) {
                //    alert(numItems);
                // alert($('.hide_category').eq(0).html());
                $('.hide_category').eq(0).after('<span class="loader"><span>');
                $('.hide_category').eq(0).find("img.lazy2").each(function(index) {
                    var attr = $(this).attr('data-original');
                    if (typeof attr !== 'undefined' && attr !== false) {

                        $(this).attr('src', attr);
                    }

                });


                $("span.loader").remove();
                $('.hide_category').eq(0).removeClass('hide_category');

            }
             /*// category  loading  */

        } 
    });

/*//category lazy loading*/

/*Product lazy loading*/
 jQuery('.hideProduct').bind('inview', function(event, visible) {
        if (visible == true) {

          
            /* prodcut loading  */
            var LazyProductCounter = $("#prductMainCOntainer .hideProduct").length;
            
            if (LazyProductCounter > 0) {
               $("#prductMainCOntainer .hideProduct").eq(0).parent().after('<span class="loader"><span>');
                 
                $('#prductMainCOntainer').find(".hideProduct").each(function(index) {
                 
                    var attr = $(this).find("img.lazy2").attr('data-original');
                    if (typeof attr !== 'undefined' && attr !== false) {

                        $(this).find("img.lazy2").attr('src', attr);
                        $(this).removeClass('hideProduct');
                    }
                    if(index >=1){
                        return false;
                    }
                });
                  
            }
             $("#prductMainCOntainer").find('.loader').remove();
           console.log(LazyProductCounter);
         /*// prodcut loading  */

        } 
    });

/*//Product lazy loading*/


    // query viewport cutoms animation  // 10/23/2013@tanim

    jQuery('.footer').bind('inview', function(event, visible) {
        if (visible == true) {
            jQuery('.footerParallex').addClass("active");
          

        } else {
            jQuery('.footerParallex').removeClass("active");
        }
    });

    //  Footer address bar // start//		

    $('.hideBox').click(function(e) {
        e.preventDefault();
        $(this).closest('div').addClass('hide').removeClass('show');
    });




//    $('.btnwishlist').click(function(e) {
//        e.preventDefault();
//        $(this).addClass('active');
//    });
});



// onLoad cutoms animation  // 10/23/2013 @tanim
window.onload = (function() {
    $(window).scroll(function() {
        if ($(window).scrollTop() > 86) {
            // Display something
            $('#header').addClass('stuck');
        }
        else {
            // Display something
            $('#header').removeClass('stuck');
        }

    });



});// Ready End 


$(".modal-body-cart").mCustomScrollbar({
    advanced: {
        updateOnContentResize: true
    },
    theme: "dark"
});


$(function() {

    // make code pretty
    window.prettyPrint && prettyPrint()

    $(document).on('click', '.megamenu .dropdown-menu', function(e) {
        e.stopPropagation()
    })

})



$('.cartProductDelete').tooltip();

$('.tooltipg').tooltip();
$('#example').popover('hide');
$('.btnpophover').popover('show')

			