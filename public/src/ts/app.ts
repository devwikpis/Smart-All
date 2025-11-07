/**
 * Main Application Entry Point
 * UAmericas Theme - TypeScript
 */

// Import styles
import "../styles/style.scss";

// Import components
import { MobileMenu, DropdownMenu, Accessibility } from "./components";
import "./components/Swipers";
/**
 * Initialize application
 */
class App {
  constructor() {
    this.init();
  }

  /**
   * Initialize all components when DOM is ready
   */
  private init(): void {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () =>
        this.initComponents()
      );
    } else {
      this.initComponents();
    }
  }

  /**
   * Initialize all components
   */
  private initComponents(): void {
    new MobileMenu();
    new DropdownMenu();
    new Accessibility();
  }
}

// Start the application
new App();
