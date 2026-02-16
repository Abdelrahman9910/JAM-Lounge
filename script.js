document.addEventListener("DOMContentLoaded", () => {
    /* ----------------------------
      Helpers
    ---------------------------- */
    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
  
    /* ----------------------------
      Navbar hide + hamburger show (if exists)
    ---------------------------- */
    const navbar = $(".navbar");
    const hamburger = $(".hamburger");
  
    window.addEventListener("scroll", () => {
      if (!navbar || !hamburger) return;
  
      if (window.scrollY > 100) {
        navbar.classList.add("hidden");
        hamburger.classList.add("show");
      } else {
        navbar.classList.remove("hidden");
        hamburger.classList.remove("show");
      }
    });
  
    /* ----------------------------
      Side nav open/close (if exists)
    ---------------------------- */
    const sideNav = $(".side-nav");
    const overlay = $(".overlay");
  
    const openNavigation = () => {
      if (!hamburger || !sideNav || !overlay) return;
      hamburger.classList.add("active");
      sideNav.classList.add("active");
      overlay.classList.add("active");
      document.body.style.overflow = "hidden";
    };
  
    const closeNavigation = () => {
      if (!hamburger || !sideNav || !overlay) return;
      hamburger.classList.remove("active");
      sideNav.classList.remove("active");
      overlay.classList.remove("active");
      document.body.style.overflow = "";
    };
  
    if (hamburger) {
      hamburger.addEventListener("click", (e) => {
        e.stopPropagation();
        if (hamburger.classList.contains("active")) closeNavigation();
        else openNavigation();
      });
    }
  
    if (overlay) overlay.addEventListener("click", closeNavigation);
  
    $$(".side-nav a").forEach((link) => link.addEventListener("click", closeNavigation));
  
    if (sideNav) sideNav.addEventListener("click", (e) => e.stopPropagation());
  
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeNavigation();
    });
  
    /* ----------------------------
      Fade-up sections (if exists)
    ---------------------------- */
    const fadeUpEls = $$(".fade-up");
    if (fadeUpEls.length) {
      const fadeObserver = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) entry.target.classList.add("show");
          });
        },
        { threshold: 0.2 }
      );
  
      fadeUpEls.forEach((el) => fadeObserver.observe(el));
    }
  
    /* ----------------------------
      Animated section (if exists)
    ---------------------------- */
    const animatedSection = $(".animated-section");
    const contentBoxes = $$(".content-box");
    if (animatedSection && contentBoxes.length) {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              contentBoxes.forEach((box) => {
                box.classList.remove("fading-out");
                box.classList.add("active");
              });
            } else {
              contentBoxes.forEach((box) => {
                box.classList.remove("active");
                box.classList.add("fading-out");
              });
            }
          });
        },
        { threshold: 0.15 }
      );
  
      observer.observe(animatedSection);
    }
  
    /* ----------------------------
      Fade section background/content (if exists)
    ---------------------------- */
    const fadeSection = $(".fade-section");
    if (fadeSection) {
      const fadeObserver2 = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            const r = entry.intersectionRatio;
            if (entry.isIntersecting) {
              if (r >= 0.5) fadeSection.classList.add("bg-visible");
              if (r >= 0.4) fadeSection.classList.add("content-visible");
            }
          });
        },
        { threshold: [0, 0.25, 0.4, 0.5, 1] }
      );
      fadeObserver2.observe(fadeSection);
    }
  
    /* ----------------------------
      Book-now visibility (if exists)
    ---------------------------- */
    const bookNowSection = $("#book-now");
    if (bookNowSection) {
      const isInViewport = (el) => {
        const rect = el.getBoundingClientRect();
        return rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 && rect.bottom >= 0;
      };
  
      const handleScroll = () => {
        if (isInViewport(bookNowSection)) {
          bookNowSection.classList.add("visible");
          window.removeEventListener("scroll", handleScroll);
        }
      };
  
      window.addEventListener("scroll", handleScroll);
      handleScroll();
    }
  
    /* ----------------------------
      Review slider (if exists)
      Requires: <div id="slides" class="slides"> ... </div>
               buttons: #prev, #next (optional)
    ---------------------------- */
    const slidesEl = $("#slides");
    if (slidesEl) {
      const prevBtn = $("#prev");
      const nextBtn = $("#next");
      const slideCount = slidesEl.children.length;
  
      let currentIndex = 0;
      const showSlide = (i) => {
        if (!slideCount) return;
        currentIndex = (i + slideCount) % slideCount;
        slidesEl.style.transform = `translateX(-${currentIndex * 100}%)`;
      };
  
      if (prevBtn) prevBtn.addEventListener("click", () => showSlide(currentIndex - 1));
      if (nextBtn) nextBtn.addEventListener("click", () => showSlide(currentIndex + 1));
  
      // start
      showSlide(0);
      setInterval(() => showSlide(currentIndex + 1), 5000);
    }
  
    /* ----------------------------
      ✅ Language dropdown FIX (works inside .scrollmenu on mobile)
      Moves dropdown panel to <body> so no overflow can clip it.
    ---------------------------- */
    const dropdowns = $$(".lang-dropdown");
  
    // keep track of moved panels
    const portals = new Map();
  
    const closeAllDropdowns = () => {
      dropdowns.forEach((dd) => dd.classList.remove("open"));
  
      // move any portal panels back
      portals.forEach((info, dd) => {
        const { panel } = info;
        if (!panel) return;
        dd.appendChild(panel);
        panel.classList.remove("dropdown-portal");
        panel.style.left = "";
        panel.style.top = "";
        panel.style.right = "";
        panel.style.bottom = "";
        panel.style.position = "";
        portals.delete(dd);
      });
    };
  
    const openDropdown = (dd) => {
      const btn = $(".dropbtn", dd);
      const panel = $(".dropdown-content", dd);
      if (!btn || !panel) return;
  
      dd.classList.add("open");
  
      // move panel to body to avoid clipping
      document.body.appendChild(panel);
      panel.classList.add("dropdown-portal");
  
      // position under the button
      const rect = btn.getBoundingClientRect();
      const top = rect.bottom + 6;
      const right = window.innerWidth - rect.right;
  
      panel.style.position = "fixed";
      panel.style.top = `${top}px`;
      panel.style.right = `${right}px`;
  
      portals.set(dd, { panel, btn });
    };
  
    dropdowns.forEach((dd) => {
      const btn = $(".dropbtn", dd);
      if (!btn) return;
  
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
  
        const isOpen = dd.classList.contains("open");
        closeAllDropdowns();
        if (!isOpen) openDropdown(dd);
      });
    });
  
    // close on outside click
    document.addEventListener("click", () => closeAllDropdowns());
  
    // close on scroll/resize (important on mobile)
    window.addEventListener("scroll", () => closeAllDropdowns(), { passive: true });
    window.addEventListener("resize", () => closeAllDropdowns());
  });
  