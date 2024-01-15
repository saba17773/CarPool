function apiCheckMenu() {
	return $.ajax({
		url : './groupPerrmission',
		type : 'get',
		cache : false,
		dataType : 'json'
	});
}

function loadMenu() {
	apiCheckMenu()
		.done(function(data) {
			
			$('.gen-menu').html("");
			$.each(data, function(index, val) {
				$('.gen-menu').append('<li><a href="'+val.MenuLink+'">'+val.MenuName+'</a></li>');
			});
		});
}
