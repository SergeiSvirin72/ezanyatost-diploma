var slideIndex = 1;
showSlides(slideIndex);

var timerId = setInterval(function tick(){
	slideIndex++; 
	showSlides(slideIndex);
}, 5000);

function plusSlides(n) {
	clearInterval(timerId);
	
	showSlides(slideIndex += n);
	
	timerId = setInterval(function tick(){
		slideIndex++; 
		showSlides(slideIndex);
	}, 5000);
}

function currentSlide(n) {
	clearInterval(timerId);
	
	showSlides(slideIndex = n);
	
	timerId = setInterval(function tick(){
		slideIndex++; 
		showSlides(slideIndex);
	}, 5000);
}

function showSlides(n) {
	var slides = document.getElementsByClassName("carousel-slide");
	var dots = document.getElementsByClassName("carousel-dot");
	var i;
	
	if (n > slides.length) {slideIndex = 1} 
	if (n < 1) {slideIndex = slides.length}
	
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none"; 
	}
	for (i = 0; i < dots.length; i++) {
		dots[i].className = dots[i].className.replace(" dot-active", "");
	}
	slides[slideIndex-1].style.display = "block"; 
	dots[slideIndex-1].className += " dot-active";
}
