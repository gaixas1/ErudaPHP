$j = $;


$j(document).ready(function() {
   	setTimeout("return2Blog()",1000) ;
});

function return2Blog(){
    window.location.href= $j('a.link').attr('href');
}
