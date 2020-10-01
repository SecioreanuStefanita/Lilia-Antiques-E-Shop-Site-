<?php session_start();
$connection=mysqli_connect("localhost", "root","");
$db=mysqli_select_db($connection,'anticariat');

if(isset($_POST['remove'])){
  if($_GET['action']=='remove'){
    foreach($_SESSION['cart'] as $key=>$value){
      if($value["idProdus_cos"]==$_GET['id']){
        unset($_SESSION['cart'][$key]);
        echo"<script>window.location='cos.php'</script>";
      }
    }
  }
}

?>

<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="footer.css">
  
    <link rel="stylesheet" href="myMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="cos.css">
   
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

  <div id="empty">
    <span class="empty-text">Nu ati adaugat nimic in cos!</span> 
    <span class="empty-text"><a href="produse.php">Reveniti la pagina cu produse.</a></span>
  </div>

  
  <div id="container">
    <table id="cos">
      <thead>
        <tr>
          <th colspan="2">Produs</th>
          <th>Pret unitar</th>
          <th>Sterge</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $total =0;
        if(isset($_SESSION['cart'])){
        $idProd=array_column($_SESSION['cart'],'idProdus_cos');
        $query="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus) ;";
        $query_run=mysqli_query($connection,$query);
        while ($row=mysqli_fetch_array($query_run)){
          foreach($idProd as $id){
              if($row['idProdus']==$id){
                cartElement($row['poza'],$row['numProdus'],$row['pret'],$row['idProdus'],$row['tip']);
                $total+=(int)$row['pret'];
              }
          }
        }
      }else{
        echo "Nu aveti produse in cos";
      }
        ?>
        <tr>
          <td colspan="3">
            <span class="pret-tot">
            <?php
            if(isset($_SESSION['cart'])){
              $count=count($_SESSION['cart']);
              echo "Pretul pentru ($count obiecte) este de $total lei";
            }else{ echo "Pretul (0 obiecte) este de 0 lei";}

            ?>
            </span>
          </td>
          <td>
          
        </tr>
        <tr>
          <td colspan="4">
          <div class="container-radio">
            <input type="radio" name="plata" id="livrare" value="livrare">Plateste la livrare</input>
          </div>
          </td>
        </tr>
        <tr>
          <td colspan="4">
          <div class="container-radio">
            <input type="radio" name="plata" id="card" value="card">Plateste cu cardul</input>
          </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="row">
      <div class="col-100">
        <div class="container_detalii_facturare">
          <form action="success.php" method="POST">
          
            <div class="row">
              <div class="col-50">
                <h3>Introduceti datele de facturare</h3>
                <label for="fname"><i class="fa fa-user"></i> Nume complet</label>
                <input type="text" id="fname" name="nume" placeholder="Andrei Ionescu">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" id="email" name="email" placeholder="john@example.com">
                <label for="adr"><i class="fa fa-address-card-o"></i> Adresa</label>
                <input type="text" id="adr" name="adresa" placeholder="Strada lalelelor Nr 1 Sc 2 Bl 3 Et 4 Ap 5">
                <label for="phone"><i class="fa fa-phone"></i> Numar de telefon</label>
                <input type="text" id="phone" name="nr_telefon" placeholder="0787123123">
                <label for="city"><i class="fa fa-institution"></i> Oras</label>
                <input type="text" id="city" name="oras" placeholder="Craiova">
                <input type="hidden" name="pret_total"value="<?php echo $total; ?>"/>

                <div class="row">
                  <div class="col-50">
                    <label for="state">Judet</label>
                    <input type="text" id="state" name="judet" placeholder="Dolj">
                  </div>
                  <div class="col-50">
                    <label for="zip">Cod Postal</label>
                    <input type="text" id="zip" name="cod_postal" placeholder="200457">
                  </div>
                </div>
              </div>
              
              </div>
            <input type="submit" value="Plateste la livrare." class="btn">
          </form>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-100">
        <div class="container_detalii_facturare">
          <form action="success.php" method="POST">
          
            <div class="row">
              <div class="col-50">
                <h3>Introduceti datele de facturare</h3>
                <label for="fname"><i class="fa fa-user"></i> Nume complet</label>
                <input type="text" id="fname" name="nume" placeholder="Andrei Ionescu">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" id="email" name="email" placeholder="john@example.com">
                <label for="adr"><i class="fa fa-address-card-o"></i> Adresa</label>
                <input type="text" id="adr" name="adresa" placeholder="Strada lalelelor Nr 1 Sc 2 Bl 3 Et 4 Ap 5">
                <label for="phone"><i class="fa fa-phone"></i> Numar de telefon</label>
                <input type="text" id="phone" name="nr_telefon" placeholder="0787123123">
                <label for="city"><i class="fa fa-institution"></i> Oras</label>
                <input type="text" id="city" name="oras" placeholder="Craiova">
                <input type="hidden" name="pret_total"value="<?php echo $total; ?>"/>

                <div class="row">
                  <div class="col-50">
                    <label for="state">Judet</label>
                    <input type="text" id="state" name="judet" placeholder="Dolj">
                  </div>
                  <div class="col-50">
                    <label for="zip">Cod Postal</label>
                    <input type="text" id="zip" name="cod_postal" placeholder="200457">
                  </div>
                </div>
              </div>
              
              </div>
            <input type="submit" value="Plateste cu cardul." class="btn">
          </form>
        </div>
      </div>

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
  <script src="cos_script.js"></script>
           

  </body>
</html>



<?php

function cartElement($poza, $numeProd, $pret, $idProd,$tip){
echo '<tr class="produs-cos">';
echo '<td width="15%">';
echo '<img class="prod_img" src="data:image;base64,'.base64_encode($poza).'"alt="Poza">';
echo '</td>';
echo '<td width="65%" class="info-cos">';
echo '<span class="titlu-prod">';
echo $numeProd;
echo '</span>';
echo '<span class="tip-prod">';
echo $tip;
echo '</span>';
echo '</td>';
echo '<td width="10%">';
echo '<span class="pret-prod">';
echo $pret;
echo '</span>';
echo '<span class="pret-prod">lei</span>';
echo '</td>';
echo '<td style="text-align:center;" width="10%">';
echo '<form method="post" action="cos.php?action=remove&id=';
echo $idProd;
echo '">';
echo '<button type="submit" class="fa fa-remove" name="remove"></button>';
echo '</form>';
echo '</td>';
echo '</tr>';
}

?>