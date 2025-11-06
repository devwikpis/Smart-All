/**
 * Dropdown Menu Component
 * Handles dropdown menu functionality for desktop navigation
 */

export class DropdownMenu {
  private menuItems: NodeListOf<Element>;

  constructor() {
    this.menuItems = document.querySelectorAll(".header__menu li");
    this.init();
  }

  /**
   * Initialize dropdown menu functionality
   */
  private init(): void {
    this.setupDropdowns();
    this.handleResize();
  }

  /**
   * Setup dropdown indicators and mobile interactions
   */
  private setupDropdowns(): void {
    this.menuItems.forEach((item) => {
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
          link.addEventListener("click", (e: Event) => {
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
  private handleResize(): void {
    window.addEventListener("resize", () => {
      if (window.innerWidth > 768) {
        // Remove mobile-specific classes on desktop
        this.menuItems.forEach((item) => {
          item.classList.remove("focus");
        });
      }
    });
  }
}
