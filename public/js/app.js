(() => {
  // public/src/ts/components/MobileMenu.ts
  var MobileMenu = class {
    constructor() {
      this.menuToggle = document.querySelector(".header__toggle");
      this.mobileNav = document.querySelector(".header__nav--mobile");
      this.overlay = document.querySelector(".menu-overlay");
      this.body = document.body;
      this.init();
    }
    /**
     * Initialize mobile menu functionality
     */
    init() {
      if (!this.menuToggle || !this.mobileNav || !this.overlay) {
        return;
      }
      this.bindEvents();
    }
    /**
     * Bind all event listeners
     */
    bindEvents() {
      this.menuToggle?.addEventListener("click", () => this.toggleMenu());
      this.overlay?.addEventListener("click", () => this.closeMenu());
      document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && this.mobileNav?.classList.contains("active")) {
          this.closeMenu();
        }
      });
    }
    /**
     * Toggle menu open/close
     */
    toggleMenu() {
      const isExpanded = this.menuToggle?.getAttribute("aria-expanded") === "true";
      if (isExpanded) {
        this.closeMenu();
      } else {
        this.openMenu();
      }
    }
    /**
     * Open mobile menu
     */
    openMenu() {
      this.menuToggle?.setAttribute("aria-expanded", "true");
      this.menuToggle?.classList.add("active");
      this.mobileNav?.classList.add("active");
      this.overlay?.classList.add("active");
      this.body.classList.add("menu-open");
    }
    /**
     * Close mobile menu
     */
    closeMenu() {
      this.menuToggle?.setAttribute("aria-expanded", "false");
      this.menuToggle?.classList.remove("active");
      this.mobileNav?.classList.remove("active");
      this.overlay?.classList.remove("active");
      this.body.classList.remove("menu-open");
    }
  };

  // public/src/ts/components/DropdownMenu.ts
  var DropdownMenu = class {
    constructor() {
      this.menuItems = document.querySelectorAll(".header__menu li");
      this.init();
    }
    /**
     * Initialize dropdown menu functionality
     */
    init() {
      this.setupDropdowns();
      this.handleResize();
    }
    /**
     * Setup dropdown indicators and mobile interactions
     */
    setupDropdowns() {
      this.menuItems.forEach((item) => {
        const submenu = item.querySelector(".sub-menu");
        const link = item.querySelector("a");
        if (submenu && link) {
          if (!link.querySelector(".dropdown-indicator")) {
            const indicator = document.createElement("span");
            indicator.className = "dropdown-indicator";
            indicator.setAttribute("aria-hidden", "true");
            indicator.textContent = "\u25BC";
            link.appendChild(indicator);
          }
          if (window.innerWidth <= 768) {
            link.addEventListener("click", (e) => {
              if (item.querySelector(".sub-menu")) {
                e.preventDefault();
                item.classList.toggle("focus");
              }
            });
          }
        }
      });
    }
    /**
     * Handle window resize
     */
    handleResize() {
      window.addEventListener("resize", () => {
        if (window.innerWidth > 768) {
          this.menuItems.forEach((item) => {
            item.classList.remove("focus");
          });
        }
      });
    }
  };

  // public/src/ts/components/Accessibility.ts
  var Accessibility = class {
    constructor() {
      this.skipLink = document.querySelector(".skip-link");
      this.navigation = document.querySelector(".header__nav");
      this.menuLinks = document.querySelectorAll(".header__menu a");
      this.init();
    }
    /**
     * Initialize accessibility features
     */
    init() {
      this.handleSkipLink();
      this.improveKeyboardNavigation();
      this.handleArrowKeyNavigation();
    }
    /**
     * Handle skip link functionality
     */
    handleSkipLink() {
      if (!this.skipLink)
        return;
      this.skipLink.addEventListener("click", (e) => {
        e.preventDefault();
        const href = this.skipLink?.getAttribute("href");
        if (href) {
          const target = document.querySelector(href);
          if (target) {
            target.focus();
            target.scrollIntoView({ behavior: "smooth" });
          }
        }
      });
    }
    /**
     * Improve keyboard navigation for menu items
     */
    improveKeyboardNavigation() {
      this.menuLinks.forEach((link) => {
        link.addEventListener("focus", () => {
          const parentLi = link.closest("li");
          if (parentLi) {
            parentLi.classList.add("focus");
          }
        });
        link.addEventListener("blur", () => {
          const parentLi = link.closest("li");
          if (parentLi) {
            setTimeout(() => {
              if (!parentLi.querySelector(":focus")) {
                parentLi.classList.remove("focus");
              }
            }, 100);
          }
        });
      });
    }
    /**
     * Handle arrow key navigation in menus
     */
    handleArrowKeyNavigation() {
      if (!this.navigation)
        return;
      this.navigation.addEventListener("keydown", (e) => {
        const event = e;
        const focusedElement = document.activeElement;
        const menuItems = Array.from(
          this.navigation.querySelectorAll("a")
        );
        const currentIndex = menuItems.indexOf(focusedElement);
        switch (event.key) {
          case "ArrowDown":
            event.preventDefault();
            const nextIndex = (currentIndex + 1) % menuItems.length;
            menuItems[nextIndex].focus();
            break;
          case "ArrowUp":
            event.preventDefault();
            const prevIndex = currentIndex > 0 ? currentIndex - 1 : menuItems.length - 1;
            menuItems[prevIndex].focus();
            break;
          case "ArrowRight":
            const submenu = focusedElement.parentElement?.querySelector(".sub-menu");
            if (submenu) {
              event.preventDefault();
              const firstSubmenuLink = submenu.querySelector("a");
              if (firstSubmenuLink) {
                firstSubmenuLink.focus();
              }
            }
            break;
          case "ArrowLeft":
            const parentMenu = focusedElement.closest(".sub-menu");
            if (parentMenu) {
              event.preventDefault();
              const parentLink = parentMenu.parentElement?.querySelector(
                "a"
              );
              if (parentLink) {
                parentLink.focus();
              }
            }
            break;
        }
      });
    }
  };

  // public/src/ts/app.ts
  var App = class {
    constructor() {
      this.init();
    }
    /**
     * Initialize all components when DOM is ready
     */
    init() {
      if (document.readyState === "loading") {
        document.addEventListener(
          "DOMContentLoaded",
          () => this.initComponents()
        );
      } else {
        this.initComponents();
      }
    }
    /**
     * Initialize all components
     */
    initComponents() {
      new MobileMenu();
      new DropdownMenu();
      new Accessibility();
    }
  };
  new App();
})();
//# sourceMappingURL=app.js.map
