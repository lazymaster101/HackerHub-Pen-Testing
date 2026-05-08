// HackerHub Application JavaScript

// DOM-based XSS vulnerability in profile viewer
function loadUserProfile(username) {
    const profileContainer = document.getElementById('profile-container');
    
    if (!username || username.trim() === '') {
        profileContainer.innerHTML = '<p class="error">Please enter a username</p>';
        return;
    }
    
    // VULNERABLE: Directly inserting user input into DOM
    // Get username from URL parameter if present
    const urlParams = new URLSearchParams(window.location.search);
    const userParam = urlParams.get('user');
    
    if (userParam) {
        username = userParam;
    }
    
    // Fetch user data
    fetch('api/users.php?search=' + encodeURIComponent(username))
        .then(response => response.json())
        .then(data => {
            if (data.success && data.users.length > 0) {
                const user = data.users[0];
                
                // VULNERABLE: Using innerHTML with user-controlled data
                profileContainer.innerHTML = `
                    <div class="profile-card">
                        <div class="profile-header">
                            <h2>Profile: ${username}</h2>
                        </div>
                        <div class="profile-details">
                            <p><strong>Username:</strong> ${user.username}</p>
                            <p><strong>Email:</strong> ${user.email}</p>
                            <p><strong>Bio:</strong> ${user.bio || 'No bio available'}</p>
                            <p><strong>Member since:</strong> ${user.created_at || 'Unknown'}</p>
                        </div>
                    </div>
                `;
            } else {
                // Also vulnerable
                profileContainer.innerHTML = '<p class="error">User "' + username + '" not found</p>';
            }
        })
        .catch(error => {
            profileContainer.innerHTML = '<p class="error">Error loading profile</p>';
        });
}

// Additional helper functions
function initializeDashboard() {
    // Check for profile parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    const userParam = urlParams.get('user');
    
    if (userParam) {
        // Auto-load profile if user parameter present
        const profileInput = document.getElementById('profile-user');
        if (profileInput) {
            profileInput.value = userParam;
            loadUserProfile(userParam);
        }
    }
}

// Call initialization when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeDashboard);
} else {
    initializeDashboard();
}

// Utility function to parse query parameters
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Function to update URL without reload
function updateURL(key, value) {
    const url = new URL(window.location);
    url.searchParams.set(key, value);
    window.history.pushState({}, '', url);
}