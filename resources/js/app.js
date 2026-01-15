import "./bootstrap";
import "./flash";

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

Alpine.plugin(collapse);

window.Alpine = Alpine;

Alpine.start();

// Auto-attach flash to buttons with data-flash attribute
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-flash]").forEach((button) => {
        button.addEventListener("click", function (e) {
            if (!this.dataset.flash) return;

            const message =
                this.dataset.flashMessage || "Operation successful!";
            const type = this.dataset.flashType || "success";
            const duration = parseInt(this.dataset.flashDuration) || 5000;
            const description = this.dataset.flashDescription || "";

            if (window.flash) {
                window.flash(message, type, duration, description);
            }

            // Prevent default if it's a test button
            if (this.tagName === "BUTTON" && !this.type) {
                e.preventDefault();
            }
        });
    });
});
