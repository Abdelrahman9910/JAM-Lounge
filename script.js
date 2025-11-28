document.addEventListener('DOMContentLoaded', function() {
    // Handle scroll to collapse navbar and show hamburger
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        const hamburger = document.querySelector('.hamburger');
        
        if (window.scrollY > 100) {
            navbar.classList.add('hidden');
            hamburger.classList.add('show');
        } else {
            navbar.classList.remove('hidden');
            hamburger.classList.remove('show');
        }
    });

    // Handle mobile navigation
    const hamburger = document.querySelector('.hamburger');
    const sideNav = document.querySelector('.side-nav');
    const overlay = document.querySelector('.overlay');
    
    // Function to open navigation
    function openNavigation() {
        hamburger.classList.add('active');
        sideNav.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    // Function to close navigation
    function closeNavigation() {
        hamburger.classList.remove('active');
        sideNav.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Hamburger click event
    if (hamburger) {
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (this.classList.contains('active')) {
                closeNavigation();
            } else {
                openNavigation();
            }
        });
    }

    // Overlay click event
    if (overlay) {
        overlay.addEventListener('click', function() {
            closeNavigation();
        });
    }

    // Close side nav when clicking on a link
    const navLinks = document.querySelectorAll('.side-nav a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            closeNavigation();
        });
    });

    // Close navigation when clicking on the side nav content
    if (sideNav) {
        sideNav.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Close navigation when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeNavigation();
        }
    });

    // Intersection Observer for animated section
    const animatedSection = document.querySelector('.animated-section');
    
    if (animatedSection) {
        const observerOptions = {
            threshold: 0.15, // 15% of the section must be visible
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    // Optional: unobserve after animation
                     observer.unobserve(entry.target);
                } else {
                    // Optional: remove class when out of view for re-animation on scroll up
                     entry.target.classList.remove('in-view');
                }
            });
        }, observerOptions);

        observer.observe(animatedSection);
    }

    // Time validation (if you have time input)
    const timeInput = document.getElementById('time');
    if (timeInput) {
        timeInput.addEventListener('input', function() {
            const [hours, minutes] = this.value.split(':').map(Number);
            if ((hours < 11 && hours !== 0) || (hours >= 1 && hours < 11)) {
                alert('Please select a time between 11 AM and 1 AM.');
                this.value = '';
            }
        });
    }

    // Add click handlers for the learn more buttons
    const learnMoreBtns = document.querySelectorAll('.learn-more-btn');
    learnMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Learn more functionality would go here!');
            // You can redirect or show more content as needed
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // ... (keep all your existing navigation code) ...

    // Enhanced Intersection Observer for animated section with scroll direction
    const animatedSection = document.querySelector('.animated-section');
    const contentBoxes = document.querySelectorAll('.content-box');
    
    if (animatedSection) {
        let lastScrollY = window.scrollY;
        let ticking = false;
        let sectionState = 'hidden'; // hidden, showing, shown, hiding
        
        // More precise observer options
        const observerOptions = {
            threshold: [0, 0.15, 0.5, 0.85, 1], // Multiple thresholds for finer control
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                const currentScrollY = window.scrollY;
                const scrollDirection = currentScrollY > lastScrollY ? 'down' : 'up';
                lastScrollY = currentScrollY;
                
                const intersectionRatio = entry.intersectionRatio;
                
                if (entry.isIntersecting) {
                    // Section is entering viewport
                    if (intersectionRatio >= 0.15 && intersectionRatio < 0.5) {
                        // Start showing when 15% visible
                        if (sectionState !== 'showing') {
                            sectionState = 'showing';
                            showContent();
                        }
                    } else if (intersectionRatio >= 0.5) {
                        // Fully visible
                        sectionState = 'shown';
                        ensureContentVisible();
                    }
                } else {
                    // Section is leaving viewport
                    if (scrollDirection === 'up' && sectionState !== 'hiding') {
                        // User is scrolling up - fade out
                        sectionState = 'hiding';
                        hideContent();
                    } else if (scrollDirection === 'down' && sectionState === 'shown') {
                        // User scrolled past completely
                        sectionState = 'hidden';
                        resetContent();
                    }
                }
            });
        }, observerOptions);

        observer.observe(animatedSection);

        // Throttled scroll handler for additional control
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });

        function handleScroll() {
            const sectionRect = animatedSection.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            // Calculate how much of the section is visible
            const visiblePercentage = Math.max(0, Math.min(100, 
                (windowHeight - sectionRect.top) / sectionRect.height * 100
            ));
            
            // Smooth opacity based on scroll position (optional)
            updateScrollProgress(visiblePercentage);
        }
        
        function showContent() {
            contentBoxes.forEach(box => {
                box.classList.remove('fading-out');
                box.classList.add('active');
            });
        }
        
        function hideContent() {
            contentBoxes.forEach(box => {
                box.classList.remove('active');
                box.classList.add('fading-out');
            });
        }
        
        function ensureContentVisible() {
            contentBoxes.forEach(box => {
                box.classList.remove('fading-out');
                box.classList.add('active');
            });
        }
        
        function resetContent() {
            contentBoxes.forEach(box => {
                box.classList.remove('active', 'fading-out');
            });
        }
        
       
    }

    // Add click handlers for the learn more buttons
    const learnMoreBtns = document.querySelectorAll('.learn-more-btn');
    learnMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Learn more functionality would go here!');
        });
    });

    // ... (keep your existing time validation code) ...
});
// Background Fade Section with 25% threshold
const fadeSection = document.querySelector('.fade-section');

if (fadeSection) {
    const observerOptions = {
        threshold: [0, 0.25, 0.5, 0.75, 1], // Multiple thresholds including 25%
        rootMargin: '0px'
    };

    const fadeObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            const intersectionRatio = entry.intersectionRatio;
            
            if (entry.isIntersecting) {
                // Background starts fading in at 25% visibility
                if (intersectionRatio >= 0.50 && !fadeSection.classList.contains('bg-visible')) {
                    fadeSection.classList.add('bg-visible');
                }
                
                // Content fades in slightly later for better effect
                if (intersectionRatio >= 0.4 && !fadeSection.classList.contains('content-visible')) {
                    fadeSection.classList.add('content-visible');
                }
            } else {
                // Optional: Remove classes when section is completely out of view
                // if (intersectionRatio === 0) {
                //     fadeSection.classList.remove('bg-visible', 'content-visible');
                // }
            }
        });
    }, observerOptions);

    fadeObserver.observe(fadeSection);
}
const slides = document.getElementById('slides');
const slideCount = slides.children.length;
let index = 0;

function showSlide(i) {
  index = (i + slideCount) % slideCount;
  slides.style.transform = `translateX(-${index * 100}%)`;
}

document.getElementById('prev').addEventListener('click', () => showSlide(index - 1));
document.getElementById('next').addEventListener('click', () => showSlide(index + 1));

// Auto-slide every 5 seconds
setInterval(() => showSlide(index + 1), 5000);
     // Scroll animation for book-now section
     document.addEventListener('DOMContentLoaded', function() {
        const bookNowSection = document.getElementById('book-now');
        
        // Function to check if element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 &&
                rect.bottom >= 0
            );
        }
        
        // Function to handle scroll event
        function handleScroll() {
            if (isInViewport(bookNowSection)) {
                bookNowSection.classList.add('visible');
                // Remove event listener after animation triggers
                window.removeEventListener('scroll', handleScroll);
            }
        }
        
        // Add scroll event listener
        window.addEventListener('scroll', handleScroll);
        
        // Check on initial load in case section is already in viewport
        handleScroll();
    });
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("show");
          }
        });
      }, { threshold: 0.2 });
      
      document.querySelectorAll(".fade-up").forEach(el => observer.observe(el));
      