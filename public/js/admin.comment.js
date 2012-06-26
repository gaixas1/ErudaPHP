$j = $;

$j(document).ready(function() {
	$j('.deletecomment').live('click', function(e){
            return confirm('¿Seguro que quieres eliminar el mensaje?');
	});
});