jQuery(document).ready(function() {
  jQuery('.modal').modal(); // init modal.

  jQuery('.archive-single-product-content').hover(
    function() {
      jQuery(this).find('.fast-view-chip').css( 'visibility', 'visible' );
    }, function() {
      jQuery(this).find('.fast-view-chip').css( 'visibility', 'hidden' );
    }
  );

  jQuery('.fast-view-chip').click(
    function() {
      // setup modal info.
      let productTitle = jQuery(this).attr('modal-title')
      console.log(productTitle)

      let productTitleInModal = jQuery('#modal1').find('.product-title')
      productTitleInModal.text(productTitle)
      console.log('productTitleInModal: ', productTitleInModal)
      console.log('and text: ', productTitleInModal.text())

      // then, show modal.
      jQuery('#modal1').modal('open');
    }
  );
});
