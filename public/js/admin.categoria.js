$j = $;

$j(document).ready(function() {
	$j('.deletecat').live('click', function(e){
            return confirm('¿Seguro que quieres eliminar la categoria?');
	});
});