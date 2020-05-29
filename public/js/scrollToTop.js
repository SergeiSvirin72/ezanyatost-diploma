document.addEventListener("DOMContentLoaded", function() {
	var top_button = document.querySelector(".footer-gototop a");
	top_button.addEventListener("click", function() {
		'use strict';
		window.scrollTo({
			behavior: 'smooth',
			top: 0
		});
	});
});
