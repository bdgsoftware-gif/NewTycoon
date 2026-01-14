document.addEventListener("submit", function (event) {
    const form = event.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (!form.hasAttribute("data-form")) return;

    // 1️⃣ Browser validation
    if (!form.checkValidity()) {
        event.preventDefault();
        form.reportValidity();
        return;
    }

    // 2️⃣ Custom validation hook (optional)
    // if (!runCustomValidation(form)) {
    //     event.preventDefault();
    //     return;
    // }

    // 3️⃣ Lock submit buttons
    const buttons = form.querySelectorAll(
        'button[type="submit"][data-loading]'
    );

    buttons.forEach((button) => {
        if (button.disabled) return;

        button.disabled = true;
        button.setAttribute("aria-busy", "true");
        button.classList.add("opacity-70", "cursor-not-allowed");

        const text = button.dataset.loadingText || "Processing...";

        button.innerHTML = `
            <span class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"
                        fill="none" opacity="0.25"></circle>
                    <path d="M4 12a8 8 0 018-8"
                        stroke="currentColor" stroke-width="4"
                        fill="none"></path>
                </svg>
                ${text}
            </span>
        `;
    });
});

/* ---------- Custom validation layer ---------- */
// function runCustomValidation(form) {
//     // Example: featured images
//     const featuredInput = form.querySelector("#featured_images");

//     if (featuredInput && featuredInput.files.length === 0) {
//         alert("Please upload at least one featured image");
//         return false;
//     }

//     return true;
// }
