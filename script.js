document.getElementById('register').addEventListener('submit', function(event) {
    let valid = true;
    const password = document.getElementById('register-password').value;
    const retypePassword = document.getElementById('register-retype-password').value;
    const passwordError = document.createElement('div');
    const retypePasswordError = document.createElement('div');

    passwordError.style.color = 'red';
    retypePasswordError.style.color = 'red';

    // Remove previous error messages
    const previousPasswordError = document.getElementById('password-error');
    const previousRetypePasswordError = document.getElementById('retype-password-error');
    if (previousPasswordError) previousPasswordError.remove();
    if (previousRetypePasswordError) previousRetypePasswordError.remove();

    // Validate password
    const passwordPattern = /^(?=.*[A-Z])(?=.*\W)(?=.*\d).{8,16}$/;
    if (!passwordPattern.test(password)) {
        passwordError.id = 'password-error';
        passwordError.innerText = 'Password must be 8-16 characters, include a symbol, number and a capital letter';
        document.getElementById('register-password').parentNode.appendChild(passwordError);
        valid = false;
    }

    // Validate retype password
    if (password !== retypePassword) {
        retypePasswordError.id = 'retype-password-error';
        retypePasswordError.innerText = 'Passwords do not match';
        document.getElementById('register-retype-password').parentNode.appendChild(retypePasswordError);
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }

    const header = document.querySelector('header');
    function fixedNavbar(){
        header.classList.toggle('scrolled', window.pageYOffset > 0);

    }
    fixedNavbar();
    window.addEventListener('scroll', fixedNavbar);

    //dsdsdsdsdsdsdsdsdssdssssssssssssssssssssssssssssssssss
    

        // Merr ikonën dhe div-in
    const userBtn = document.getElementById("user-btn");
    const userBox = document.getElementById("myDiv");

    // Event listener për të hapur/mbyllur div-in
    userBtn.addEventListener("click", (e) => {
        e.stopPropagation(); // Parandalon që klikimi të shpërndahet
        if (userBox.style.display === "block") {
            userBox.style.display = "none";
        } else {
            userBox.style.display = "block";
        }
    });

    // Mbyll div-in kur klikon diku tjetër
    

    
    
    
    // Merr ikonën dhe div-in
    const menuBtn = document.getElementById("menu-btn");
    const middleSection = document.querySelector(".mid");

    window.addEventListener("click", (e) => {
        if (!userBox.contains(e.target) && !userBtn.contains(e.target)) {
        }
        if (!middleSection.contains(e.target) && !menuBtn.contains(e.target)) {
            middleSection.style.display = "none";
        }
    });
    // Event listener për të hapur/mbyllur div-in
    menuBtn.addEventListener("click", (e) => {
        e.stopPropagation(); // Parandalon që klikimi të shpërndahet
        if (middleSection.style.display === "block") {
            middleSection.style.display = "none";
        } else {
            middleSection.style.display = "block";
        }
    });

    // Mbyll div-in kur klikon diku tjetër
    window.addEventListener("resize", () => {
        if (window.innerWidth > 768) {
            middleSection.style.display = "none";
        }
    });

    // Mbyll div-in kur klikon diku tjetër
    
    
   
});