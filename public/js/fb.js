
window.fbAsyncInit = function() {
        FB.init({
          appId      : '349147981823451',
          status     : true, 
          cookie     : true,
          xfbml      : true,
          oauth      : true
        });
        
        FB.getLoginStatus(function(response) {
            if (response.status=="connected") {
                FB.Event.subscribe('auth.logout', function(response) {
                    window.location.reload();
                });
            }else{
                FB.Event.subscribe('auth.login', function(response) {
                    window.location.reload();
                });
            }
        }, true);
      };

      (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));

$j(document).ready(function() {
	$j('a.uexit').live('click', function(){
            FB.logout();
	});

});
