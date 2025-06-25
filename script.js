document.addEventListener("DOMContentLoaded", function() {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                }
            });
        },
        {
            threshold: 0.3, // Trigger when 30% visible
            rootMargin: "0px 0px -50px 0px" // Adjusts trigger point (optional)
        }
    );

    // Observe all game boxes
    document.querySelectorAll(".game-box").forEach((box) => {
        observer.observe(box);
    });
});

    const toggle = document.getElementById("darkmode-toggle");
    const body = document.body;

    // Darkmode speichern & laden
    if (localStorage.getItem("darkmode") === "enabled") {
        body.classList.add("darkmode");
        toggle.checked = true;
    }

    toggle.addEventListener("change", () => {
        if (toggle.checked) {
            body.classList.add("darkmode");
            localStorage.setItem("darkmode", "enabled");
        } else {
            body.classList.remove("darkmode");
            localStorage.setItem("darkmode", "disabled");
        }
    });

    document.getElementById('pay-button').classList.add('visible');

