// FOOTER
document.addEventListener("DOMContentLoaded", function () {
    // Top Navigation Scroll
    const topNavScroll = document.querySelector(".top-nav-scroll");
    const scrollLeftBtn = document.querySelector(".nav-scroll-left");
    const scrollRightBtn = document.querySelector(".nav-scroll-right");

    if (topNavScroll && scrollLeftBtn && scrollRightBtn) {
        const scrollAmount = 200;

        scrollLeftBtn.addEventListener("click", () => {
            topNavScroll.scrollBy({ left: -scrollAmount, behavior: "smooth" });
        });

        scrollRightBtn.addEventListener("click", () => {
            topNavScroll.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });

        // Show/hide scroll buttons based on scroll position
        const updateScrollButtons = () => {
            const { scrollLeft, scrollWidth, clientWidth } = topNavScroll;
            scrollLeftBtn.style.opacity = scrollLeft > 0 ? "1" : "0.5";
            scrollRightBtn.style.opacity =
                scrollLeft < scrollWidth - clientWidth ? "1" : "0.5";
        };

        topNavScroll.addEventListener("scroll", updateScrollButtons);
        window.addEventListener("resize", updateScrollButtons);
        updateScrollButtons(); // Initial check
    }

    // Newsletter Form Submission
    const newsletterForm = document.querySelector(".newsletter-form");
    if (newsletterForm) {
        newsletterForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const emailInput = this.querySelector('input[type="email"]');
            const consentCheckbox = this.querySelector("#newsletterConsent");

            if (!consentCheckbox.checked) {
                alert("Please agree to receive updates before subscribing.");
                return;
            }

            if (emailInput.value) {
                // Simulate subscription success
                const originalHtml = this.innerHTML;
                this.innerHTML = `
            <div class="alert alert-success mb-0" role="alert">
              <i class="fa-solid fa-check-circle me-2"></i>
              Thank you for subscribing! Check your email for confirmation.
            </div>
          `;

                // Reset after 3 seconds
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                    emailInput.value = "";
                    consentCheckbox.checked = false;
                }, 3000);
            }
        });
    }

    // Smooth scroll for footer links
    const footerLinks = document.querySelectorAll(".footer-links a");
    footerLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            if (this.getAttribute("href").startsWith("#")) {
                e.preventDefault();
                const targetId = this.getAttribute("href").substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: "smooth",
                    });
                }
            }
        });
    });

    // Active navigation item
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll(".top-nav-item");

    navItems.forEach((item) => {
        const href = item.getAttribute("href");
        if (
            href === currentPath ||
            (currentPath === "/" && href.includes("home"))
        ) {
            item.classList.add("active");
        }

        // Add click animation
        item.addEventListener("click", function () {
            navItems.forEach((nav) => nav.classList.remove("active"));
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Scroll animations
    const fadeElements = document.querySelectorAll(".fade-in");

    const fadeInOnScroll = function () {
        fadeElements.forEach((element) => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 100;

            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add("visible");
            }
        });
    };

    // Initial check
    fadeInOnScroll();

    // Check on scroll
    window.addEventListener("scroll", fadeInOnScroll);

    // Animated counters
    const counters = document.querySelectorAll(".stat-number");

    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute("data-count"));
        let current = 0;
        const increment = target / 200;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current).toLocaleString();
        }, 10);
    };

    const counterObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.5,
        },
    );

    counters.forEach((counter) => {
        counterObserver.observe(counter);
    });

    // Add hover effects to cards
    const cards = document.querySelectorAll(
        ".feature-card, .team-card, .value-item",
    );
    cards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.zIndex = "10";
        });

        card.addEventListener("mouseleave", function () {
            this.style.zIndex = "1";
        });
    });
});

// CONTACT US PAGE
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");
    const submitBtn = document.getElementById("submitBtn");
    const btnText = document.getElementById("btnText");
    const feedbackDiv = document.getElementById("formFeedback");

    // Form validation
    function validateForm() {
        let isValid = true;

        // Reset previous errors
        document.querySelectorAll(".form-control").forEach((input) => {
            input.classList.remove("is-invalid");
        });

        // Name validation
        const name = document.getElementById("name");
        if (!name.value.trim()) {
            name.classList.add("is-invalid");
            isValid = false;
        }

        // Email validation
        const email = document.getElementById("email");
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim() || !emailRegex.test(email.value)) {
            email.classList.add("is-invalid");
            isValid = false;
        }

        // Subject validation
        const subject = document.getElementById("subject");
        if (!subject.value.trim()) {
            subject.classList.add("is-invalid");
            isValid = false;
        }

        // Message validation
        const message = document.getElementById("message");
        if (!message.value.trim()) {
            message.classList.add("is-invalid");
            isValid = false;
        }

        return isValid;
    }

    // Show success message
    function showSuccess(message) {
        feedbackDiv.className = "form-feedback success-message show";
        feedbackDiv.innerHTML = `
          <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-2x me-3"></i>
            <div>
              <h5 class="mb-1">Message Sent Successfully!</h5>
              <p class="mb-0">${message || "Thank you for contacting us. We'll get back to you soon."}</p>
            </div>
          </div>
        `;

        // Scroll to feedback
        feedbackDiv.scrollIntoView({
            behavior: "smooth",
            block: "start",
        });

        // Reset form after 3 seconds
        setTimeout(() => {
            form.reset();
        }, 3000);
    }

    // Show error message
    function showError(message) {
        feedbackDiv.className = "form-feedback error-message show";
        feedbackDiv.innerHTML = `
          <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-2x me-3"></i>
            <div>
              <h5 class="mb-1">Oops! Something went wrong</h5>
              <p class="mb-0">${message || "Please try again later or contact us directly."}</p>
            </div>
          </div>
        `;

        // Scroll to feedback
        feedbackDiv.scrollIntoView({
            behavior: "smooth",
            block: "start",
        });
    }

    // Handle form submission
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        // Show loading state
        submitBtn.classList.add("loading");
        btnText.textContent = "Sending...";
        submitBtn.disabled = true;

        // Simulate API call (replace with actual form submission)
        setTimeout(() => {
            // In a real application, you would send the form data to your server here
            // For this example, we'll simulate a successful submission
            const formData = new FormData(form);
            console.log("Form data:", Object.fromEntries(formData));

            // Simulate response
            const isSuccess = Math.random() > 0.2; // 80% success rate for demo

            if (isSuccess) {
                showSuccess(
                    "Your message has been sent successfully. We will respond within 24 hours.",
                );
            } else {
                showError(
                    "There was an issue sending your message. Please try again or contact us directly.",
                );
            }

            // Reset button state
            submitBtn.classList.remove("loading");
            btnText.textContent = "Send Message";
            submitBtn.disabled = false;
        }, 1500);
    });

    // Real-time validation on blur
    document.querySelectorAll(".form-control").forEach((input) => {
        input.addEventListener("blur", function () {
            if (this.value.trim()) {
                this.classList.remove("is-invalid");
            }
        });
    });
});
