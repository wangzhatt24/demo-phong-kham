(function ($) {
  'use strict';

  var init = function(){
    // variation form
    if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
      $( '.variations_form' ).each( function() {
        $.fn.wc_variation_form && $( this ).wc_variation_form();
      });
    }

    // tab, rating
    $( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );

    // category sorting
    $( '.woocommerce-ordering' ).on( 'change', 'select.orderby', function() {
      $( this ).closest( 'form' ).submit();
    });
    
    // zoom and slider
    
    $( '.woocommerce-product-gallery' ).each( function() {
      wc_single_product_params.zoom_enabled = 1;
      wc_single_product_params.flexslider_enabled = 1;
      $.fn.wc_product_gallery && $( this ).wc_product_gallery( wc_single_product_params );
    } );

    $(document).on('click', '.product_type_variable, .product_type_grouped', function(e){
        var id = $(this).attr('data-product_id');
        e.preventDefault();
        $('#product-modal-'+id).modal();
    });

  }
  // ajax success
  $(document).on('pjax:complete', function() {
    init();
  });

  init();

})(jQuery);
