document.getElementById('load-users-btn').addEventListener('click', loadActiveUsers);

async function loadActiveUsers() {
    try {
        const response = await fetch('../php/fetch_active_users.php');
        const users = await response.json();

        const tableBody = document.getElementById('active-users-table').querySelector('tbody');
        tableBody.innerHTML = '';

        users.forEach(user => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.role}</td>
                <td><img src="../assets/${user.profile_picture}" alt="${user.name}'s profile" width="50" height="50" style="object-fit: cover;"></td>
            `;
            
            tableBody.appendChild(row);
        });
    } catch (error) {
        console.error('Error fetching active users:', error);
    }
}

function handleLogout() {
    fetch('logout.php')
        .then(response => {
            if (response.ok) {
                window.location.href = '../html/index.html'; // Redirect to login after logout
            } else {
                console.error('Logout failed');
            }
        })
        .catch(error => console.error('Error logging out:', error));
}

document.getElementById('logout-btn').addEventListener('click', function (e) {
    e.preventDefault(); 
    handleLogout(); 
});