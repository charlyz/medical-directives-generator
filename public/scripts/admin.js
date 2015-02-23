

function addSerieDomElement()
{

	
	if(currentIndexSerie == 0)
	{
		after = $('#'+sPreview+'synopsis-element');
	}else
	{
		after = $('#'+sPreview+'synopsis'+currentIndexSerie+'-element');
	}

	after.after(
			'<dt id="'+sPreview+'season'+currentIndexSerie+'-label"><label for="'+sPreview+'season['+currentIndexSerie+']" class="optional">Saison:</label></dt>'+
			'<dd id="'+sPreview+'season'+currentIndexSerie+'-element">'+
			'<input type="text" name="'+sPreview+'season['+currentIndexSerie+']" id="'+sPreview+'season['+currentIndexSerie+']" value="" /></dd>'+
			'<dt id="'+sPreview+'episode'+currentIndexSerie+'-label"><label for="'+sPreview+'episodes['+currentIndexSerie+']" class="optional">Episode:</label></dt>'+
			'<dd id="'+sPreview+'episode'+currentIndexSerie+'-element">'+
			'<input type="text" name="'+sPreview+'episode['+currentIndexSerie+']" id="'+sPreview+'episode['+currentIndexSerie+']" value="" /></dd>'+
			'<dt id="'+sPreview+'title'+currentIndexSerie+'-label"><label for="'+sPreview+'title['+currentIndexSerie+']" class="optional">Titre de l\'épisode:</label></dt>'+
			'<dd id="'+sPreview+'title'+currentIndexSerie+'-element">'+
			'<input type="text" name="'+sPreview+'title['+currentIndexSerie+']" id="'+sPreview+'title['+currentIndexSerie+']" value="" /></dd>'+
			'<dt id="'+sPreview+'synopsis'+currentIndexSerie+'-label"><label for="'+sPreview+'synopsis['+currentIndexSerie+']" class="optional">Synopsis de l\'épisode:</label></dt>'+
			'<dd id="'+sPreview+'synopsis'+currentIndexSerie+'-element">'+
			'<textarea name="'+sPreview+'synopsis['+currentIndexSerie+']" id="'+sPreview+'synopsis['+currentIndexSerie+']" rows="5" cols="50"></textarea></dd>');

	currentIndexSerie++;
	

}