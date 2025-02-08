document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('[data-carousel="slide"]');
    const items = carousel.querySelectorAll('[data-carousel-item]');
    const prevButton = carousel.querySelector('[data-carousel-prev]');
    const nextButton = carousel.querySelector('[data-carousel-next]');
    const indicators = carousel.querySelectorAll(
        '[data-carousel-slide-to]'
    );
    let currentIndex = 0;

    function showImage(index) {
        items[currentIndex].classList.remove('active');
        indicators[currentIndex].classList.remove('active');
        currentIndex = (index + items.length) % items.length;
        items[currentIndex].classList.add('active');
        indicators[currentIndex].classList.add('active');
        items.forEach((item, idx) => {
            item.style.transform = `translateX(${(idx - currentIndex) * 100}%)`;
        });
    }

    function showNextImage() {
        showImage(currentIndex + 1);
    }

    function showPrevImage() {
        showImage(currentIndex - 1);
    }

    items.forEach((item, index) => {
        item.classList.add('carousel-item');
        item.style.transform = `translateX(${index * 100}%)`;
        if (index === 0) item.classList.add('active');
    });

    nextButton.addEventListener('click', showNextImage);
    prevButton.addEventListener('click', showPrevImage);
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => showImage(index));
    });

    setInterval(showNextImage, 5000); // Interval duration set to 5000ms (5 seconds)
});