
// Modal functionality
function openModal() {
  const modal = document.getElementById('editProfileModal');
  modal.style.display = 'block';
}

function closeModal() {
  const modal = document.getElementById('editProfileModal');
  modal.style.display = 'none';
}

// Add click handlers to both edit buttons
document.addEventListener('DOMContentLoaded', function () {
  // Get all edit profile buttons
  const editButtons = document.querySelectorAll(
    'button[title="Edit Profile"]'
  );

  // Add click event to each button
  editButtons.forEach(button => {
    button.addEventListener('click', openModal);
  });

  // Close modal when clicking outside
  document
    .getElementById('editProfileModal')
    .addEventListener('click', function (e) {
      if (e.target === this) {
        closeModal();
      }
    });

  // Close modal with escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeModal();
    }
  });

  // Handle form submission
  document
    .querySelector('#editProfileModal form')
    .addEventListener('submit', function (e) {
      e.preventDefault();
      // Add your form submission logic here
      console.log('Form submitted');
      closeModal();
    });
});

// Photo modal functionality
function openPhotoModal() {
  document.getElementById('photoEditModal').style.display = 'block';
}

function closePhotoModal() {
  document.getElementById('photoEditModal').style.display = 'none';
}

function previewPhoto(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('currentPhoto').src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}

function removePhoto() {
  document.getElementById('currentPhoto').src =
    'https://randomuser.me/api/portraits/men/32.jpg';
  document.getElementById('photoInput').value = '';
}

function savePhoto() {
  const newPhotoSrc = document.getElementById('currentPhoto').src;
  // Update all profile photos on the page
  document.querySelectorAll('.profile img').forEach(img => {
    img.src = newPhotoSrc;
  });
  closePhotoModal();
}

// Update the click handler for the photo edit button
document
  .querySelector('.profile-photo button')
  .addEventListener('click', e => {
    e.preventDefault();
    openPhotoModal();
  });

// Close photo modal with escape key
document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape') {
    closePhotoModal();
  }
});

// Close photo modal when clicking outside
document
  .getElementById('photoEditModal')
  .addEventListener('click', function (e) {
    if (e.target === this) {
      closePhotoModal();
    }
  });
