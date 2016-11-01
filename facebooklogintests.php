<!DOCTYPE html>
<html>
  <head>
    <title></title>
  </head>
  <body>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '206751786372173',
          xfbml      : true,
          version    : 'v2.5'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }

      function fb_login(){
          FB.login(function(response) {

              if (response.authResponse) {
                  console.log('Welcome!  Fetching your information.... ');
                  //console.log(response); // dump complete info
                  access_token = response.authResponse.accessToken; //get access token
                  user_id = response.authResponse.userID; //get FB UID

                  FB.api('/me', {fields: 'first_name, last_name, email, hometown'}, function(response) {
                      console.log(JSON.stringify(response));
                  });

                  FB.api('/me', {fields: 'first_name, last_name, email,hometown'},function(response) {
                      user_email = response.email; //get user email
                // you can store this data into your database            
                      console.log(user_email);
                      console.log(response.hometown.name); 
                  });

              } else {
                  //user hit cancel button
                  console.log('User cancelled login or did not fully authorize.');

              }
          }, {
              scope: 'public_profile,email,user_hometown'
          });
      }      
    </script>

    <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="true"></div>

    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();" style="">
    </fb:login-button> 

    <a href="#" onclick="fb_login();">connect</a>   

  </body>
</html>