$j = $;


$j(document).ready(function() {
   	setTimeout("return2Blog()",2000) ;
});

function return2Blog(){
    window.location.href= $('a.link').attr('href');
}
