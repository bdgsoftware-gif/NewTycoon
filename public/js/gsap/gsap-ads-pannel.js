document.addEventListener("DOMContentLoaded", () => {
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    gsap.registerPlugin(ScrollTrigger);

    const section = document.querySelector(".adsSwiper");
    if (!section) return;

    gsap.from(section, {
        opacity: 0,
        y: 30,
        duration: 0.8,
        ease: "power3.out",
        scrollTrigger: {
            trigger: section,
            start: "top 75%",
            once: true,
        },
    });
});
