//carrousel
document.addEventListener('DOMContentLoaded', function () {
    const carouselInner = document.querySelector('.carousel-inner');
    if (carouselInner) {
        const carouselItems = document.querySelectorAll('.carousel-item');
        let currentIndex = 0;

        function updateCarousel() {
            const offset = -currentIndex * 100;
            carouselInner.style.transform = `translateX(${offset}%)`;
        }

        setInterval(function () {
            currentIndex = (currentIndex < carouselItems.length - 1) ? currentIndex + 1 : 0;
            updateCarousel();
        }, 3000);
    }
});
//register
document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('registerForm');
    const message = document.getElementById('message');

    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(registerForm);

            fetch('register_process.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        message.textContent = 'Registro exitoso. Redirigiendo al inicio de sesión...';
                        setTimeout(() => {
                            window.location.href = 'login.php';
                        }, 2000);
                    } else {
                        message.textContent = data.error;
                    }
                })
                .catch(error => {
                    message.textContent = 'Ocurrió un error. Inténtalo de nuevo.';
                });
        });
    }
});
//login
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const message = document.getElementById('message');

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(loginForm);

            fetch('login_process.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        message.textContent = 'Inicio de sesión exitoso. Redirigiendo...';
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 2000);
                    } else {
                        message.textContent = data.error;
                    }
                })
                .catch(error => {
                    message.textContent = 'Ocurrió un error. Inténtalo de nuevo.';
                });
        });
    }
});
//news
document.addEventListener('DOMContentLoaded', function () {
    const createNewsForm = document.getElementById('createNewsForm');
    const message = document.getElementById('message');

    if (createNewsForm) {
        createNewsForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(createNewsForm);

            fetch('create_news_process.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        message.textContent = 'Noticia creada exitosamente.';
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 2000);
                    } else {
                        message.textContent = data.error;
                    }
                })
                .catch(error => {
                    message.textContent = 'Ocurrió un error. Inténtalo de nuevo.';
                });
        });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const createNewsButton = document.getElementById('add-news-btn');

    if (createNewsButton) {
        createNewsButton.addEventListener('click', function () {
            window.location.href = 'create_news.php';
        });
    }
});