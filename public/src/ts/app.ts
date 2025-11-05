/**
 * Header Navigation JavaScript - Starter Theme
 * Handles mobile menu toggle and responsive navigation
 */

// Import styles
import "../styles/style.scss";

(function () {
  "use strict";

  // Wait for DOM to be ready
  document.addEventListener("DOMContentLoaded", function () {
    initMobileMenu();
    initDropdownMenus();
    initAccessibility();
  });

  /**
   * Initialize mobile menu functionality
   */
  function initMobileMenu(): void {
    const menuToggle = document.querySelector(
      ".header__toggle"
    ) as HTMLButtonElement;
    const navigation = document.querySelector(".header__nav") as HTMLElement;
    const body = document.body;

    if (!menuToggle || !navigation) {
      return;
    }

    menuToggle.addEventListener("click", function () {
      const isExpanded = menuToggle.getAttribute("aria-expanded") === "true";

      // Toggle aria-expanded
      menuToggle.setAttribute("aria-expanded", String(!isExpanded));

      // Toggle navigation visibility
      navigation.classList.toggle("toggled");

      // Toggle body class to prevent scrolling
      body.classList.toggle("menu-open");
    });

    // Close menu when clicking outside
    document.addEventListener("click", function (event: MouseEvent) {
      const target = event.target as Node;
      if (!navigation.contains(target) && !menuToggle.contains(target)) {
        menuToggle.setAttribute("aria-expanded", "false");
        navigation.classList.remove("toggled");
        body.classList.remove("menu-open");
      }
    });

    // Close menu on escape key
    document.addEventListener("keydown", function (event: KeyboardEvent) {
      if (event.key === "Escape" && navigation.classList.contains("toggled")) {
        menuToggle.setAttribute("aria-expanded", "false");
        navigation.classList.remove("toggled");
        body.classList.remove("menu-open");
        menuToggle.focus();
      }
    });
  }

  /**
   * Initialize dropdown menu functionality for desktop
   */
  function initDropdownMenus(): void {
    const menuItems = document.querySelectorAll(".header__menu li");

    menuItems.forEach(function (item) {
      const submenu = item.querySelector(".sub-menu");
      const link = item.querySelector("a");

      if (submenu && link) {
        // Add dropdown indicator
        if (!link.querySelector(".dropdown-indicator")) {
          const indicator = document.createElement("span");
          indicator.className = "dropdown-indicator";
          indicator.setAttribute("aria-hidden", "true");
          indicator.textContent = "▼";
          link.appendChild(indicator);
        }

        // Handle mobile dropdown toggle
        if (window.innerWidth <= 768) {
          link.addEventListener("click", function (e: Event) {
            if (item.querySelector(".sub-menu")) {
              e.preventDefault();
              item.classList.toggle("focus");
            }
          });
        }
      }
    });

    // Handle window resize
    window.addEventListener("resize", function () {
      if (window.innerWidth > 768) {
        // Remove mobile-specific classes on desktop
        menuItems.forEach(function (item) {
          item.classList.remove("focus");
        });
      }
    });
  }

  /**
   * Initialize accessibility features
   */
  function initAccessibility(): void {
    // Handle skip link
    const skipLink = document.querySelector(".skip-link") as HTMLAnchorElement;
    if (skipLink) {
      skipLink.addEventListener("click", function (e: Event) {
        e.preventDefault();
        const href = skipLink.getAttribute("href");
        if (href) {
          const target = document.querySelector(href) as HTMLElement;
          if (target) {
            target.focus();
            target.scrollIntoView({ behavior: "smooth" });
          }
        }
      });
    }

    // Improve keyboard navigation for menu items
    const menuLinks = document.querySelectorAll(".header__menu a");
    menuLinks.forEach(function (link) {
      link.addEventListener("focus", function () {
        // Add focus class to parent li for styling
        const parentLi = link.closest("li");
        if (parentLi) {
          parentLi.classList.add("focus");
        }
      });

      link.addEventListener("blur", function () {
        // Remove focus class after a short delay to allow for submenu navigation
        const parentLi = link.closest("li");
        if (parentLi) {
          setTimeout(function () {
            if (!parentLi.querySelector(":focus")) {
              parentLi.classList.remove("focus");
            }
          }, 100);
        }
      });
    });

    // Handle arrow key navigation in menus
    const navigation = document.querySelector(".header__nav");
    if (navigation) {
      navigation.addEventListener("keydown", function (e: KeyboardEvent) {
        const focusedElement = document.activeElement as HTMLElement;
        const menuItems = Array.from(
          navigation.querySelectorAll("a")
        ) as HTMLElement[];
        const currentIndex = menuItems.indexOf(focusedElement);

        switch (e.key) {
          case "ArrowDown":
            e.preventDefault();
            const nextIndex = (currentIndex + 1) % menuItems.length;
            menuItems[nextIndex].focus();
            break;
          case "ArrowUp":
            e.preventDefault();
            const prevIndex =
              currentIndex > 0 ? currentIndex - 1 : menuItems.length - 1;
            menuItems[prevIndex].focus();
            break;
          case "ArrowRight":
            // Open submenu if available
            const submenu =
              focusedElement.parentElement?.querySelector(".sub-menu");
            if (submenu) {
              e.preventDefault();
              const firstSubmenuLink = submenu.querySelector(
                "a"
              ) as HTMLElement;
              if (firstSubmenuLink) {
                firstSubmenuLink.focus();
              }
            }
            break;
          case "ArrowLeft":
            // Go back to parent menu
            const parentMenu = focusedElement.closest(".sub-menu");
            if (parentMenu) {
              e.preventDefault();
              const parentLink = parentMenu.parentElement?.querySelector(
                "a"
              ) as HTMLElement;
              if (parentLink) {
                parentLink.focus();
              }
            }
            break;
        }
      });
    }
  }
})();
