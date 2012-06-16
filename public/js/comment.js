$j = $;

$j(document).ready(function() {
	$j('a.emotico').live('click', function(e){
            e.preventDefault();
            $j('#comTxt').appendVal($j(this).attr('href'));
	});
        
        
	$j('#comPrevia').live('click', function(e){
            e.preventDefault();
            var txt = $('#comTxt').val();
            $.post('/ajax/previewcomment/', { comment: txt }, function(data) {
                $('#vistaPrevia').html('<div class="text">'+data+'</div>');
            });
	});
        
        
        
});

$j.fn.appendVal = function(txt) {
   return this.each(function(){
       this.value += txt;
   });
};