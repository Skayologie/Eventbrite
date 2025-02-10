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






// Add this before the existing script code
const imageInput = document.getElementById('imageInput');
const uploadArea = document.getElementById('uploadArea');
const imagePreview = document.getElementById('imagePreview');
const uploadedImage = document.getElementById('uploadedImage');
const removeImage = document.getElementById('removeImage');

uploadArea.addEventListener('click', () => {
    imageInput.click();
});

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('border-orange-500');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('border-orange-500');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-orange-500');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        handleImage(file);
    }
});

imageInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        handleImage(file);
    }
});

removeImage.addEventListener('click', () => {
    imageInput.value = '';
    imagePreview.classList.add('hidden');
    uploadArea.classList.remove('hidden');
});

function handleImage(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        uploadedImage.src = e.target.result;
        imagePreview.classList.remove('hidden');
        uploadArea.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

// Venue type toggle functionality
const venueButtons = document.querySelectorAll('.venue-type-btn');
const venueFields = document.getElementById('venue-fields');
const onlineFields = document.getElementById('online-fields');

venueButtons.forEach((button) => {
    button.addEventListener('click', () => {
        // Reset all buttons
        venueButtons.forEach((btn) => {
            btn.classList.remove('bg-orange-500', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });

        // Style active button
        button.classList.remove('bg-gray-100', 'text-gray-700');
        button.classList.add('bg-orange-500', 'text-white');

        // Show/hide appropriate fields
        if (button.dataset.type === 'venue') {
            venueFields.classList.remove('hidden');
            onlineFields.classList.add('hidden');
        } else {
            venueFields.classList.add('hidden');
            onlineFields.classList.remove('hidden');
        }
    });
});

// Toggle functionality for free tickets
const freeTicketCheckbox = document.querySelector(
    'input[type="checkbox"]'
);
const priceInput = document.querySelector(
    'input[type="number"][placeholder="Price"]'
);
freeTicketCheckbox.addEventListener('change', (e) => {
    priceInput.disabled = e.target.checked;
    if (e.target.checked) {
        priceInput.value = '';
    }
});

// Description character counter and progress circle
const description = document.getElementById('description');
const wordCount = document.getElementById('wordCount');
const progressCircle = document.getElementById('progressCircle');
const maxLength = 200;

description.addEventListener('input', updateCounter);

function updateCounter() {
    const length = description.value.length;
    wordCount.textContent = length;

    // Update progress circle
    const progress = (length / maxLength) * 100;
    const dashOffset = 100 - progress;
    progressCircle.style.strokeDashoffset = dashOffset;

    // Update colors based on length
    if (length > maxLength * 0.9) {
        progressCircle.style.stroke = '#ef4444'; // red
    } else if (length > maxLength * 0.7) {
        progressCircle.style.stroke = '#f97316'; // orange
    } else {
        progressCircle.style.stroke = '#22c55e'; // green
    }
}


// event single page

      // Ticket quantity controls
      const decreaseBtn = document.getElementById('decreaseTickets');
      const increaseBtn = document.getElementById('increaseTickets');
      const quantityInput = document.querySelector('input[type="number"]');

      decreaseBtn.addEventListener('click', () => {
        if (quantityInput.value > 1) {
          quantityInput.value = parseInt(quantityInput.value) - 1;
        }
      });

      increaseBtn.addEventListener('click', () => {
        if (quantityInput.value < 10) {
          quantityInput.value = parseInt(quantityInput.value) + 1;
        }
      });
