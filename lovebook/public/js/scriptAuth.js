$(document).ready(function() {
	const notification = document.querySelector('.box-notification');
	if (notification) {
		setTimeout(() => {
			$(notification).slideUp('slow');
		}, 9000)
	}
});