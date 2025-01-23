document.getElementById('display-users-btn').addEventListener('click', loadUsers);
document.getElementById('edit-users-btn').addEventListener('click', loadEditUsers);

async function loadUsers() {
    try {
        const response = await fetch('../php/fetch_all_users.php');
        const users = await response.json();
        displayUsersInTable(users); 
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}

function displayUsersInTable(users) {
    const tableBody = document.querySelector('#active-users-table tbody');
    tableBody.innerHTML = ''; // Clear any existing rows

    users.forEach(user => {
        const row = document.createElement('tr');
        
        const nameCell = document.createElement('td');
        nameCell.textContent = user.name || 'N/A'; 
        row.appendChild(nameCell);

        const emailCell = document.createElement('td');
        emailCell.textContent = user.email || 'N/A';
        row.appendChild(emailCell);

        const roleCell = document.createElement('td');
        roleCell.textContent = user.role ? capitalizeFirstLetter(user.role) : 'N/A';
        row.appendChild(roleCell);

        const profilePicCell = document.createElement('td');
        const profilePic = document.createElement('img');
        profilePic.src = `../assets/${user.profile_pic || 'default.png'}`; // Default image if none provided
        profilePic.alt = 'Profile Picture';
        profilePic.style.width = '50px';
        profilePic.style.height = '50px';
        profilePic.style.objectFit = 'cover';
        profilePic.classList.add('rounded-circle');
        profilePicCell.appendChild(profilePic);
        row.appendChild(profilePicCell);

        tableBody.appendChild(row);
    });
}

async function loadEditUsers() {
    try {
        const response = await fetch('../php/edit_users.php');
        const users = await response.json();
        console.table(users); // Display users in the console for now
    } catch (error) {
        console.error('Error fetching users for editing:', error);
    }
}