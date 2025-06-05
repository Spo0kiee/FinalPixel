<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>FinalPixel</title>
    <style>
        /* Navigation */
        /* Header */
        header {
            background-color: #332828;
            font-family: 'Verdana', sans-serif;
            color: #fff;
            padding: 1px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        .login, .logout, .register, .profile, .cart {
            text-decoration: none;
            color: inherit;
            font-size: 1em;
        }
        .profile img, .cart img {
            width: 50px;
            height: 50px;
        }
        .profile a, .cart a {
            display: flex;
            align-items: center;
        }
        .profile a:hover, .cart a:hover {
            color: #0056b3;
        }
        .profile:hover img, .cart:hover img {
            transform: scale(1.6);
        }

        header .logo {
            font-size: 24px;
        }
        .logo {
            position: relative;
            top: 0.5mm;
        }

        header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
        }

        header nav a:hover {
            text-decoration: underline;
        }
        .category-bar {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 50px;
            padding: 10px;
            width: 70%;
            margin-left: 280px;
        }
        .category-bar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .category-bar li {
            margin: 0;
            padding: 0;
        }
        .category-bar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 8px 16px;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 4px;
        }
        .category-bar a:hover {
            background-color: #007BFF;
            color: #fff;
        }
        .fire-emoji {
            margin-left: 5px;
        }

        /* Hauptbereich */
        main {
            padding: 20px;
        }
        .main-nav {
            display: flex;
            gap: 20px;
            margin-right: 250px;
        }

        .main-nav a, .dropbtn {
            background-color: #1a1a1a;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        /* Search Bar Styles */
.search-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0;
    background: linear-gradient(145deg, #5a3e2b, #3e2b1a);
    border-radius: 12px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.4);
    transition: all 0.4s ease-in-out;
    max-width: 800px;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(2px);
    height: 48px;
}

.search-bar:hover {
    transform: scale(1.01);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
}

.search-bar form {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 0;
    height: 100%;
}

.search-bar input[type="text"] {
    height: 100%;
    padding: 0 16px;
    width: 100%;
    max-width: 350px;
    font-size: 16px;
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
    border: 2px solid #8b4513;
    border-right: none;
    border-radius: 8px 0 0 8px;
    transition: all 0.3s ease-in-out;
    backdrop-filter: blur(4px);
    box-sizing: border-box;
}

.search-bar input[type="text"]::placeholder {
    color: rgba(255, 255, 255, 0.6);
    transition: opacity 0.3s ease;
}

.search-bar input[type="text"]:focus {
    outline: none;
    background-color: rgba(255, 255, 255, 0.15);
    box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.2);
}

.search-bar button {
    height: 100%;
    padding: 0 20px;
    background: linear-gradient(145deg, #8b4513, #a0522d);
    color: white;
    font-weight: bold;
    font-size: 16px;
    border: 2px solid #a0522d;
    border-left: none;
    border-radius: 0 8px 8px 0;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-bar button:hover {
    background: #d2691e;
    color: #000;
    box-shadow: 0 0 10px #d2691e;
}


        /* Dropdown Menü */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #1a1a1a;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #333;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        /*CART*/
        .treasure-chest {
            position: relative;
            width: 60px;
            height: 45px;
            cursor: pointer;
        }

        .chest-base {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 30px;
            background: #b87333; /* Copper color */
            border-radius: 5px;
            box-shadow: inset 0 -5px 10px rgba(0,0,0,0.3);
        }

        .chest-lid {
            position: absolute;
            top: 0;
            width: 100%;
            height: 15px;
            background: #c18c5d;
            border-radius: 5px 5px 0 0;
            transform-origin: bottom;
            transition: transform 0.3s;
        }

        .cart:hover .chest-lid {
            transform: rotate(-30deg);
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #d4af37; /* Gold */
            color: #000;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 0 10px gold;
            z-index: 2;
        }
        .cart:hover .coins {
            opacity: 1;
        }

    </style>
</head>
<body>
<header>
    <div class="logo">
        <a href="http://localhost/FinalPixel/Startseite.php">
            <img src="http://localhost/FinalPixel/pictures/FinalPixel Logo.png" alt="FinalPixel Logo" class="logo" width="100">
        </a>
    </div>
    <div class="darkmode-toggle">
    <label class="switch">
        <input type="checkbox" id="darkmode-toggle">
        <span class="slider"></span>
    </label>
    <span class="slider-text">Dark Mode 🌙</span>
    </div>

    <nav class="main-nav">
        <div class="dropdown">
            <button class="dropbtn">☰ Kategorien</button>
            <div class="dropdown-content">
                <a href="filter.php?genre=RPG">RPG</a>
                <a href="filter.php?genre=Action">Action</a>
                <a href="filter.php?genre=Sport">Sport</a>
                <a href="filter.php?genre=Shooter">Shooter</a>
                <a href="filter.php?genre=Sandbox">Sandbox</a>
                <a href="filter.php?genre=Simulation">Simulation</a>
                <a href="filter.php?genre=Strategy">Strategy</a>
                <a href="filter.php?genre=CS2 Cases">CS2 Cases</a>
            </div>
        </div>
        <a href="http://localhost/FinalPixel/Startseite.php#bestsellers">Bestsellers</a>
        <a href="filter.php?genre=Software">Software</a>
    </nav>

    <div class="nav-links">
        <?php if (isset($_SESSION['username'])): ?>
            <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" class="logout">🚪 Ausloggen</a>
            <a href="profile.php" class="profile">
                <img src="http://localhost/FinalPixel/pictures/Profile-icon.png" alt="Profile">
            </a>
        <?php else: ?>
            <a href="login.php" class="login">🔑 Einloggen</a>
            <a href="registrierung.php" class="register">📜 Registrieren</a>
        <?php endif; ?>
    <a href="warenkorb.php" class="cart">
        <div class="treasure-chest">
            <div class="chest-lid"></div>
            <div class="chest-base"></div>
            <span class="cart-count">
                <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
            </span>
            <div class="coins"></div>
        </div>
    </a>
</header>
   <div class="search-bar">
        <form action="suche.php" method="GET">
            <input type="text" name="search" placeholder="Was suchst du?" oninput="showSuggestions(this.value)">
            <button type="submit">Suchen</button>
        </form>
        <div id="suggestions" class="suggestions"></div>
    </div>

</body>
</html>