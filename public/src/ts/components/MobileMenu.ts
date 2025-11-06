/**
 * Mobile Menu Component
 * Handles mobile navigation toggle, overlay, and interactions
 */

export class MobileMenu {
  private menuToggle: HTMLButtonElement | null;
  private mobileNav: HTMLElement | null;
  private overlay: HTMLElement | null;
  private body: HTMLElement;

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
  private init(): void {
    if (!this.menuToggle || !this.mobileNav || !this.overlay) {
      return;
    }

    this.bindEvents();
  }

  /**
   * Bind all event listeners
   */
  private bindEvents(): void {
    // Open/close menu with toggle button
    this.menuToggle?.addEventListener("click", () => this.toggleMenu());

    // Close menu when clicking overlay
    this.overlay?.addEventListener("click", () => this.closeMenu());

    // Close menu on escape key
    document.addEventListener("keydown", (event: KeyboardEvent) => {
      if (
        event.key === "Escape" &&
        this.mobileNav?.classList.contains("active")
      ) {
        this.closeMenu();
      }
    });
  }

  /**
   * Toggle menu open/close
   */
  private toggleMenu(): void {
    const isExpanded =
      this.menuToggle?.getAttribute("aria-expanded") === "true";

    if (isExpanded) {
      this.closeMenu();
    } else {
      this.openMenu();
    }
  }

  /**
   * Open mobile menu
   */
  private openMenu(): void {
    this.menuToggle?.setAttribute("aria-expanded", "true");
    this.menuToggle?.classList.add("active");
    this.mobileNav?.classList.add("active");
    this.overlay?.classList.add("active");
    this.body.classList.add("menu-open");
  }

  /**
   * Close mobile menu
   */
  private closeMenu(): void {
    this.menuToggle?.setAttribute("aria-expanded", "false");
    this.menuToggle?.classList.remove("active");
    this.mobileNav?.classList.remove("active");
    this.overlay?.classList.remove("active");
    this.body.classList.remove("menu-open");
  }
}
