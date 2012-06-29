$j = $;


var e = ("abbr,article,aside,audio,canvas,datalist,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video").split(',');
for (var i=0; i<e.length; i++) {
	document.createElement(e[i]);
}

contador = 1 ;

$j(document).ready(function() {
   	setTimeout("rotar()",1000) ;
});

function rotar(){ 
    switch(contador){
        case 0: $('#ascgen-image pre span').css('color','#111111'); break;
        case 1: $('#ascgen-image pre span').css('color','#222222'); break;
        case 2: $('#ascgen-image pre span').css('color','#444444'); break;
        case 3: $('#ascgen-image pre span').css('color','#888888'); break;
        case 4: $('#ascgen-image pre span').css('color','#cccccc'); break;
        case 5: $('#ascgen-image pre span').css('color','#444444'); break;
    }
    contador = (contador+1) % 6;
    setTimeout("rotar()",1000) ;
}