jQuery(function ($) {
	$('#confirm2-dialog input.confirm2, #confirm2-dialog a.confirm2').click(function (e) {
		e.preventDefault();

		// example of calling the confirm2 function
		// you must use a callback function to perform the "yes" action
		confirm2("Se dispone a eliminar de forma permanente este Tercero", function () {
			window.location.href = 'http://www.google.es';
		});
	});
});

function confirm2(message, callback) {
	$('#confirm2').modal({
		closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
		position: ["30%",],
		overlayId: 'confirm2-overlay',
		containerId: 'confirm2-container', 
		onShow: function (dialog) {
			var modal = this;

			$('.message', dialog.data[0]).append(message);

			// if the user clicks "yes"
			$('.yes', dialog.data[0]).click(function () {
				// call the callback
				if ($.isFunction(callback)) {
					callback.apply();
				}
				// close the dialog
				modal.close(); // or $.modal.close();
			});
		}
	});
}