<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery</title>
    <link rel="stylesheet" href="style/index_styles.css?v=5">
</head>
<html>
    <body>

    <header>
    <div class="left-header">
        <p>The Art Gallery</p>
    </div>
    <div class="right-header">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="website/artistpage.php">Artists</a></li>
                <li><a href="website/artworkpage.php">Artwork</a></li>
                <li><a href="#">Exhibition</a></li>
                <li>
                <?php
                session_start();
    
                if (isset($_SESSION['logged_in'])) {
                    echo '<a href="website/account.php">Account</a>';
                } else {
                    echo '<a href="website/loginpage.php">Log in</a>';
                }
                ?>
                </li>
                <li><a href="#"><img src="image/search.png" alt="search.png"></a>
            </ul>
        </nav>
    </header>

    <main>
        <h2>The Art</h2>
        <h2>Gallery</h2>
            <p> "Welcome to our art gallery in the heart of Bangkok, brought to you by there <br/> 
            passionate friends with a love for the arts. Our online platform is your gateway <br/>
            to discovering a rich tapestry of local and international artistic expressions. <br/>
            Explore a diverse collection of artwork culated by us, show casing a blend of <br/>
            traditional and contemporary pieces. We are excited to shared our artistic <br/>
            journey with you, and we hope you'll find inspiration in the vibrant art scene of <br/>
            Bangkok through our website."</p>

            <button id="about-us" onclick="scrollabout()"><a >About us</a></button>

    </main>

    <section id="about_us_section">
        <div class="about-us-content">
            <h2>About Us</h2>
            <p>
                The Art Gallery is a haven for art lovers and creators alike. Founded by a group of passionate artists and enthusiasts, our gallery is dedicated to showcasing the beauty and diversity of the art world.
            </p>
            <p>
                Our mission is to bridge the gap between artists and art lovers, offering a platform where talent and creativity can thrive. With a rich collection of traditional and contemporary artworks, we aim to inspire and connect people through the power of art.
            </p>
        </div>
    </section>
    <script src="script/script.js"></script>
    </body>
</html>