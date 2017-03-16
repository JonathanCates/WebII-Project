<?php
  include_once "includes/favorite-artists.php";
	include_once "includes/favorite-paintings.php";
	include_once "includes/cart-class.php";

  function getFavCount()
  {
    session_start();
    $artists = unserialize($_SESSION['favArtists']);
    $paintings = unserialize($_SESSION['favPaintings']);
    $artistArray = $artists->getList();
    $paintingArray = $paintings->getList();
    echo count($artistArray) + count($paintingArray);
    $_SESSION['favArtists'] = serialize($artists);
    $_SESSION['favPaintings'] = serialize($paintings);
  }
  
  function getCartCount()
  {
    $cart = unserialize($_SESSION['cart']);
    $cartArray = $cart->getList();
    echo count($cartArray);
    $_SESSION['cart'] = serialize($cart);
  }
?>

<header>
    <div class="ui attached stackable grey inverted  menu">
        <div class="ui container">
            <nav class="right menu">            
                <div class="ui simple  dropdown item">
                  <i class="user icon"></i>
                  Account
                    <i class="dropdown icon"></i>
                  <div class="menu">
                    <a class="item"><i class="sign in icon"></i> Login</a>
                    <a class="item"><i class="edit icon"></i> Edit Profile</a>
                    <a class="item"><i class="globe icon"></i> Choose Language</a>
                    <a class="item"><i class="settings icon"></i> Account Settings</a>
                  </div>
                </div>
                <a class="item" href="favorites.php">
                    <i class="heartbeat icon"></i> Favorites
                    <div class="circular ui label">
                      <?php
                        getFavCount();
                      ?>
                    </div>
                </a>        
                <a class="item" href="cart.php">
                  <i class="shop icon"></i> Cart
                  <div class="circular ui label">
                      <?php
                        getCartCount();
                      ?>
                    </div>
                </a>                                     
            </nav>            
        </div>     
    </div>   
    
    <div class="ui attached stackable borderless huge menu">
        <div class="ui container">
            <h2 class="header item">
              <img src="images/logo5.png" class="ui small image" >
            </h2>  
            <a class="item" href="index.php">
              <i class="home icon"></i> Home
            </a>       
            <a class="item" href="aboutus.php">
              <i class="mail icon"></i> About Us
            </a>      
            <a class="item">
              <i class="home icon"></i> Blog
            </a>      
            <div class="ui simple dropdown item">
              <i class="grid layout icon"></i>
              Browse
                <i class="dropdown icon"></i>
              <div class="menu">
                <a class="item" href="browse-artists.php"><i class="users icon"></i> Artists</a>
                <a class="item" href="browse-genres.php"><i class="theme icon"></i> Genres</a>
                <a class="item" href="browse-paintings.php"><i class="paint brush icon"></i> Paintings</a>
                <a class="item" href="browse-subjects.php"><i class="cube icon"></i> Subjects</a>
                <a class="item" href="browse-galleries.php"><i class="marker icon"></i> Galleries</a>
              </div>
            </div>        
            <div class="right item">
				<div class="ui action input">
					<form method="GET" action="browse-paintings.php">
						<input placeholder="Search..." type="text" name="searchBy">
						<button class="ui icon button" type="submit">
							<i class="search icon"></i>
						</button>
					</form>
				</div>
            </div>      

        </div>
    </div>   
    
</header>