$j = $;

$j(document).ready(function() {
	$j('a.emotico').live('click', function(e){
            e.preventDefault();
            $j('#comTxt').appendVal($j(this).attr('href'));
	});
        
        
	$j('#comPrevia').live('click', function(e){
            e.preventDefault();
            var txt = $j('#comTxt').val();
            $j.post('/ajax/previewcomment/', { comment: txt }, function(data) {
                $j('#vistaPrevia').html('<div class="text">'+data+'</div>');
            }).error(function() { alert("Algo ha fallado"); });
	});
        
        
        
});

$j.fn.appendVal = function(txt) {
   return this.each(function(){
       this.value += txt;
   });
};