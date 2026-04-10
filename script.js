document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.querySelector('.nav__toggle');
    const navList = document.querySelector('.nav__list');
    
    navToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        navList.classList.toggle('active');
    });
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (this.classList.contains('nav__link')) {
                navToggle.classList.remove('active');А
                navList.classList.remove('active');
            }
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    const header = document.querySelector('.header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
        const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav__link');
    
    window.addEventListener('scroll', function() {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (pageYOffset >= sectionTop - 150) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
    
    // Галерея мебели с обновленными данными
    const galleryItems = [
        {
            id: 1,
            title: "Минималистичная кухня",
            desc: "Современная кухня в стиле минимализм с интегрированной техникой. Фасады из матового пластика, столешница из искусственного камня.",
            price: "от 145 000 ₽",
            category: "kitchen",
            img: "img/kitchen.jpg",
            features: [
                "Материал фасадов: матовый пластик",
                "Столешница: искусственный камень",
                "Фурнитура: качественная импортная",
                "Срок изготовления: 25-30 дней",
                "Гарантия: 5 лет"
            ],
            colors: [
                { name: "Маттовый серый", code: "#8c8c8c" },
                { name: "Белый матовый", code: "#f8f8f8" },
                { name: "Графитовый", code: "#4a4a4a" },
                { name: "Натуральный дуб", code: "#d2b48c" }
            ]
        },
        {
            id: 2,
            title: "Гардеробная система",
            desc: "Модульная гардеробная система с комбинированным наполнением. Включает штанги для одежды, полки, ящики и специальные отделения для аксессуаров.",
            price: "от 85 000 ₽",
            category: "wardrobe",
            img: "img/skaf.jpg",
            features: [
                "Материал: ЛДСП 18мм",
                "Раздвижные двери с зеркалами",
                "Система внутреннего освещения",
                "Срок изготовления: 18-22 дня",
                "Гарантия: 3 года"
            ],
            colors: [
                { name: "Белый", code: "#ffffff" },
                { name: "Серый бетон", code: "#a0a0a0" },
                { name: "Дуб шимо", code: "#c9b18b" },
                { name: "Черный глянец", code: "#1a1a1a" }
            ]
        },
        {
            id: 3,
            title: "Гостиная в скандинавском стиле",
            desc: "Светлая гостиная с элементами скандинавского дизайна. Многофункциональная система хранения, интегрированная TV-зона и открытые полки для декора.",
            price: "от 210 000 ₽",
            category: "living-room",
            img: "img/gost.jpg",
            features: [
                "Материал: массив ясеня",
                "Открытые и закрытые секции",
                "Встроенная подсветка",
                "Срок изготовления: 35-40 дней",
                "Гарантия: 5 лет"
            ],
            colors: [
                { name: "Натуральный ясень", code: "#e6d3b9" },
                { name: "Белый с текстурой дерева", code: "#f5f5f5" },
                { name: "Серо-голубой", code: "#a7b8c4" }
            ]
        },
        {
            id: 4,
            title: "Спальня с изголовьем",
            desc: "Уютная спальня с мягким изголовьем и интегрированными тумбами. Функциональное решение для хранения с элегантным дизайном.",
            price: "от 120 000 ₽",
            category: "bedroom",
            img: "img/krovat.jpg",
            features: [
                "Материал: МДФ с покрытием эко-кожа",
                "Изголовье с мягкой обивкой",
                "Встроенные LED-светильники",
                "Срок изготовления: 20-25 дней",
                "Гарантия: 3 года"
            ],
            colors: [
                { name: "Серый текстиль", code: "#e0e0e0" },
                { name: "Темно-синий", code: "#2c3e50" },
                { name: "Терракотовый", code: "#e2725b" },
                { name: "Светлый беж", code: "#f5e6d3" }
            ]
        },
        {
            id: 5,
            title: "Ванная комната",
            desc: "Эргономичная мебель для ванной, разработанная с учётом повышенной влажности. Включает шкафчики с защитным покрытием, встроенные полки и выдвижные ящики для компактного хранения.",
            price: "от 50 000 ₽",
            category: "office",
            img: "img/vanna.jpg",
            features: [
                "Материал: шпонированный МДФ",
                "Стол с регулируемой высотой",
                "Система кабельного менеджмента",
                "Срок изготовления: 15-20 дней",
                "Гарантия: 2 года"
            ],
            colors: [
                { name: "Орех американский", code: "#8b7355" },
                { name: "Белый матовый", code: "#f8f8f8" },
                { name: "Графит", code: "#4a4a4a" }
            ]
        },
        {
            id: 6,
            title: "Кухня-остров",
            desc: "Просторная кухня с островом для барной стойки. Комбинированные материалы: дерево, металл, искусственный камень.",
            price: "от 280 000 ₽",
            category: "kitchen",
            img: "img/kyhnya.jpg",
            features: [
                "Материал: массив дуба и металл",
                "Остров с барной стойкой",
                "Встроенная техника премиум-класса",
                "Срок изготовления: 40-45 дней",
                "Гарантия: 7 лет"
            ],
            colors: [
                { name: "Дуб натуральный", code: "#d2b48c" },
                { name: "Матовая эмаль", code: "#333333" },
                { name: "Металлик", code: "#b0b0b0" }
            ]
        }
    ];
    
    const galleryContainer = document.querySelector('.gallery__items');
    const filterButtons = document.querySelectorAll('.filter__btn');
    const modal = document.getElementById('furniture-modal');
    const modalBody = document.querySelector('.modal__body');
    const modalClose = document.querySelector('.modal__close');
    
    // Отображение всех элементов галереи
    function displayGalleryItems(items) {
        galleryContainer.innerHTML = '';
        
        items.forEach(item => {
            const galleryItem = document.createElement('div');
            galleryItem.classList.add('gallery__item');
            galleryItem.setAttribute('data-category', item.category);
            galleryItem.setAttribute('data-id', item.id);
            
            galleryItem.innerHTML = `
                <div class="gallery__img">
                    <img src="${item.img}" alt="${item.title}" loading="lazy">
                </div>
                <div class="gallery__info">
                    <h3 class="gallery__title">${item.title}</h3>
                    <p class="gallery__desc">${item.desc.substring(0, 90)}...</p>
                    <div class="gallery__price">${item.price}</div>
                </div>
            `;
            
            galleryContainer.appendChild(galleryItem);
        });
        
        // Добавляем обработчики клика на элементы галереи
        document.querySelectorAll('.gallery__item').forEach(item => {
            item.addEventListener('click', function() {
                const itemId = parseInt(this.getAttribute('data-id'));
                const selectedItem = galleryItems.find(item => item.id === itemId);
                openModal(selectedItem);
            });
        });
    }
    
    // Открытие модального окна с деталями мебели
    function openModal(item) {
        modalBody.innerHTML = `
            <div class="modal__image">
                <img src="${item.img}" alt="${item.title}">
            </div>
            <div class="modal__info">
                <h2>${item.title}</h2>
                <div class="modal__price">${item.price}</div>
                <div class="modal__description">
                    <p>${item.desc}</p>
                </div>
                <div class="modal__features">
                    <h3>Характеристики:</h3>
                    <ul>
                        ${item.features.map(feature => `<li>${feature}</li>`).join('')}
                    </ul>
                </div>
                <div class="modal__colors">
                    <h3>Доступные цвета:</h3>
                    <div class="color-options">
                        ${item.colors.map(color => `
                            <div class="color-option" style="background-color: ${color.code};" title="${color.name}" data-color="${color.name}"></div>
                        `).join('')}
                    </div>
                    <div class="color-name" id="selected-color">${item.colors[0].name}</div>
                </div>
                <button class="modal__btn">Запросить расчет</button>
            </div>
        `;
        
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Добавляем обработчики для выбора цвета
        const colorOptions = document.querySelectorAll('.color-option');
        const selectedColorElement = document.getElementById('selected-color');
        
        colorOptions.forEach((option, index) => {
            option.addEventListener('click', function() {
                colorOptions.forEach(opt => {
                    opt.classList.remove('active');
                });
                this.classList.add('active');
                const colorName = this.getAttribute('data-color');
                selectedColorElement.textContent = colorName;
            });
            
            // Первый цвет активен по умолчанию
            if (index === 0) {
                option.classList.add('active');
            }
        });
        
        // Обработчик кнопки заказа
        document.querySelector('.modal__btn').addEventListener('click', function() {
            const selectedColor = document.querySelector('.color-option.active').getAttribute('data-color');
            alert(`Вы выбрали: ${item.title}\nЦвет: ${selectedColor}\nСтоимость: ${item.price}\nНаш менеджер свяжется с вами для уточнения деталей и расчета точной стоимости!`);
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    // Закрытие модального окна
    modalClose.addEventListener('click', function() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    });
    
    // Закрытие модального окна при клике вне его
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Закрытие модального окна клавишей ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Фильтрация галереи
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Удаляем активный класс у всех кнопок
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Добавляем активный класс текущей кнопке
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            if (filterValue === 'all') {
                displayGalleryItems(galleryItems);
            } else {
                const filteredItems = galleryItems.filter(item => item.category === filterValue);
                displayGalleryItems(filteredItems);
            }
        });
    });
    
    // Инициализация галереи
    displayGalleryItems(galleryItems);
    
    // Форма обратной связи
    const feedbackForm = document.getElementById('feedback-form');
    
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Простая валидация
            const name = this.querySelector('input[type="text"]').value;
            const phone = this.querySelector('input[type="tel"]').value;
            
            if (!name || !phone) {
                alert('Пожалуйста, заполните обязательные поля: имя и телефон');
                return;
            }
            
            // Здесь можно добавить код для отправки формы
            // Например, с помощью fetch или AJAX
            
            alert('Спасибо за вашу заявку! Наш менеджер свяжется с вами в течение 15 минут для уточнения деталей.');
            this.reset();
        });
    }
    
    // Слайдер отзывов
    const reviews = document.querySelectorAll('.review');
    const dots = document.querySelectorAll('.reviews__dot');
    const prevBtn = document.querySelector('.reviews__prev');
    const nextBtn = document.querySelector('.reviews__next');
    
    let currentReview = 0;
    
    function showReview(index) {
        // Скрываем все отзывы
        reviews.forEach(review => review.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Показываем нужный отзыв
        reviews[index].classList.add('active');
        dots[index].classList.add('active');
        
        currentReview = index;
        
        // Обновляем состояние кнопок
        prevBtn.disabled = index === 0;
        nextBtn.disabled = index === reviews.length - 1;
    }
    
    // Обработчики для кнопок навигации
    prevBtn.addEventListener('click', () => {
        if (currentReview > 0) {
            showReview(currentReview - 1);
        }
    });
    
    nextBtn.addEventListener('click', () => {
        if (currentReview < reviews.length - 1) {
            showReview(currentReview + 1);
        }
    });
    
    // Обработчики для точек
    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            showReview(index);
        });
    });
    
    // Автопереключение отзывов (опционально)
    let autoSlideInterval = setInterval(() => {
        let nextIndex = currentReview + 1;
        if (nextIndex >= reviews.length) {
            nextIndex = 0;
        }
        showReview(nextIndex);
    }, 8000);
    
    // Останавливаем автопереключение при наведении на отзывы
    const reviewsContainer = document.querySelector('.reviews__container');
    reviewsContainer.addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
    });
    
    reviewsContainer.addEventListener('mouseleave', () => {
        autoSlideInterval = setInterval(() => {
            let nextIndex = currentReview + 1;
            if (nextIndex >= reviews.length) {
                nextIndex = 0;
            }
            showReview(nextIndex);
        }, 8000);
    });
    
    // Показать первый отзыв
    showReview(0);
    
    // Анимация при скролле
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Наблюдаем за элементами с анимацией
    document.querySelectorAll('.gallery__item, .step, .stat').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});