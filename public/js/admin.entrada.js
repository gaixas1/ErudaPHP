$j = $;

$j(document).ready(function() {
	$j('a.emotico').live('click', function(e){
            e.preventDefault();
            $j('#text').appendVal($j(this).attr('href'));
	});
        
	$j('a#lastmanga').live('click', function(e){
            e.preventDefault();
            $j.get('/ajax/lastmanga/', function(data) {
                $j('#text').appendVal('[cap]'+data+'[/cap]');
            }).error(function() { alert("Algo ha fallado"); });
	});
	$j('a#lastanime').live('click', function(e){
            e.preventDefault();
            $j.get('/ajax/lastanime/', function(data) {
                $j('#text').appendVal('[ani]'+data+'[/ani]');
            }).error(function() { alert("Algo ha fallado"); });
	});
        
        
        
});

$j.fn.appendVal = function(txt) {
   return this.each(function(){
       this.value += txt;
   });
};