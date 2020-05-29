document.addEventListener("DOMContentLoaded", function() {
	var bars = document.querySelector(".navbar-bars");
	bars.addEventListener("click", function() {
		var sidebar = document.querySelector(".sidebar");
		var content = document.querySelector(".wrapper");
		sidebar.classList.toggle("sidebar-show");
		content.classList.toggle("content-show");
	});
});