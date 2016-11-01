window.fbAsyncInit = function() {
    FB.init({
        appId : '206748579705827',
        xfbml : true,
        version : 'v2.5'
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) { return; }
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function gallery_files() {
    if(window.File && window.FileList && window.FileReader)
    {
        var filesInput = document.getElementById("files");
        if (filesInput) {
            filesInput.addEventListener("change", function(event){
                var files = event.target.files; //FileList object
                var output = document.getElementById("result");
                for(var i = 0; i< files.length; i++)
                {
                    var file = files[i];
                    //Only pics
                    if(!file.type.match('image'))
                        continue;
                    var picReader = new FileReader();
                    picReader.addEventListener("load",function(event){
                        var picFile = event.target;
                        var div = document.createElement("div");
                        div.className += div.className + 'thumbnail';
                        div.innerHTML = "<img src='" + picFile.result + "'" +
                        "title='" + picFile.name + "'/>";
                        output.insertBefore(div,null);
                    });
                    //Read the image
                    picReader.readAsDataURL(file);
                }
            });
        }

    }    
}

function fb_login() {
    FB.login(function(response) {

        if (response.authResponse) {
            console.log('Welcome! Fetching your information....');
            access_token = response.authResponse.accessToken;
            user_id = response.authResponse.userID;

            FB.api('/me', {fields: 'first_name, last_name, email, picture'}, function(response) {
                console.log(JSON.stringify(response));
                $('#fName').val(response.first_name); 
                $('#lName').val(response.last_name);
                $('#userEmail').val(response.email);
                //$('#hometown').val(response.hometown.name);
                $('#output').attr('src', "//graph.facebook.com/" + response.id + "/picture?type=large");
                $('#urlContent').attr('value', "//graph.facebook.com/" + response.id + "/picture?type=large");
                //checks if email already exists
                processRequest("register_ajax_call.php?hasExisting=true&hasEmail=" + $('#userEmail').val());
            });

        } else {
            //user hits cancel button
            console.log('User cancelled login or did not fully authorize');
        }
    }, {scope: 'public_profile, email'});

}

$(function() {
    $('#facebookLogin').on('click', function() {
        fb_login();
    });    

});