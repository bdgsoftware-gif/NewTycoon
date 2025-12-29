document.addEventListener("DOMContentLoaded", () => {
    // Disable on reduced motion
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    gsap.registerPlugin(ScrollTrigger);

    // ============= CATEGORIES SECTION =============
    if (!window.matchMedia("(pointer: coarse)").matches) {
        const section = document.querySelector(".category-section");
        if (!section) return;

        const heading = section.querySelector(".category-heading");
        const cards = section.querySelectorAll(".category-tilt");

        // Initial states
        gsap.set(section, { opacity: 0 });
        gsap.set(heading, { y: 40, opacity: 0 });
        gsap.set(cards, {
            y: 40,
            opacity: 0,
            scale: 1,
        });

        // Animate abstract background blobs only (more specific selector)
        const blobs = section.querySelectorAll(
            ".absolute.-top-4, .absolute.-bottom-4"
        );

        blobs.forEach((blob) => {
            gsap.fromTo(
                blob,
                { y: 0 },
                {
                    y: -20,
                    scrollTrigger: {
                        trigger: section,
                        start: "top bottom",
                        end: "bottom top",
                        scrub: true,
                    },
                }
            );
        });

        // Timeline for section entrance
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: "top 75%",
                end: "bottom 60%",
                toggleActions: "play none none reverse",
            },
        });

        tl.to(section, {
            opacity: 1,
            duration: 0.4,
            ease: "power1.out",
        })
            .to(
                heading,
                {
                    y: 0,
                    opacity: 1,
                    duration: 0.6,
                    ease: "power3.out",
                },
                "-=0.2"
            )
            .to(
                cards,
                {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 0.6,
                    ease: "power3.out",
                    stagger: 0.08,
                },
                "-=0.3"
            );

        // 3D tilt effect for cards
        cards.forEach((card) => {
            const inner = card.querySelector(".category-tilt-inner");
            if (!inner) return;

            // 3D context
            gsap.set(card, {
                perspective: 800,
            });

            gsap.set(inner, {
                transformStyle: "preserve-3d",
                willChange: "transform",
            });

            // Quick setters
            const rotateX = gsap.quickTo(inner, "rotationX", {
                duration: 0.6,
                ease: "power3.out",
            });

            const rotateY = gsap.quickTo(inner, "rotationY", {
                duration: 0.6,
                ease: "power3.out",
            });

            const moveZ = gsap.quickTo(inner, "z", {
                duration: 0.6,
                ease: "power3.out",
            });

            card.addEventListener("pointermove", (e) => {
                const bounds = card.getBoundingClientRect();

                const relX = e.clientX - bounds.left;
                const relY = e.clientY - bounds.top;

                const percentX = relX / bounds.width;
                const percentY = relY / bounds.height;

                const tiltX = gsap.utils.interpolate(15, -15, percentY);
                const tiltY = gsap.utils.interpolate(-15, 15, percentX);

                rotateX(tiltX);
                rotateY(tiltY);
                moveZ(40);
            });

            card.addEventListener("pointerleave", () => {
                rotateX(0);
                rotateY(0);
                moveZ(0);
            });
        });
    }
});
