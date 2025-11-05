(() => {
  // public/src/ts/app.ts
  (function() {
    "use strict";
    document.addEventListener("DOMContentLoaded", function() {
      initMobileMenu();
      initDropdownMenus();
      initAccessibility();
    });
    function initMobileMenu() {
      const menuToggle = document.querySelector(
        ".header__toggle"
      );
      const navigation = document.querySelector(".header__nav");
      const body = document.body;
      if (!menuToggle || !navigation) {
        return;
      }
      menuToggle.addEventListener("click", function() {
        const isExpanded = menuToggle.getAttribute("aria-expanded") === "true";
        menuToggle.setAttribute("aria-expanded", String(!isExpanded));
        navigation.classList.toggle("toggled");
        body.classList.toggle("menu-open");
      });
      document.addEventListener("click", function(event) {
        const target = event.target;
        if (!navigation.contains(target) && !menuToggle.contains(target)) {
          menuToggle.setAttribute("aria-expanded", "false");
          navigation.classList.remove("toggled");
          body.classList.remove("menu-open");
        }
      });
      document.addEventListener("keydown", function(event) {
        if (event.key === "Escape" && navigation.classList.contains("toggled")) {
          menuToggle.setAttribute("aria-expanded", "false");
          navigation.classList.remove("toggled");
          body.classList.remove("menu-open");
          menuToggle.focus();
        }
      });
    }
    function initDropdownMenus() {
      const menuItems = document.querySelectorAll(".header__menu li");
      menuItems.forEach(function(item) {
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
            link.addEventListener("click", function(e) {
              if (item.querySelector(".sub-menu")) {
                e.preventDefault();
                item.classList.toggle("focus");
              }
            });
          }
        }
      });
      window.addEventListener("resize", function() {
        if (window.innerWidth > 768) {
          menuItems.forEach(function(item) {
            item.classList.remove("focus");
          });
        }
      });
    }
    function initAccessibility() {
      const skipLink = document.querySelector(".skip-link");
      if (skipLink) {
        skipLink.addEventListener("click", function(e) {
          e.preventDefault();
          const href = skipLink.getAttribute("href");
          if (href) {
            const target = document.querySelector(href);
            if (target) {
              target.focus();
              target.scrollIntoView({ behavior: "smooth" });
            }
          }
        });
      }
      const menuLinks = document.querySelectorAll(".header__menu a");
      menuLinks.forEach(function(link) {
        link.addEventListener("focus", function() {
          const parentLi = link.closest("li");
          if (parentLi) {
            parentLi.classList.add("focus");
          }
        });
        link.addEventListener("blur", function() {
          const parentLi = link.closest("li");
          if (parentLi) {
            setTimeout(function() {
              if (!parentLi.querySelector(":focus")) {
                parentLi.classList.remove("focus");
              }
            }, 100);
          }
        });
      });
      const navigation = document.querySelector(".header__nav");
      if (navigation) {
        navigation.addEventListener("keydown", function(e) {
          const focusedElement = document.activeElement;
          const menuItems = Array.from(
            navigation.querySelectorAll("a")
          );
          const currentIndex = menuItems.indexOf(focusedElement);
          switch (e.key) {
            case "ArrowDown":
              e.preventDefault();
              const nextIndex = (currentIndex + 1) % menuItems.length;
              menuItems[nextIndex].focus();
              break;
            case "ArrowUp":
              e.preventDefault();
              const prevIndex = currentIndex > 0 ? currentIndex - 1 : menuItems.length - 1;
              menuItems[prevIndex].focus();
              break;
            case "ArrowRight":
              const submenu = focusedElement.parentElement?.querySelector(".sub-menu");
              if (submenu) {
                e.preventDefault();
                const firstSubmenuLink = submenu.querySelector(
                  "a"
                );
                if (firstSubmenuLink) {
                  firstSubmenuLink.focus();
                }
              }
              break;
            case "ArrowLeft":
              const parentMenu = focusedElement.closest(".sub-menu");
              if (parentMenu) {
                e.preventDefault();
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
    }
  })();
})();
//# sourceMappingURL=app.js.map
