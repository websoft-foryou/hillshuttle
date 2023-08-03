// JavaScript Document
$('input#name-submit').on('click', function() {	
	
	var name = $('input#name').val();
	
	if($.trim(name) != ''){
		$.post('https://remote.hillshuttle.com.au/ajax/content.php', {name: name}, function(data) {			
		$('div#name-data').text(data);
		});
	}
		
});