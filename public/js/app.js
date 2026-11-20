document.addEventListener('DOMContentLoaded', () => {
    const splash = document.querySelector('#intro-splash');

    if (splash) {
        const splashKey = 'yard-roasters-intro-seen';

        if (sessionStorage.getItem(splashKey)) {
            splash.remove();
        } else {
            splash.hidden = false;
            document.body.classList.add('splash-is-open');
            sessionStorage.setItem(splashKey, '1');

            let splashTimer;
            const closeSplash = () => {
                window.clearTimeout(splashTimer);
                splash.classList.add('is-leaving');
                window.setTimeout(() => {
                    splash.remove();
                    document.body.classList.remove('splash-is-open');
                }, 850);
            };

            splashTimer = window.setTimeout(closeSplash, 3200);
            splash.querySelector('.splash-skip').addEventListener('click', closeSplash);
        }
    }

    const toggle = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.main-nav');

    if (toggle && navigation) {
        toggle.addEventListener('click', () => {
            const isOpen = navigation.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(isOpen));
        });
    }

    const deliveryRadios = document.querySelectorAll('input[name="fulfillment_method"]');
    const deliveryAddress = document.querySelector('.delivery-address');

    if (deliveryAddress && deliveryRadios.length) {
        const syncDeliveryAddress = () => {
            const isDelivery = document.querySelector('input[name="fulfillment_method"]:checked')?.value === 'delivery';
            deliveryAddress.hidden = !isDelivery;
            deliveryAddress.querySelector('textarea').required = isDelivery;
        };

        deliveryRadios.forEach((radio) => radio.addEventListener('change', syncDeliveryAddress));
        syncDeliveryAddress();
    }

    const animatedElements = document.querySelectorAll(
        '.hero-copy > *, .hero-visual, .values-inner > span, .product-card, .story-image, .story-copy > *, .newsletter-inner > *',
    );

    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        animatedElements.forEach((element, index) => {
            element.classList.add('reveal-on-scroll');
            element.style.setProperty('--reveal-delay', `${Math.min(index % 6, 5) * 70}ms`);
            revealObserver.observe(element);
        });
    } else {
        animatedElements.forEach((element) => element.classList.add('is-visible'));
    }
});
