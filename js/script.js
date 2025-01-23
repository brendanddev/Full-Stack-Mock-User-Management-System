// Event listener for Sign In form submission
document.getElementById('signInForm').addEventListener('submit', userSignIn);

// Event listener for Sign Up form submission
document.getElementById('signUpForm').addEventListener('submit', userSignUp);

async function userSignIn(event) {
    event.preventDefault();

    var formData = new FormData(event.target);
    var data = { // Extract the data into a JavaScript object
        email: formData.get('email'),
        password: formData.get('password')
    };

    try {
        const response = await fetch('../php/signin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',  
            },
            body: JSON.stringify(data),
        });

        const res = await response.json();  // Parse JSON response
        if (res.success) {
            alert('Login Successful!');
            window.location.href = res.redirect;  
        }else {
            alert('Login Failed: ' + res.message);  
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while processing your request.');
    }
}

async function userSignUp(event) {
    event.preventDefault();

    // Create a FormData object from the form
    var formData = new FormData(event.target);
    var data = { 
        name: formData.get('name'),
        email: formData.get('email'),
        password: formData.get('password'),
        confirmPassword: formData.get('confirmPassword'),
    };

    // Check if passwords match before sending
    if (data.password !== data.confirmPassword) {
        alert('Passwords do not match!');
        return;
    }

    try {
        // Send the data to signup.php via POST method
        const response = await fetch('../php/signup.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',  // Send as JSON
            },
            body: JSON.stringify(data),  // Convert data to JSON string
        });

        const res = await response.json();  // Parse JSON response
        if (res.success) {
            alert('Account Created Successfully!');
        } else {
            alert('Sign Up Failed: ' + res.message); 
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while processing your request.');
    }
}