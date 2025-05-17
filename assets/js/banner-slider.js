document.addEventListener('DOMContentLoaded', () => {
    console.log('Banner slider script loaded');

    const slider = document.querySelector('.banner-slider');
    const slides = document.querySelectorAll('.banner-slide');
    const dots = document.querySelectorAll('.slider-dot');
    let currentIndex = 0;
    const slideInterval = 5000; // 5 seconds per slide

    if (!slider || slides.length === 0 || dots.length === 0) {
        console.error('Slider elements not found or no slides available');
        return;
    }

    // Function to show a specific slide
    function showSlide(index) {
        // Normalize index for looping
        if (index >= slides.length) index = 0;
        if (index < 0) index = slides.length - 1;

        // Update slides
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });

        // Update dots
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });

        currentIndex = index;
        console.log(`Showing slide ${currentIndex + 1}`);
    }

    // Auto-slide function
    function autoSlide() {
        showSlide(currentIndex + 1);
    }

    // Dot click handlers
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            // Reset auto-slide timer
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(autoSlide, slideInterval);
        });
    });

    // Start auto-sliding
    let autoSlideInterval = setInterval(autoSlide, slideInterval);

    // Pause on hover
    slider.addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
        console.log('Slider paused on hover');
    });

    slider.addEventListener('mouseleave', () => {
        autoSlideInterval = setInterval(autoSlide, slideInterval);
      
    });
});