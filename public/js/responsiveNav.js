document.addEventListener("DOMContentLoaded", function() {
	var bars = document.querySelector(".header-bars");
	bars.addEventListener("click", function() {
		var menu = document.querySelector(".header-navigation");
		menu.classList.toggle("nav-open");
	});
});