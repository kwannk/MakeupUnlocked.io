document.getElementById('domoi').addEventListener('click', function(e) {
    e.preventDefault();
    showHomeContent();
});

document.getElementById('laifhakii').addEventListener('click', showHacksContent);
document.getElementById('sochetanieP').addEventListener('click', showCombinationsContent);
document.getElementById('noviinki').addEventListener('click', showNewContent);

function showHomeContent() {
    hideAllContent();
    document.getElementById('glavnayh').style.display = 'block';
    updateActiveNavButton(null);
}

function showHacksContent() {
    hideAllContent();
    document.getElementById('laifhakic').style.display = 'block';
    updateActiveNavButton('laifhakii');
}

function showCombinationsContent() {
    hideAllContent();
    document.getElementById('sochetaniec').style.display = 'block';
    updateActiveNavButton('sochetanieP');
}

function showNewContent() {
    hideAllContent();
    document.getElementById('novinkiii').style.display = 'block';
    updateActiveNavButton('noviinki');
}

function hideAllContent() {
    const sections = [
        'glavnayh',
        'laifhakic',
        'sochetaniec',
        'novinkiii'
    ];
    
    sections.forEach(id => {
        const section = document.getElementById(id);
        if (section) {
            section.style.display = 'none';
        }
    });
}

function updateActiveNavButton(activeBtnId) {
    const navButtons = document.querySelectorAll('.ccc');
    navButtons.forEach(btn => {
        btn.classList.remove('active');
    });
    
    if (activeBtnId) {
        document.getElementById(activeBtnId).classList.add('active');
    }
}

const authModal = document.getElementById('authModal');
const authBtn = document.getElementById('regvoi');
const closeBtn = document.querySelector('.zakriti');
const loginLink = document.getElementById('login');
const switchAuth = document.getElementById('akkaynt');
const modalTitle = document.getElementById('regm');
const authForm = document.getElementById('forma');
const submitBtn = authForm.querySelector('.zareg-zzz');
const userNameSpan = document.getElementById('userName');

let isLoginMode = false;

authBtn.addEventListener('click', function() {
    const userName = localStorage.getItem('userName');
    if (userName) {
        localStorage.removeItem('userName');
        localStorage.removeItem('userEmail');
        localStorage.removeItem('userPassword');
        userNameSpan.textContent = '';
        authBtn.textContent = 'Войти / Регистрация';
    } else {
        isLoginMode = false;
        updateAuthModal();
        authModal.style.display = 'block';
    }
});

closeBtn.addEventListener('click', function() {
    authModal.style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target === authModal) {
        authModal.style.display = 'none';
    }
});

loginLink.addEventListener('click', function(e) {
    e.preventDefault();
    isLoginMode = !isLoginMode;
    updateAuthModal();
});

function updateAuthModal() {
    if (isLoginMode) {
        modalTitle.textContent = 'Вход';
        submitBtn.textContent = 'Войти';
        switchAuth.innerHTML = 'Нет аккаунта? <a href="#" id="login">Зарегистрироваться</a>';
    } else {
        modalTitle.textContent = 'Регистрация';
        submitBtn.textContent = 'Зарегистрироваться';
        switchAuth.innerHTML = 'Уже есть аккаунт? <a href="#" id="login">Войти</a>';
    }
}

authForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('parol').value;
    
    if (isLoginMode) {
        const storedEmail = localStorage.getItem('userEmail');
        const storedPassword = localStorage.getItem('userPassword');
        
        if (email === storedEmail && password === storedPassword) {
            userNameSpan.textContent = localStorage.getItem('userName');
            authBtn.textContent = 'Выйти';
            authModal.style.display = 'none';
            alert('Вход выполнен успешно!');
        } else {
            alert('Неверный email или пароль!');
        }
    } else {
        localStorage.setItem('userName', name);
        localStorage.setItem('userEmail', email);
        localStorage.setItem('userPassword', password);
        
        userNameSpan.textContent = name;
        authBtn.textContent = 'Выйти';
        authModal.style.display = 'none';
        alert('Регистрация прошла успешно!');
    }
});

window.addEventListener('DOMContentLoaded', function() {
    hideAllContent();
    showHomeContent();
    
    const userName = localStorage.getItem('userName');
    if (userName) {
        userNameSpan.textContent = userName;
        authBtn.textContent = 'Выйти';
    }
});