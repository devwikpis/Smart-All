/**
 * Accessibility Component
 * Handles accessibility features like skip links and keyboard navigation
 */

export class Accessibility {
  private skipLink: HTMLAnchorElement | null;
  private navigation: HTMLElement | null;
  private menuLinks: NodeListOf<Element>;

  constructor() {
    this.skipLink = document.querySelector(".skip-link");
    this.navigation = document.querySelector(".header__nav");
    this.menuLinks = document.querySelectorAll(".header__menu a");
    this.init();
  }

  /**
   * Initialize accessibility features
   */
  private init(): void {
    this.handleSkipLink();
    this.improveKeyboardNavigation();
    this.handleArrowKeyNavigation();
  }

  /**
   * Handle skip link functionality
   */
  private handleSkipLink(): void {
    if (!this.skipLink) return;

    this.skipLink.addEventListener("click", (e: Event) => {
      e.preventDefault();
      const href = this.skipLink?.getAttribute("href");
      if (href) {
        const target = document.querySelector(href) as HTMLElement;
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
  private improveKeyboardNavigation(): void {
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
  private handleArrowKeyNavigation(): void {
    if (!this.navigation) return;

    this.navigation.addEventListener("keydown", (e: Event) => {
      const event = e as KeyboardEvent;
      const focusedElement = document.activeElement as HTMLElement;
      const menuItems = Array.from(
        this.navigation!.querySelectorAll("a")
      ) as HTMLElement[];
      const currentIndex = menuItems.indexOf(focusedElement);

      switch (event.key) {
        case "ArrowDown":
          event.preventDefault();
          const nextIndex = (currentIndex + 1) % menuItems.length;
          menuItems[nextIndex].focus();
          break;

        case "ArrowUp":
          event.preventDefault();
          const prevIndex =
            currentIndex > 0 ? currentIndex - 1 : menuItems.length - 1;
          menuItems[prevIndex].focus();
          break;

        case "ArrowRight":
          // Open submenu if available
          const submenu =
            focusedElement.parentElement?.querySelector(".sub-menu");
          if (submenu) {
            event.preventDefault();
            const firstSubmenuLink = submenu.querySelector("a") as HTMLElement;
            if (firstSubmenuLink) {
              firstSubmenuLink.focus();
            }
          }
          break;

        case "ArrowLeft":
          // Go back to parent menu
          const parentMenu = focusedElement.closest(".sub-menu");
          if (parentMenu) {
            event.preventDefault();
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
