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

    //   dashboard script 

    // Time period filter functionality
    const timeFilters = document.querySelectorAll('.time-filter');
    let currentPeriod = 'monthly';
    let charts = {};

    // Sample data for different time periods
    const chartData = {
      daily: {
        revenue: {
          labels: Array.from({ length: 24 }, (_, i) => `${i}:00`),
          data: Array.from({ length: 24 }, () =>
            Math.floor(Math.random() * 5000)
          )
        },
        categories: {
          data: [15, 12, 8, 7, 5, 3]
        }
      },
      weekly: {
        revenue: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          data: Array.from({ length: 7 }, () =>
            Math.floor(Math.random() * 20000)
          )
        },
        categories: {
          data: [25, 20, 12, 10, 8, 5]
        }
      },
      monthly: {
        revenue: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          data: [30000, 35000, 32000, 45000, 48000, 52389]
        },
        categories: {
          data: [30, 25, 15, 13, 10, 7]
        }
      },
      yearly: {
        revenue: {
          labels: ['2020', '2021', '2022', '2023', '2024'],
          data: [250000, 320000, 420000, 480000, 520000]
        },
        categories: {
          data: [35, 28, 18, 15, 12, 8]
        }
      }
    };

    // Initialize charts
    function initializeCharts() {
      // Category Distribution Chart
      charts.category = new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
          labels: [
            'Music',
            'Tech',
            'Sports',
            'Art',
            'Food & Drink',
            'Business'
          ],
          datasets: [
            {
              data: chartData.monthly.categories.data,
              backgroundColor: [
                'rgba(249, 115, 22, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(236, 72, 153, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(107, 114, 128, 0.8)'
              ],
              borderColor: 'white',
              borderWidth: 2
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                padding: 20,
                font: { family: 'Poppins' }
              }
            }
          }
        }
      });

      // Revenue Trend Chart
      charts.revenue = new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
          labels: chartData.monthly.revenue.labels,
          datasets: [
            {
              label: 'Revenue',
              data: chartData.monthly.revenue.data,
              borderColor: 'rgb(249, 115, 22)',
              backgroundColor: 'rgba(249, 115, 22, 0.1)',
              fill: true,
              tension: 0.4
            }
          ]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: value => '$' + value.toLocaleString(),
                font: { family: 'Poppins' }
              }
            },
            x: {
              grid: { display: false },
              ticks: { font: { family: 'Poppins' } }
            }
          }
        }
      });
    }

    // Update charts based on time period
    function updateCharts(period) {
      // Update revenue chart
      charts.revenue.data.labels = chartData[period].revenue.labels;
      charts.revenue.data.datasets[0].data = chartData[period].revenue.data;
      charts.revenue.update();

      // Update category chart
      charts.category.data.datasets[0].data =
        chartData[period].categories.data;
      charts.category.update();

      // Update stats cards with animations
      updateStatsCards(period);
    }

    // Update stats cards with animations
    function updateStatsCards(period) {
      const cards = document.querySelectorAll('.rounded-2xl');
      cards.forEach(card => {
        const stat = card.querySelector('h3');
        if (stat) {
          // Add fade-out effect
          stat.style.opacity = '0';
          setTimeout(() => {
            // Update value and fade in
            if (stat.textContent.includes('$')) {
              stat.textContent = `$${Math.floor(Math.random() * 90000)}`;
            } else {
              stat.textContent = Math.floor(Math.random() * 5000);
            }
            stat.style.opacity = '1';
          }, 200);
        }
      });
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', () => {
      initializeCharts();

      // Time filter click handlers
      timeFilters.forEach(filter => {
        filter.addEventListener('click', () => {
          // Update active state
          timeFilters.forEach(f => {
            f.classList.remove('bg-white', 'shadow-sm', 'text-orange-500');
          });
          filter.classList.add('bg-white', 'shadow-sm', 'text-orange-500');

          // Update charts
          const period = filter.dataset.period;
          currentPeriod = period;
          updateCharts(period);
        });
      });
    });

    // Add interactivity to the stats cards
    document.querySelectorAll('.rounded-2xl').forEach(card => {
      card.addEventListener('mouseover', () => {
        card.classList.add(
          'transform',
          'scale-105',
          'transition-all',
          'duration-300',
          'shadow-md'
        );
      });
      card.addEventListener('mouseout', () => {
        card.classList.remove(
          'transform',
          'scale-105',
          'transition-all',
          'duration-300',
          'shadow-md'
        );
      });
    });

    // user management

    document.addEventListener('DOMContentLoaded', () => {
      // Search functionality
      const searchInput = document.querySelector('input[placeholder="Search users..."]');
      searchInput.addEventListener('input', e => {
        const searchTerm = e.target.value.toLowerCase();
        // Implement search logic here
        console.log('Searching for:', searchTerm);
      });

      // Status filter
      const statusFilter = document.querySelector('select');
      statusFilter.addEventListener('change', () => {
        const selectedStatus = statusFilter.value;
        // Implement filter logic here
        console.log('Filtering by:', selectedStatus);
      });

      // Action buttons
      const actionButtons = document.querySelectorAll('button');
      actionButtons.forEach(button => {
        const action = button.textContent.trim();
        if (['Ban', 'Activate', 'Approve', 'Reject'].includes(action)) {
          button.addEventListener('click', e => {
            e.preventDefault();
            handleUserAction(action, button.closest('tr'));
          });
        }
      });
    });

    function handleUserAction(action, userRow) {
      const userName = userRow.querySelector('.text-gray-900').textContent;
      console.log(`${action} user: ${userName}`);
      
      // Update UI based on action
      const statusBadge = userRow.querySelector('.rounded-full');
      switch(action) {
        case 'Ban':
          statusBadge.className = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
          statusBadge.textContent = 'Banned';
          break;
        case 'Activate':
          statusBadge.className = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
          statusBadge.textContent = 'Active';
          break;
        case 'Approve':
        case 'Reject':
          userRow.remove(); 
          break;
      }
    }




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

