$(document).ready(function() {

	$( "#buttonAjaxFilter" ).click( function(  ) {
		$( "#ajax-search-form" ).trigger('submit');
	});

	var ajaxFilterDomains = $( "#ajax-search-form" );

	ajaxFilterDomains.submit(function(event) {

		console.log( 'form submitted' )

		event.preventDefault();

		var formData = $( this ).serialize();

		$.ajax({
	      type: 'POST',
	      url: '/ajax/domain_filtering',
	      data: formData,
	      cache: false,
	      beforeSend:  function() {
	      	$( '.preload-search' ).show();
	      	$( '#ajax-filtered-domains' ).hide();
		  },
	      success: function(data){
	      	$( '.preload-search' ).hide();
	      	$( '#ajax-filtered-domains' ).show();
	        $( '#ajax-filtered-domains' ).html( data );
	      },
	      error: function(data) {

	      	$( '.preload-search' ).hide();
	      	$( '#ajax-filtered-domains' ).show();
	        sweetAlert("Oops...", data, "error");

	      }
	    });

		return false;
	});


	

	
	// add to cart buttons ( home + inner )
	$('.add-to-cart, .add-to-cart-inner').click(function(ev) {

		ev.preventDefault();

		var uri = $(this).attr('href');

		$.get( uri, function( r ) {

			swal({
				title: "Domain added to cart!",   
				text: r + "You can Checkout or Continue Shopping",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Checkout",   
				cancelButtonText: "Continue Shopping",  
				timer:2000, 
				closeOnConfirm: true,   
				closeOnCancel: true, 
				imageUrl: '/resources/assets/images/cart.png' ,
				html: true
			}, function(isConfirm) {   
				if (isConfirm) {     
					document.location.href = '/checkout';
				} 
			});

		}).fail(function(xhr, status, error) {
		    swal({ title: 'woops', text: error, type: "warning",  }); // or whatever
		});

		return false;

	});


	// remove from cart
	$('.cart-remove').click(function(ev) {
		ev.preventDefault();

		var removeUri = $(this).attr('href');

		swal({ 
			title: "Are you sure?", 
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "Yes, remove it!",
			timer:2000,   
			closeOnConfirm: false 
		}, function(){   
			document.location.href = removeUri;
		});

		return false;
	});


	$('.paypalSubmit').click(function() {
		swal({   
			title: "Redirecting you to PayPal...", 
			text: 'It takes just a few seconds.',
			timer: 10000,   
			showConfirmButton: false, 
			imageUrl: '/resources/assets/images/ajax.gif'
		});
	});

	$( '#make-offer' ).submit(function( ev ) {
		ev.preventDefault();

		var formData = $( this ).serialize();

		$.ajax({
	      type: 'post',
	      url: '/make-offer',
	      data: formData,
	      dataType: 'json',
	      success: function(data){
	        $( '.make-offer-result' ).html( data.message );
	      },
	      error: function(data) {

	        var errors = data.responseJSON;
	        errorsHtml = '<br /><div class="alert alert-danger"><ul>';

	        $.each( errors, function( key, value ) {
	            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
	        });

	        errorsHtml += '</ul></div>';
	            
	        $( '.make-offer-result' ).html( errorsHtml );

	      }
	    });

		return false;
	});
	
	$( '#make-financing' ).submit(function( ev ) {
		ev.preventDefault();

		var formData = $( this ).serialize();

		$.ajax({
	      type: 'post',
	      url: '/make-financing',
	      data: formData,
	      dataType: 'json',
	      success: function(data){
	        $( '.make-financing-result' ).html( data.message );
	      },
	      error: function(data) {

	        var errors = data.responseJSON;
	        errorsHtml = '<br /><div class="alert alert-danger"><ul>';

	        $.each( errors, function( key, value ) {
	            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
	        });

	        errorsHtml += '</ul></div>';
	            
	        $( '.make-financing-result' ).html( errorsHtml );

	      }
	    });

		return false;
	});


	//cart click action
	$('.cart_items').on('click', function (e) {
		$("#openModal").slideToggle('show');
	});

	//delete item from cart
	$('.delete_from_cart').on('click', function() {
		var cartId = $(this).children().attr('value');
		$('#cart_div_'+cartId).remove();
		$.ajax({
			type: "GET",
			url: "/cart/remove/particular-item/" + cartId,
			success: function (response) {
				if (response) {
					$('#cart_total_price').html("");
					$('#cart_total_price').append('<b>' + response.total + '</b>');
					sweetAlert("", response.data.message, response.data.message_type);
				}
			},
		});
	});

});