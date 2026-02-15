<?php
session_start();
// Remove auto-login - let users login manually
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcade Gaming - Ultimate Gaming Experience</title>
    <link rel="stylesheet" href="arcade-gaming.css">
    <link rel="stylesheet" href="posts.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php
    function safeRequire($header, $main, $footer)
    {
        if (file_exists($header) && file_exists($main) && file_exists($footer)) {

            require_once($header);
            require_once($main);
            include("postinsta.php");
            require_once($footer);

        } else {
            include("include/404.php");
            exit();
        }
    }

    safeRequire('include/header.php', 'include/main.php', 'include/footer.php');

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (header) {
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }
        });

        // Animated counters
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = target / 200;
                let current = 0;

                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString();
                    }
                };
                updateCounter();
            });
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                    if (entry.target.classList.contains('stats-container')) {
                        animateCounters();
                    }
                }
            });
        }, observerOptions);

        // Observe elements for animation
        const elementsToObserve = document.querySelectorAll('.step-card, .testimonial-card, .news-item, .stats-container');
        elementsToObserve.forEach(el => {
            observer.observe(el);
        });

        // Theme toggle
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                document.body.classList.toggle('dark-theme');
                const icon = themeToggle.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-moon');
                    icon.classList.toggle('fa-sun');
                }
            });
        }

        // Newsletter subscription
        const subscribeBtn = document.getElementById('subscribeBtn');
        const newsletterEmail = document.getElementById('newsletterEmail');

        if (subscribeBtn && newsletterEmail) {
            subscribeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const email = newsletterEmail.value;
                if (email && email.includes('@')) {
                    alert('Thank you for subscribing!');
                    newsletterEmail.value = '';
                } else {
                    alert('Please enter a valid email address.');
                }
            });
        }

        // Back to top button
        const backToTopBtn = document.getElementById('backToTop');

        if (backToTopBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopBtn.style.display = 'block';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            });

            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Download button interactions
        document.querySelectorAll('.download-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    btn.style.transform = 'scale(1)';
                    alert('Download started!');
                }, 150);
            });
        });

        // Card hover effects
        document.querySelectorAll('.step-card, .testimonial-card, .news-item').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px) scale(1.02)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>

</html>
