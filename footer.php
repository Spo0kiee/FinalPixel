<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-links">
            <a href="Footer/Support.html">Support Hub</a>
            <a href="Footer/Sicherheitstipps.html">Sicherheitstipps</a>
            <a href="Footer/AGB.html">AGB</a>
            <a href="Footer/Datenschutz.html">Datenschutz & Cookies</a>
            <a href="Footer/Rückgabe.html">Rückgabe & Erstattung</a>

        </div>
        <div class="footer-info">
            <p>&copy; <?php echo date('Y'); ?> FinalPixel. Alle Rechte vorbehalten.</p>
            <p>Entwickelt von Luka Djekic</p>
        </div>
    </div>
</footer>
