function toggleProfileEdit(){
    const editToggle = document.getElementById('editToggle');
const saveBtn = document.getElementById('saveBtn');
const profileName = document.getElementById('profileName');
const profileNameInput = document.getElementById('profileNameInput');
const profilePfp = document.getElementById('profilePfp');
const profilePfpUpload = document.getElementById('profilePfpUpload');
const profilePfpPreview = document.getElementById('profilePfpPreview');
const avatarInput = document.getElementById('avatarInput');

let isEditMode = false;
let selectedFile = null;

// Toggle edit mode
editToggle?.addEventListener('click', () => {
    isEditMode = !isEditMode;
    toggleEditMode();
});

// Save changes
saveBtn?.addEventListener('click', async () => {
    await saveProfile();
});

// Click profile picture to upload
profilePfpUpload?.addEventListener('click', () => {
    avatarInput.click();
});

// Handle file selection
avatarInput?.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file && file.type.startsWith('image/')) {
        selectedFile = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            profilePfpPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

function toggleEditMode() {
    if (isEditMode) {
        // Switch to edit mode
        profileName.style.display = 'none';
        profileNameInput.style.display = 'block';
        profilePfp.style.display = 'none';
        profilePfpUpload.style.display = 'block';
        editToggle.classList.remove('fa-pen');
        editToggle.classList.add('fa-times');
        saveBtn.style.display = 'inline-block';
    } else {
        // Switch to view mode
        profileName.style.display = 'block';
        profileNameInput.style.display = 'none';
        profilePfp.style.display = 'block';
        profilePfpUpload.style.display = 'none';
        editToggle.classList.remove('fa-times');
        editToggle.classList.add('fa-pen');
        saveBtn.style.display = 'none';
        
        // Reset if cancelled
        profileNameInput.value = profileName.textContent;
        selectedFile = null;
    }
}

async function saveProfile() {
    const formData = new FormData();
    formData.append('nickname', profileNameInput.value);
    formData.append('_method', 'PUT');
    
    if (selectedFile) {
        formData.append('avatar', selectedFile);
    }

    try {
        const response = await fetch(window.location.pathname, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        if (response.ok) {
            const data = await response.json();
            
            // Update view mode elements
            profileName.textContent = data.user.nickname;
            profilePfp.src = data.user.avatar_url;
            
            // Exit edit mode
            isEditMode = false;
            toggleEditMode();
            
            alert('Profile updated successfully!');
        } else {
            const error = await response.json();
            alert('Error: ' + (error.message || 'Failed to update profile'));
        }
    } catch (err) {
        console.error(err);
        alert('Network error');
    }
}
}