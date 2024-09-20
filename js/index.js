const images = document.querySelectorAll('.slider-image');
let currentIndex = 0;

function showNextImage() {
    images[currentIndex].classList.remove('active');
    currentIndex = (currentIndex + 1) % images.length;
    images[currentIndex].classList.add('active');
}

// Initially show the first image
images[currentIndex].classList.add('active');

// Slide every 5 seconds
setInterval(showNextImage, 5000);
