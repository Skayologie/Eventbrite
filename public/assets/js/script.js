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

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (e) {
        e.preventDefault(); 

        let firstName = document.getElementById("firstName").value.trim();
        let lastName = document.getElementById("lastName").value.trim();
        let email = document.getElementById("email").value.trim();
        let password = document.getElementById("password").value.trim();
        let confirmPassword = document.getElementById("confirmPassword").value.trim();

        let nameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s'-]{2,}$/;
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+]{8,}$/;

        if (!nameRegex.test(firstName)) {
            alert("First name must contain only letters and be at least 2 characters.");
            return;
        }

        if (!nameRegex.test(lastName)) {
            alert("Last name must contain only letters and be at least 2 characters.");
            return;
        }

        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        if (!passwordRegex.test(password)) {
            alert("Password must be at least 8 characters and include a number.");
            return;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return;
        }

        alert("Form submitted successfully!");
        this.submit();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (e) {
        e.preventDefault(); 
        let email = document.getElementById("signInEmail").value.trim();
        let password = document.getElementById("signInPassword").value.trim();

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let passwordRegex = /^.{8,}$/; 
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        if (!passwordRegex.test(password)) {
            alert("Password must be at least 8 characters long.");
            return;
        }

        alert("Sign-in successful!");
        this.submit();
    });
});

