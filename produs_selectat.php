<?php
session_start();
?>
<html>
  <head>
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="myMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="card.css">
    <link rel="stylesheet" href="produs_selectat.css">
  </head>
  <body>


  <div id="meniu_container">
        <div class="search-container">
            <form action="cautare.php" method="POST">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <nav class="meniu">
            <ul class="main_meniu">
                <li onclick="location.href='contact.html';"><a href="contact.html" class="meniu_page">Acasa/Contact</a></li>
                <li class="active" onclick="location.href='produse.php';"><a href="produse.php" class="meniu_page">Produse</a></li>
                <li onclick="location.href='cos.php';"><a href="cos.php" class="meniu_page">Cos(<?php

                    if(isset($_SESSION['cart'])){
                      $count=count($_SESSION['cart']);
                      echo $count;
                    }else echo "0";

                ?>) </a></li> 
                <li class="meniu_page"></li>
            </ul>
        </nav>
  </div>


    <?php
      $prod_id=$_GET['idProdus'];
      $connection=mysqli_connect("localhost", "root","");
      $db=mysqli_select_db($connection,'anticariat');
      $query="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus) where produse.idProdus='$prod_id'";
      $result=mysqli_query($connection,$query);
      $row=mysqli_fetch_row($result);
      $id=$row[0];
      $titlu=$row[1];
      $tip=$row[2];
      $descriere=$row[3];
      $pret=$row[4];
      $poza=$row[5];

    ?>

    <div id="content">
      <div id="imagine">
        <div id="pop_image">
          <div id="close_pop" onclick="closePopUp()"></div>
          <?php
            echo '<img id="pop_content" src="data:image;base64,'.base64_encode($poza).'"alt="Poza">';
          ?>
        </div>
        <?php
          echo '<img onclick="popUpImage()" class="imagine" id="img" src="data:image;base64,'.base64_encode($poza).'"alt="Poza">';
        ?>
      </div>
      <div id="specificatii">
        <span class="titlu">
          <?php echo $titlu; ?>
        </span>
        <hr>
        <span class="tip">  
          <?php echo $tip; ?>
        </span>
        <hr>
        <span class="pret">Pret: <?php echo $pret; ?> lei
        </span>
        <hr>
        <form method="post" action="produse.php">
        <input type="hidden" name="idProdus_cos" value="<?php $id?>">
          <button type="submit" class="buyButt" name="add" >Adauga in Cos</button>
        </form>
        </div>
      <div id="descriere"> 
        <span class="titlu">Descriere</span>
        <hr>
        <span class="descProd"><?php echo $descriere;?></span>
      </div>
      <div id="slideshow_container">
        <span class="titlu">Produse din aceiasi gama</span>
        <hr>
        <div id="previous" onclick="previousSlide()"></div>
        <?php
          $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
          WHERE tip LIKE '%$tip%' AND produse.idProdus != '$prod_id' ";
          $result=mysqli_query($connection, $sql);
          $index=0;
          while ($row=mysqli_fetch_array($result)) {
            ?>
           <div class="card slide" onclick="hideSlide(); showSlide(<?php echo $index?>)">
     
    
     <div class="img_prod">
     <?php
     echo '<img src="data:image;base64,'.base64_encode($row['poza']).'"alt="Poza">';
     ?>
     </div>
     <div class="info_prod">
       <div class="text_prod">
         <span class="numProd"><?php echo $row['numProdus'];?></span>
         <span class="tipProd"><?php echo $row['tip'];?></span>
        
       </div>
       <div class="com_prod">
         <span class="pretProd"><?php echo $row['pret'];?> lei</span>
         <br>
         <form method="post" action="produse.php">
         
<input type="hidden" name="idProdus_cos" value="<?php echo $row['idProdus']; ?>">
         <button type="submit"name="add" id="buton1">Adauga in cos</button>
         </form>
         <form method="get" action="produs_selectat.php">
         <input type="hidden" name="idProdus" value="<?php echo $row['idProdus']; ?>">
         <button type="submit" id="buton2">Detalii</button></form>
       </div>
     </div>
   </div>
            <?php
            $index++;
          }
        ?>
        <div id="next" onclick="nextSlide()"></div>
      </div>
    </div>



    <div id="footer">
      <div class="footer_box">
        <span class="footer_titlu">Lilia Antique</span>
        <hr>
        <br>
        <span class="descriere_comp">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
          Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
          Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
          Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </span>
      </div>
      <div class="footer_box">
        <span class="footer_titlu">Linkuri utile</span>
        <hr>
        <br>
        <div class="contact_link">
          <a href="main.html" class="footer_link">Despre noi</a>
        </div>
        <div class="contact_link">
          <a href="produse.php" class="footer_link">Produse</a>
        </div>
        <div class="contact_link">
          <a href="cos.php" class="footer_link">Cos</a>
        </div>
      </div>
      <div class="footer_box">
        <span class="footer_titlu">Contact</span>
        <hr>
        <br>
        <div class="contact_link">
          <img src="imagini\fb.svg" alt="fb" class="icon_contact">
          <a href="https://www.facebook.com/liliantiqueshop" class="footer_link">Lilia Antique</a>
        </div>
        <div class="contact_link">
          <img src="imagini\gmail.svg" alt="gmail" class="icon_contact">
          <span style="word-break: break-all;" class="contact_text">oprea.stefanteodor@gmail.com</span>
        </div>
        <div class="contact_link">
          <img src="imagini\tel.svg" alt="tel" class="icon_contact">
          <span class="contact_text"> +40 722 900 252</span>
        </div>
        <div class="contact_link">
          <img src="imagini\address.svg" alt="adr" class="icon_contact">
          <span class="contact_text">strada Grigore Plesoianu, bl. 11B, et. 1</span>
        </div>
      </div>
      <div class="footer_box">
        <span class="footer_titlu">Metode de plata</span>
        <hr>
        <br>
        <img src="imagini\paypal.svg" alt="paypal" class="icon_card">
        <img src="imagini\mastercard.svg" alt="mastercard" class="icon_card">
        <img src="imagini\visa.svg" alt="visa" class="icon_card">
      </div>
    </div>

    <script src="resize.js"></script>
    <script>
      var slides=document.getElementsByClassName('slide');
      //width: 20%;
     // height: 64%;
      var curSlide=0;
      var maxSlides=3;
      if (maxSlides>slides.length) {maxSlides=slides.length}
      for (aux=curSlide; aux<maxSlides; aux++) {
        slides[aux].style.width="20%";
        slides[aux].style.height="64%";  
      }

      function nextSlide() {
        hideSlide()
        curSlide=curSlide+1;
        if (curSlide > slides.length-1) {curSlide=0;}
        showSlide(curSlide);
      }

      function previousSlide() {
        hideSlide()
        curSlide=curSlide-1;
        if (curSlide < 0) {curSlide=slides.length-1;}
        showSlide(curSlide);
      }

      function showSlide(index) {
        if (curSlide != index) {curSlide=index;}
        for (aux=curSlide, i=0; i<maxSlides; aux++, i++) {
          if (aux>slides.length-1) {aux=0;}
          slides[aux].style.width="20%";
          slides[aux].style.height="64%";}
      }

      function hideSlide() {
        for (aux=0; aux<slides.length; aux++) {
          slides[aux].style.width="0";
          slides[aux].style.height="0";}
      }

    </script>


  </body>
</html>
