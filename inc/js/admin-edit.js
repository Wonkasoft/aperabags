( function( $ ) {
    var frame,
        metaBox,
        addImgLink,
        replaceImgLink,
        delImgLink,
        imgContainer,
        imgIdInput;

    if ( 'undefined' !== typeof inlineEditPost && null !== inlineEditPost ) {
        $( document ).on( 'DOMContentLoaded reloaded', function( e ) {
            e.stopImmediatePropagation();
            
            $( '.column-featured > a' ).remove( 'click', save_option );
            $( '.column-featured > a' ).on( 'click', save_option );
            $( '[data-toggle="tooltip"]' ).tooltip({
                container: 'body'
            });
        });
        
        var $wp_inline_edit = inlineEditPost.edit;

        inlineEditPost.edit = function( id ) {
            
            // "call" the original WP edit function.
            // we don't want to leave WordPress hanging.
            $wp_inline_edit.apply( this, arguments );
            
            // now we take care of our business.

            // get the post ID.
            var $post_id = 0;
            if ( typeof( id ) == 'object' ) {
                $post_id = parseInt( this.getId( id ) );
            }
            
            if ( $post_id > 0 ) {
                // define the edit row.
                var $edit_row = $( '#edit-' + $post_id );
                var $post_row = $( '#post-' + $post_id );

                // get the data.
                var $featured = $( '.column-featured>a[data]', $post_row ).attr('data');
                
                // populate the data.
                if ( 'false' === $featured && $( 'input[name="testimonial_featured"]:checked', $edit_row )[0] ) {
                    $( 'input[name="testimonial_featured"]', $edit_row )[0].removeAttribute( 'checked' );
                } else {
                    if ( 'checked' === $featured ) {
                        $( 'input[name="testimonial_featured"]', $edit_row )[0].setAttribute( 'checked', $featured );
                    }
                }
            }
        };
    }
        
    function save_option( e ) {
        e.stopImmediatePropagation();
        var $post_id = $( this ).attr( 'post-id' );
        var $post_row = $( '#post-' + $post_id );
        
        inlineEditPost.edit( this );
        // get the data.
        var $edit_row = $( '#edit-' + $post_id );
        var $featured = $( '.column-featured>a[data]', $post_row ).attr('data');
        $edit_row.find( '> td' ).addClass( 'processing' );
        $( '<div class="d-flex justify-content-center custom-spinner"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>' ).prependTo( $edit_row.find( '> td.processing' ) );
        // populate the data.
        if ( 'false' === $featured && ! $( 'input[name="testimonial_featured"]:checked', $edit_row )[0] ) {
            $( 'input[name="testimonial_featured"]', $edit_row )[0].setAttribute( 'checked', 'checked' );
            inlineEditPost.save( $edit_row );
        } else {
            if ( 'checked' === $featured ) {
                $( 'input[name="testimonial_featured"]', $edit_row )[0].removeAttribute( 'checked' );
                inlineEditPost.save( $edit_row );
            }
        }

        setTimeout( function() {
            $( document ).trigger( 'reloaded' );
        },1000 );
    }

    if ( true ) {
        $( document ).on( 'DOMContentLoaded', function( e ) {
            // Set all variables to be used in scope.
            metaBox = $( '#featured-product-image.postbox' ); // Your meta box id here.
            addImgLink = metaBox.find('.editor-product-featured-image__toggle');
            replaceImgLink = metaBox.find('.components-button.is-secondary');
            delImgLink = metaBox.find( '.components-button.is-link.is-destructive');
            imgContainer = metaBox.find( '.editor-product-featured-image__container');
            imgIdInput = metaBox.find( '.featured-product-img-id' );
            featured_product_img_js();
        });
    }

    function featured_product_img_js() {
          // ADD IMAGE LINK.
          addImgLink.on( 'click', media_selection );

          // Replace IMAGE LINK.
          replaceImgLink.on( 'click', media_selection );
          
          
          // DELETE IMAGE LINK.
          delImgLink.on( 'click', function( event ){

            event.preventDefault();

            // Clear out the preview image.
            imgContainer.find( 'img' ).remove();

            // Un-hide the add image link.
            addImgLink.removeClass( 'd-none' );

            // Hide the replace image button.
            replaceImgLink.addClass( 'd-none' );

            // Hide the delete image link.
            delImgLink.addClass( 'd-none' );

            // Delete the image id from the hidden input.
            imgIdInput.val( '' );

          });
      }

      function media_selection( event ) {
                  
          event.preventDefault();
          
          // If the media frame already exists, reopen it.
          if ( frame ) {
            frame.open();
            return;
          }
          
          // Create a new media frame.
          frame = wp.media({
            title: 'Select or Upload Media to display as featured product on front page.',
            button: {
              text: 'Use this media'
            },
            multiple: false  // Set to true to allow multiple files to be selected.
          });

          
          // When an image is selected in the media frame...
          frame.on( 'select', function() {

            if ( imgContainer.find( 'img' ).length ) {
                imgContainer.find( 'img' ).remove();
            }
            
            // Get media attachment details from the frame state.
            var attachment = frame.state().get('selection').first().toJSON();

            // Send the attachment URL to our custom image input field.
            imgContainer.append( '<img src="'+attachment.url+'" alt="' + attachment.title + '" style="max-width:100%;"/>' );

            // Send the attachment id to our hidden input.
            imgIdInput.val( attachment.id );

            // Hide the add image link.
            addImgLink.addClass( 'd-none' );

            // Unhide the replace image button.
            replaceImgLink.removeClass( 'd-none' );

            // Unhide the remove image link.
            delImgLink.removeClass( 'd-none' );
          });

          // Finally, open the modal on click.
          frame.open();
        }
    
})( jQuery );
