// Wenn das DOM vollständig geladen ist, wird der Code ausgeführt
document.addEventListener("DOMContentLoaded", function() {

    // IntersectionObserver wird erstellt, um Animation beim Sichtbarwerden auszulösen
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    // Wenn ein Element sichtbar wird, bekommt es die Klasse 'show'
                    entry.target.classList.add("show");
                }
            });
        },
        {
            threshold: 0.3, // Nur auslösen, wenn 30% des Elements sichtbar sind
            rootMargin: "0px 0px -50px 0px" // Optionaler Versatz des Sichtbereichs
        }
    );

    // Alle Elemente mit der Klasse 'game-box' werden vom Observer überwacht
    document.querySelectorAll(".game-box").forEach((box) => {
        observer.observe(box);
    });
});

// Referenz zum Darkmode-Checkbox-Toggle
const toggle = document.getElementById("darkmode-toggle");
// Referenz auf das Body-Element
const body = document.body;

// Beim Laden der Seite prüfen, ob Darkmode in localStorage aktiviert ist
if (localStorage.getItem("darkmode") === "enabled") {
    body.classList.add("darkmode"); // Darkmode-Klasse aktivieren
    toggle.checked = true; // Toggle-Checkbox anhaken
}

// Listener für Änderung des Darkmode-Toggles
toggle.addEventListener("change", () => {
    if (toggle.checked) {
        // Darkmode aktivieren und im localStorage speichern
        body.classList.add("darkmode");
        localStorage.setItem("darkmode", "enabled");
    } else {
        // Darkmode deaktivieren und im localStorage speichern
        body.classList.remove("darkmode");
        localStorage.setItem("darkmode", "disabled");
    }
});

// Zeigt den Button mit der ID 'pay-button' an, indem die Klasse 'visible' hinzugefügt wird
document.getElementById('pay-button').classList.add('visible');
