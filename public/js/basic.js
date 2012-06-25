$j = $;


var e = ("abbr,article,aside,audio,canvas,datalist,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video").split(',');
for (var i=0; i<e.length; i++) {
	document.createElement(e[i]);
}

array_imagen = new Array(5);
array_imagen[0] = new Image(800,180);
array_imagen[0].src = "/img/b0.jpg" ;
array_imagen[1] = new Image(800,180) ;
array_imagen[1].src = "/img/b1.jpg" ;
array_imagen[2] = new Image(800,180) ;
array_imagen[2].src = "/img/b2.jpg" ;
array_imagen[3] = new Image(800,180) ;
array_imagen[3].src = "/img/b3.jpg" ;
array_imagen[4] = new Image(800,180) ;
array_imagen[4].src = "/img/b0.jpg" ;

contadorIMG = 1 ;
contadorAviso = 3 ;

function rotarBaner(){ 
	$j('#baner img').attr('src', array_imagen[contadorIMG].src);
   	contadorIMG = (contadorIMG+1) % 5;
   	setTimeout("rotarBaner()",4000) ;
}

function rotarAviso(){ 
	$j('#novedades span').addClass('none');
   	contadorAviso = (contadorAviso) % 3 +1;
	$j('#aviso_'+contadorAviso).removeClass('none');
   	setTimeout("rotarAviso()",4000) ;
}



$j(document).ready(function() {
	$j('a.jlist_img_mini, a.jlist_img_max').live('mouseover', function(){
		window.status='Click to visit J-List now'; 
		return true;
	});
        
	$j('a.jlist_img_mini, a.jlist_img_max').live('mouseout', function(){
		window.status='';
		return true;
	});
        
	$j('#nav_archivos').live('change', function(){
		window.location = $j(this).val();
	});

   	setTimeout("rotarBaner()",2000) ;
   	rotarAviso();

});
