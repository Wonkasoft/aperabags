( function( $ ) 
{
  window.onload = function() 
  {
    if ( document.querySelector( 'div.gform_confirmation_wrapper' ) ) 
    {
      xhr = new XMLHttpRequest();
      var confirmation_wrapper = document.querySelector( 'div.gform_confirmation_wrapper' );
      var confirmation_msg = document.querySelector( 'div.gform_confirmation_message' );
      confirmation_msg.remove();
      var login_container = document.createElement( 'DIV' );
      login_container.setAttribute('id', 'registration-login-container');
      login_container.setAttribute('class', 'login-container');
      var html = '<div class="card">';
          html += '<div class="card-header text-center">';
          html += '<p class="to-complete-message">';
          html += 'You are not logged in.';
          html += '</p>';
          html += '<p class="to-complete-message">';
          html += 'Yet your email you used for registration is on an account with aperabags.com.';
          html += '</p>';
          html += '<p class="to-complete-message">';
          html += 'Please login to complete your registration!';
          html += '</p>';
          html += '</div>';
          html += '<form id="registration-login" class="inline-form login-form">';
          html += '<div class="card-body">';
          html += '<div class="input-group">';
          html += '<input type="text" id="user_name" name="user_name" class="form-control" placeholder="User Name*" />';
          html += '</div>';
          html += '<div class="input-group">';
          html += '<input type="password" id="user_password" name="user_password" class="form-control" placeholder="Enter your password*" />';
          html += '</div>';
          html += '</div>';
          html += '<div class="card-footer"><button id="login_btn" type="submit" class="wonka-btn">Login</button></div>';
          html += '</form>';
          html += '</div>';
      login_container.innerHTML = html;
      confirmation_wrapper.appendChild( login_container );
      var login_btn = document.querySelector( '#login_btn' );
      var login_card = login_container.querySelector( '.card' );
      var login_card_body = login_container.querySelector( '.card-body' );
      var response_msg = document.createElement( 'DIV' );
      var loading_box = document.createElement( 'DIV' );
      var loading_img_box = document.createElement( 'DIV' );
      var loading_img = document.createElement( 'IMG' );
      loading_box.setAttribute( 'id', 'loading_box');
      loading_box.setAttribute( 'class', 'pre-load');
      loading_img.setAttribute( 'id', 'loading_img');
      loading_img.setAttribute( 'src', REG_LINKS.loader_gif );
      login_card.appendChild( loading_box );
      loading_box.appendChild( loading_img_box );
      loading_img_box.appendChild( loading_img );
      setTimeout( function() 
        {
          loading_box.classList.remove( 'pre-load' );

        }, 100 );

      login_btn.onclick = function ( e ) 
      {
        e.preventDefault();
        loading_box.classList.add( 'loading');
        var action = 'registration_ajax_login';
        var data = {
          'user_name': document.querySelector( '#user_name' ).value,
          'user_password': document.querySelector( '#user_password' ).value,
        };

        xhr.onreadystatechange = function() {

          if ( this.readyState == 4 && this.status == 200 ) 
          {
            response_msg.innerHTML = '';
            var response = JSON.parse( this.responseText );
            console.log( response );
            if ( false === response.success ) 
            {
              loading_box.classList.remove( 'loading');
              var error_msgs = '';
              var errors_to_parse = response.data.user_info.errors;
              console.log(errors_to_parse);
              error_msgs = '<p>';
              error_msgs += response.data.message;
              error_msgs += '</p>';
              for ( var error in errors_to_parse ) {
                  error_msgs += '<p>';
                  error_msgs += errors_to_parse[error];
                  error_msgs += '</p>';
              }
              response_msg.innerHTML = error_msgs;
              login_card_body.appendChild( response_msg );
            }

            if ( true === response.success ) 
            {
              loading_box.innerHTML = '';
              var success_msgs = '';
              if ( response.data.refersion_response.errors !== '' ) 
              {
                for ( var refersion_error in response.data.refersion_response.errors ) {
                  success_msgs = '<p>';
                  success_msgs += response.data.refersion_response.errors[refersion_error];
                  success_msgs += '</p>';
                }
                success_msgs += '<p>';
                success_msgs += 'We will look into this issue and contact you soon.';
                success_msgs += '</p>';
                response_msg.innerHTML = success_msgs;
                loading_box.appendChild( response_msg );
              }
              else
              {
                success_msgs = '<p>';
                success_msgs += response.data.message;
                success_msgs += '</p>';
                success_msgs += '<p>';
                success_msgs += confirmation_msg.innerText;
                success_msgs += '</p>';
                response_msg.innerHTML = success_msgs;
                loading_box.appendChild( response_msg );
              }
            }
          }
        };
        xhr.open('POST', wonkasoft_request.ajax );
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send( "action=" + action + '&data=' +JSON.stringify( data ) + "&security=" + wonkasoft_request.security );
      };
    }
  };
})( jQuery );