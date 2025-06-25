<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinalPixel - Startseite</title>
    <link rel="stylesheet" href="Styles.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=EB+Garamond&display=swap" rel="stylesheet">
<style>
        /* Allgemeine Stile */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url(http://localhost/FinalPixel/pictures/medieval_background.jpg);
     background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    min-height: 130vh; /* <-- das ist der gute Stoff */
    color: #130e0e;
    scroll-behavior: smooth;
}

</style>
</head>

<body>
<!-- Header -->
<header>
    <?php include 'header.php'; ?>
</header>  
<!-- Hauptbereich -->
    <main>
    <div class="game-foreshow">
    <div class="game-window">
        <a href="produkt.php?artikelnummer=22">
            <img src="http://localhost/FinalPixel/pictures/KingdomCome.jpg" alt="Kingdom Come: Deliverance">
        </a>
    </div>
    <div class="game-window">
        <a href="produkt.php?artikelnummer=21">
            <img src="http://localhost/FinalPixel/pictures/Avowed.jpg" alt="Avowed">
        </a>
    </div>
    <div class="game-window">
        <a href="produkt.php?artikelnummer=23">
            <img src="http://localhost/FinalPixel/pictures/SIDMEIERS.jpg" alt="Sid Meier's Civilization VI">
        </a>
    </div>
    <div class="game-window">
        <a href="produkt.php?artikelnummer=24">
            <img src="http://localhost/FinalPixel/pictures/Microsoft_Office_Professional.jpg" alt="Microsoft Office Professional">
        </a>
    </div>
</div>

  <section class="platform-selection">
    <h2>Wähle deine Plattform</h2>
    <div class="platforms-container">
        <a href="/FinalPixel/plattform.php?plattform=PC" class="platform-button">
            <img src="/FinalPixel/pictures/pc_icon.png" alt="PC">
            <span>PC</span>
        </a>
        <a href="/FinalPixel/plattform.php?plattform=Xbox" class="platform-button">
            <img src="/FinalPixel/pictures/xbox_icon.png" alt="Xbox">
            <span>Xbox</span>
        </a>
        <a href="/FinalPixel/plattform.php?plattform=PS" class="platform-button">
            <img src="/FinalPixel/pictures/playstation_icon.png" alt="Playstation">
            <span>Playstation</span>
        </a>
        <a href="/FinalPixel/plattform.php?plattform=Switch" class="platform-button">
            <img src="/FinalPixel/pictures/nintendo_icon.png" alt="Nintendo">
            <span>Nintendo</span>
        </a>
    </div>
</section>


        <!-- Kategorie-Bar -->
        <div class="category-bar">
            <ul>
                <li><a href="#bestsellers">Bestsellers</a></li>
                <li><a href="#Veröffentlichungen">Kommende Veröffentlichungen <span class="fire-emoji">🔥</span></a></li>
                <li><a href="#CS2 Cases">CS2 Cases</a></li>
                <li><a href="#Promotion">Promotion</a></li>
                <li><a href="#flash-deal">Flash Deal</a></li>
                <li><a href="#software">Software</a></li>
                <li><a href="#trending">Trending Categories</a></li>
            </ul>
        </div>
 
        <?php
        // 1) Mit Datenbank verbinden
        require_once 'db_connect.php'; 

        // 2) 6 zufällige Produkte abfragen
        $sql = "SELECT * FROM produkte ORDER BY RAND() LIMIT 6";
        $result = $conn->query($sql);
        $bestseller = $result->fetch_all(MYSQLI_ASSOC);            
        ?>

        <!-- 3) Bestseller-Bereich -->
        <div class="section-title" id="bestsellers">
            <h1>Bestseller</h1>
            <p>Die beliebtesten Artikel auf unserem Marktplatz – entdecken Sie, was die Herzen unserer Nutzer erobert hat!</p>

            <div class="bestseller-list">
                <?php foreach ($bestseller as $produkt): ?>
                    <div class="bestseller-item">
                        <!-- Bild des Produkts -->
                        <a href="produkt.php?artikelnummer=<?php echo $produkt['Artikelnummer']; ?>">
                          <img 
                          src="<?php echo htmlspecialchars($produkt['bild_url']); ?>" 
                          alt="<?php echo htmlspecialchars($produkt['Name']); ?>">
                        </a>
                        <!-- Name des Produkts -->
                        <h3><?php echo htmlspecialchars($produkt['Name']); ?></h3>
                        <!-- Preis des Produkts -->
                        <p><?php echo number_format($produkt['Preis'], 2); ?> €</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
                <!-- FinalPixel Promo-Bereich -->
                <div class="promo-container" id="Promotion">
                    <div class="promo-item">
                        <img src="http://localhost/FinalPixel/pictures/QR.png" alt="App Icon" class="promo-icon">
                        <div class="promo-text">
                            <h3>Hol dir die FinalPixel-App</h3>
                            <p>Lade sie jetzt herunter und sichere dir exklusive Angebote.</p>
                        </div>
                    </div>

                    <div class="promo-item">
                        <img src="http://localhost/FinalPixel/pictures/Scroll.png" alt="Newsletter Icon" class="promo-icon">
                        <div class="promo-text">
                            <h3>Abonniere unseren Newsletter</h3>
                            <p>Erhalte 10 % Rabatt auf deinen nächsten Einkauf.</p>
                        </div>
                    </div>

                    <div class="promo-item">
                        <img src="http://localhost/FinalPixel/pictures/Deal.png" alt="Discount Icon" class="promo-icon">
                        <div class="promo-text">
                            <h3>Mehr sparen mit FinalPixel+</h3>
                            <p>Profitiere von exklusiven Vorteilen und Sonderangeboten.</p>
                        </div>
                    </div>
                </div>
                <h2 class="section-title">Kommende Veröffentlichungen</h2>

                <div class="games-container" id="Veröffentlichungen">
                    <div class="game-box left">
                        <div class="content">
                            <h3>Avowed</h3>
                            <p>Preis: 59.99€</p>
                            <a href="produkt.php?artikelnummer=21" class="btn">In den Warenkorb</a>
                        </div>
                    </div>
                    <div class="game-box right">
                        <div class="content">
                            <h3>Kingdom Come: Deliverance 2</h3>
                            <p>Preis: 49.99€</p>
                            <a href="produkt.php?artikelnummer=22" class="btn">In den Warenkorb</a>
                        </div>
                    </div>
                </div>
            
            <h2 class="section-title">CS2 Cases</h2>
            <div class="Cases-section" id="CS2 Cases">
                <div class="Case-container">
                    <a href="produkt.php?artikelnummer=26">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/Glove_Case.png" alt="Glove Case">
                    </a>
                </div>
                <div class="Case-container">
                    <a href="produkt.php?artikelnummer=27">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/CS20_Case.png" alt="CS20 Case">
                    </a>
                </div>
                <div class="Case-container">  
                    <a href="produkt.php?artikelnummer=28">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/CS_GO_Weapon_Case_3.png" alt="CSGO Weapon Case 3">
                    </a>
                </div>
                <div class="Case-container">
                    <a href="produkt.php?artikelnummer=29">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/Danger_Zone_Case.png" alt="Danger Zone Case">
                    </a>
                </div>
                <div class="Case-container">
                    <a href="produkt.php?artikelnummer=30">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/Dreams_&_Nightmares_Case.png" alt="Dreams & Nightmares Case">
                    </a>
                </div>
                <div class="Case-container">
                    <a href="produkt.php?artikelnummer=31">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/Falchion_Case.png" alt="Falchion Case">
                    </a>
                </div>
                <div class="Case-container">
                    <a href="produkt.php?artikelnummer=32">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/Fracture_Case.png" alt="Fracture Case">
                    </a>
                </div>
                <div class="Case-container">
                    <a href="produkt.php?artikelnummer=33">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/Operation_Breakout_Weapon_Case.png" alt="Operation Breakout Weapon Case">
                    </a>
                </div>
                <div class="Case-container">
                    <a href="produkt.php?artikelnummer=34">
                        <img src="http://localhost/FinalPixel/pictures/CS2 Cases/Operation_Vanguard_Weapon_Case.png" alt="Operation Vanguard Weapon Case">
                    </a>
                </div>
            </div>

            <h2 class="section-title">Software Deals</h2>
            <div class="software-deals" id="software">
                <div class="software-item">
                    <a href="produkt.php?artikelnummer=36">
                        <img src="http://localhost/FinalPixel/pictures/Windows11_Pro.jpg" alt="Microsoft Windows 11 Pro">
                    </a>
                </div>
                <div class="software-item">
                    <a href="produkt.php?artikelnummer=37">
                        <img src="http://localhost/FinalPixel/pictures/CCleaner.jpg" alt="CCleaner Professional">
                    </a>
                </div>
                <div class="software-item">
                    <a href="produkt.php?artikelnummer=38">
                        <img src="http://localhost/FinalPixel/pictures/NordVPN.jpg" alt="NordVPN Complete VPN Service">
                    </a>
                </div>
                <div class="software-item">
                    <a href="produkt.php?artikelnummer=39">
                        <img src="http://localhost/FinalPixel/pictures/Adobe_Acrobat.jpg" alt="Adobe Acrobat Pro 2020">
                    </a>
                </div>
                <div class="software-item">
                    <a href="produkt.php?artikelnummer=40">
                        <img src="http://localhost/FinalPixel/pictures/Windows10_Pro.jpg" alt="Microsoft Windows 10 Pro">
                    </a>
                </div>
                <div class="software-item">
                    <a href="produkt.php?artikelnummer=41">
                        <img src="http://localhost/FinalPixel/pictures/McAfee_AntiVirus.jpg" alt="McAfee AntiVirus">
                    </a>
                </div>
                <div class="software-item">
                    <a href="produkt.php?artikelnummer=42">
                        <img src="http://localhost/FinalPixel/pictures/Windows_Server_2022_Standard.jpg" alt="Windows Server 2022 Standard">
                    </a>
                </div>
                <div class="software-item">
                    <a href="produkt.php?artikelnummer=24">
                        <img src="http://localhost/FinalPixel/pictures/Office.jpg" alt="Office Professional Plus">
                    </a>
                </div>
    </main>
 
<script src="script.js" defer></script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/684024124760461909679966/1ist8pqav';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>