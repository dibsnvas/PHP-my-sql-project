document.getElementById('signInButton').addEventListener('click', function() {
    document.getElementById('signup').style.display = 'none';
    document.getElementById('signIn').style.display = 'block';
});

document.getElementById('signUpButton').addEventListener('click', function() {
    document.getElementById('signup').style.display = 'block';
    document.getElementById('signIn').style.display = 'none';
});
