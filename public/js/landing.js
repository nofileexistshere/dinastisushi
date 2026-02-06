// Header scroll effect
const header = document.querySelector(".header");

window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});

// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
            target.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });
});

// Mobile menu toggle
const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
const navLinks = document.querySelector(".nav-links");

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener("click", () => {
        mobileMenuBtn.classList.toggle("active");
        navLinks.classList.toggle("mobile-active");
    });
}

// Scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("visible");
        }
    });
}, observerOptions);

// Add animation class to elements
document
    .querySelectorAll(
        ".menu-card, .gallery-item, .about-content, .reservation-content"
    )
    .forEach((el) => {
        el.classList.add("animate-on-scroll");
        observer.observe(el);
    });

// Stagger animation for menu cards
const menuCards = document.querySelectorAll(".menu-card");
menuCards.forEach((card, index) => {
    card.style.transitionDelay = `${index * 0.1}s`;
});

// Stagger animation for gallery items
const galleryItems = document.querySelectorAll(".gallery-item");
galleryItems.forEach((item, index) => {
    item.style.transitionDelay = `${index * 0.1}s`;
});

// Parallax effect for hero section
const heroBg = document.querySelector(".hero-bg img");
if (heroBg) {
    window.addEventListener("scroll", () => {
        const scrolled = window.scrollY;
        heroBg.style.transform = `translateY(${scrolled * 0.4}px)`;
    });
}

// Active navigation link highlight
const sections = document.querySelectorAll("section[id]");

window.addEventListener("scroll", () => {
    const scrollY = window.pageYOffset;

    sections.forEach((section) => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute("id");
        const navLink = document.querySelector(
            `.nav-links a[href="#${sectionId}"]`
        );

        if (navLink) {
            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                navLink.classList.add("active");
            } else {
                navLink.classList.remove("active");
            }
        }
    });
});

// Image lazy loading
const lazyImages = document.querySelectorAll("img[data-src]");
const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.removeAttribute("data-src");
            imageObserver.unobserve(img);
        }
    });
});

lazyImages.forEach((img) => imageObserver.observe(img));

// Counter animation for stats (if any)
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);

    const updateCounter = () => {
        start += increment;
        if (start < target) {
            element.textContent = Math.floor(start);
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target;
        }
    };

    updateCounter();
}

// Hover effect for menu cards
menuCards.forEach((card) => {
    card.addEventListener("mouseenter", () => {
        card.style.zIndex = "10";
    });

    card.addEventListener("mouseleave", () => {
        card.style.zIndex = "1";
    });
});

// Smooth reveal on page load
window.addEventListener("load", () => {
    document.body.classList.add("loaded");

    // Animate hero content
    const heroContent = document.querySelector(".hero-content");
    if (heroContent) {
        heroContent.style.opacity = "0";
        heroContent.style.transform = "translateY(30px)";

        setTimeout(() => {
            heroContent.style.transition =
                "opacity 0.8s ease, transform 0.8s ease";
            heroContent.style.opacity = "1";
            heroContent.style.transform = "translateY(0)";
        }, 300);
    }
});

// Reservation button click
const reservationBtns = document.querySelectorAll(
    ".btn-reservation-nav, .reservation-section .btn-primary"
);
reservationBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        const contactSection = document.querySelector("#contact");
        if (contactSection) {
            contactSection.scrollIntoView({ behavior: "smooth" });
        }
    });
});

console.log("Dinasti Sushi - Landing Page Loaded");
