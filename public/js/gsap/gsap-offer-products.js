document.addEventListener("DOMContentLoaded", () => {
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    gsap.registerPlugin(ScrollTrigger);

    const section = document.querySelector(".offer-products-swiper");
    if (!section) return;

    const container = section.closest("section");
    const banner = container.querySelector(".offer-products-banner-content"); // banner content
    const timer = container.querySelector("#offer-timer");
    const slides = section.querySelectorAll(".swiper-slide");

    // Initial states
    gsap.set(banner, { opacity: 0, y: 40 });
    if (timer) gsap.set(timer, { opacity: 0, scale: 0.9 });
    gsap.set(slides, { opacity: 0, y: 30 });

    gsap.timeline({
        scrollTrigger: {
            trigger: container,
            start: "top 70%",
            once: true,
        },
    })
        .to(banner, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: "power3.out",
        })
        .to(
            timer,
            {
                opacity: 1,
                scale: 1,
                duration: 0.4,
                ease: "back.out(1.7)",
            },
            "-=0.4"
        )
        .to(
            slides,
            {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: "power3.out",
                stagger: 0.06,
            },
            "-=0.3"
        );
});
