<?php
session_start();
$connection=mysqli_connect("localhost", "root","");
$db=mysqli_select_db($connection,'anticariat');
?>
<html>
  <head>
  <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="myMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="card.css">
    <link rel="stylesheet" href="produse.css">
    <link rel="stylesheet" href="filtru.css">
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

    <div id="filtru_container">
    <form method="GET" action="cautare_avansata.php" >
      <div class="filtru">
        <span class="num_filtru">Pret</span>
        <hr>
        <span class="text_filtru">Pret minim:</span>
        <input value="0" min="0" max="2500" step="1" type="range" name="lowp" id="low">
        <span class="text_filtru">Pret maxim:</span>
        <input value="2500" min="0" max="2500" step="1" type="range" name="highp" id="high">
        <span class="text_filtru" id="interval">Interval: <span id="low_price"></span> lei - <span id="high_price"></span> lei</span>
        <hr>
        <div class="interval_pret">
          <input type="checkbox" name="inter1" value="0">
          <label for="inter1">0 - 100 lei</label>
          <br>
          <input type="checkbox" name="inter2" value="100">
          <label for="inter1">100 lei - 200 lei</label>
          <br>
          <input type="checkbox" name="inter3" value="200">
          <label for="inter1">200 lei - 300 lei</label>
          <br>
          <input type="checkbox" name="inter4" value="300">
          <label for="inter1">300 lei - 400 lei</label>
          <br>
          <input type="checkbox" name="inter5" value="400">
          <label for="inter1">400 lei - 500 lei</label>
          <br>
          <input type="checkbox" name="inter6" value="500">
          <label for="inter1">500 lei - 1000 lei</label>
          <br>
          <input type="checkbox" name="inter7" value="1000">
          <label for="inter1">1000+ lei</label>
        </div>
      </div>
      <div class="filtru">
        <span class="num_filtru">Tip</span>
        <hr>
        <input type="radio" name="tip" value="tot" checked>
        <label for="tot"><img src="imagini\tot.svg" class="icon_filter">Toate tipurile</label>
        <br>
        <input type="radio" name="tip" value="dec">
        <label for="dec"><img src="imagini\decoratiuni.svg" class="icon_filter">Decoratiuni</label>
        <br>
        <input type="radio" name="tip" value="vas">
        <label for="vas"><img src="imagini\vase.svg" class="icon_filter">Vase</label>
        <br>
        <input type="radio" name="tip" value="mob">
        <label for="mob"><img src="imagini\mobila.svg" class="icon_filter">Mobilier</label>
        <br>
        <input type="radio" name="tip" value="alt">
        <label for="alt"><img src="imagini\altul.svg" class="icon_filter">Altul</label>
      </div>
      <button type="submit">Cauta</button>
    </form>
  </div>

  </div>



  <div id="container">
<?php
$connection=mysqli_connect("localhost", "root","");
$db=mysqli_select_db($connection,'anticariat');

$var_pret_min_slider=isset($_GET['lowp']) ? $_GET['lowp']:'0';
$var_pret_max_slider=isset($_GET['highp']) ? $_GET['highp']:'2500';

if($var_pret_min_slider>$var_pret_max_slider){
$temp=$var_pret_min_slider;
$var_pret_min_slider=$var_pret_max_slider;
$var_pret_max_slider=$temp;
}



$var_tip=$_GET['tip'];
$var_optiune_pret1 = isset($_GET['inter1']) ? $_GET['inter1']:'-1';
$var_optiune_pret2 = isset($_GET['inter2']) ? $_GET['inter2']:'-1';
$var_optiune_pret3 = isset($_GET['inter3']) ? $_GET['inter3']:'-1';
$var_optiune_pret4 = isset($_GET['inter4']) ? $_GET['inter4']:'-1';
$var_optiune_pret5 = isset($_GET['inter5']) ? $_GET['inter5']:'-1';
$var_optiune_pret6 = isset($_GET['inter6']) ? $_GET['inter6']:'-1';
$var_optiune_pret7 = isset($_GET['inter7']) ? $_GET['inter7']:'-1';
$results_per_page=18;

if($var_pret_min_slider==0&&$var_pret_max_slider==2500&&$var_optiune_pret1==-1&&$var_optiune_pret2==-1&&$var_optiune_pret3==-1&&$var_optiune_pret4==-1&&$var_optiune_pret5==-1&&$var_optiune_pret6==-1&&$var_optiune_pret7==-1){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus) LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE  tip like '%decoratiuni%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE  tip like '%decoratiuni%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE  tip like '%vase%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE  tip like '%vase%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE  tip like '%mobilier%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE  tip like '%mobilier%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE  tip like '%altele%'; ";
  $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
  $this_page_first_result=paginatie($sql,$connection,$results_per_page);
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE  tip like '%altele%' LIMIT " . $this_page_first_result.','.$results_per_page;
  afisare($sql,$connection);

}
}



if($var_pret_min_slider!=0||$var_pret_max_slider!=2500){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider') AND tip like '%decoratiuni%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider') AND tip like '%decoratiuni%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider')AND tip like '%vase%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider')AND tip like '%vase%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider') AND tip like '%mobilier%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider') AND tip like '%mobilier%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider') AND tip like '%altele%'; ";
  $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
  $this_page_first_result=paginatie($sql,$connection,$results_per_page);
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>='$var_pret_min_slider' AND pret<='$var_pret_max_slider') AND tip like '%altele%' LIMIT " . $this_page_first_result.','.$results_per_page;
  afisare($sql,$connection);

}
  
}if($var_optiune_pret1!=-1){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='0' AND pret<='100'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='0' AND pret<='100') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='0' AND pret<='100') AND tip like '%decoratiuni%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='0' AND pret<='100') AND tip like '%decoratiuni%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='0' AND pret<='100')AND tip like '%vase%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='0' AND pret<='100')AND tip like '%vase%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='0' AND pret<='100') AND tip like '%mobilier%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='0' AND pret<='100') AND tip like '%mobilier%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>='0' AND pret<='100') AND tip like '%altele%'; ";
  $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
  $this_page_first_result=paginatie($sql,$connection,$results_per_page);
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>='0' AND pret<='100') AND tip like '%altele%' LIMIT " . $this_page_first_result.','.$results_per_page;
  afisare($sql,$connection);

}
}if($var_optiune_pret2!=-1){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'100' AND pret<='200'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'100' AND pret<='200') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'100' AND pret<='200') AND tip like '%decoratiuni%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'100' AND pret<='200') AND tip like '%decoratiuni%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'100' AND pret<='200')AND tip like '%vase%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'100' AND pret<='200')AND tip like '%vase%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'100' AND pret<='200') AND tip like '%mobilier%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'100' AND pret<='200') AND tip like '%mobilier%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>'100' AND pret<='200') AND tip like '%altele%'; ";
  $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
  $this_page_first_result=paginatie($sql,$connection,$results_per_page);
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>'100' AND pret<='200') AND tip like '%altele%' LIMIT " . $this_page_first_result.','.$results_per_page;
  afisare($sql,$connection);

}
}if($var_optiune_pret3!=-1){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'200' AND pret<='300'); ";
$number_of_pages=number_of_pages($sql,$connection,$results_per_page);
$this_page_first_result=paginatie($sql,$connection,$results_per_page);

$sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
WHERE (pret>'200' AND pret<='300') LIMIT " . $this_page_first_result.','.$results_per_page;

    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'200' AND pret<='300') AND tip like '%decoratiuni%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
      $this_page_first_result=paginatie($sql,$connection,$results_per_page);

      $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
      WHERE (pret>'200' AND pret<='300') AND tip like '%decoratiuni%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'200' AND pret<='300')AND tip like '%vase%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);

    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'200' AND pret<='300')AND tip like '%vase%' LIMIT " . $this_page_first_result.','.$results_per_page;

    afisare($sql,$connection);

  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'200' AND pret<='300') AND tip like '%mobilier%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
   
      $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'200' AND pret<='300') AND tip like '%mobilier%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>'200' AND pret<='300') AND tip like '%altele%'; ";
  $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
  $this_page_first_result=paginatie($sql,$connection,$results_per_page);

 $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>'200' AND pret<='300') AND tip like '%altele%' LIMIT " . $this_page_first_result.','.$results_per_page;

  afisare($sql,$connection);

}
}
if($var_optiune_pret4!=-1){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'300' AND pret<='400'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'300' AND pret<='400') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'300' AND pret<='400') AND tip like '%decoratiuni%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'300' AND pret<='400') AND tip like '%decoratiuni%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'300' AND pret<='400')AND tip like '%vase%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'300' AND pret<='400')AND tip like '%vase%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'300' AND pret<='400') AND tip like '%mobilier%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'300' AND pret<='400') AND tip like '%mobilier%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>='300' AND pret<='400') AND tip like '%altele%'; ";
$number_of_pages=number_of_pages($sql,$connection,$results_per_page);
$this_page_first_result=paginatie($sql,$connection,$results_per_page);

$sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>='300' AND pret<='400') AND tip like '%altele%' LIMIT " . $this_page_first_result.','.$results_per_page;
  afisare($sql,$connection);

}
}if($var_optiune_pret5!=-1){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'400' AND pret<='500'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'400' AND pret<='500') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'400' AND pret<='500') AND tip like '%decoratiuni%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'400' AND pret<='500') AND tip like '%decoratiuni%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'400' AND pret<='500')AND tip like '%vase%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'400' AND pret<='500')AND tip like '%vase%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'400' AND pret<='500') AND tip like '%mobilier%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'400' AND pret<='500') AND tip like '%mobilier%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>'400' AND pret<='500') AND tip like '%altele%'; ";
  $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
  $this_page_first_result=paginatie($sql,$connection,$results_per_page);
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>'400' AND pret<='500') AND tip like '%altele%' LIMIT " . $this_page_first_result.','.$results_per_page;
  afisare($sql,$connection);

}
}if($var_optiune_pret6!=-1){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'500' AND pret<='1000'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'500' AND pret<='1000') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'500' AND pret<='1000') AND tip like '%decoratiuni%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'500' AND pret<='1000') AND tip like '%decoratiuni%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'500' AND pret<='1000')AND tip like '%vase%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'500' AND pret<='1000')AND tip like '%vase%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'500' AND pret<='1000') AND tip like '%mobilier%'; ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>'500' AND pret<='1000') AND tip like '%mobilier%' LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>'500' AND pret<='1000') AND tip like '%altele%'; ";
  $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
  $this_page_first_result=paginatie($sql,$connection,$results_per_page);
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>'500' AND pret<='1000') AND tip like '%altele%' LIMIT " . $this_page_first_result.','.$results_per_page;
  afisare($sql,$connection);

}
}if($var_optiune_pret7!=-1){
  if($var_tip=='tot'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='1000'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='1000') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);
  }else if($var_tip=='dec'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='1000' AND tip like '%decoratiuni%'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='1000' AND tip like '%decoratiuni%') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

  }else if($var_tip=='vas'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='1000' AND tip like '%vase%'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE (pret>='1000' AND tip like '%vase%') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);


  }
   else if($var_tip=='mob'){
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE ( pret>='1000' AND tip like '%mobilier%'); ";
    $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
    $this_page_first_result=paginatie($sql,$connection,$results_per_page);
    $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
    WHERE ( pret>='1000' AND tip like '%mobilier%') LIMIT " . $this_page_first_result.','.$results_per_page;
    afisare($sql,$connection);

}
else if($var_tip=='alt'){
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>='1000' AND tip like '%altele%'); ";
  $number_of_pages=number_of_pages($sql,$connection,$results_per_page);
  $this_page_first_result=paginatie($sql,$connection,$results_per_page);
  $sql="SELECT produse.idProdus, produse.numProdus, produse.tip, produse.descriere, produse.pret, imagini.poza FROM produse LEFT JOIN imagini ON (produse.idProdus = imagini.idProdus)
  WHERE (pret>='1000' AND tip like '%altele%') LIMIT " . $this_page_first_result.','.$results_per_page;
  afisare($sql,$connection);

}
}

?>
</div>


    <div class="soft-pagination">
    <ul class="soft-pagination-items">
      <li> <i class="fa fa-chevron-circle-left" style="font-size:20px;color:white"></i></li>
      <?php
    for($page=1;$page<=$number_of_pages;$page++){
      echo '<li><a href="cautare_avansata.php?page=' . $page . '&tip=' .$var_tip . '">' . $page . '</a></li>';
    }?>
       <li> <i class="fa fa-chevron-circle-right" style="font-size:20px;color:white;"></i></li>
    </ul>
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


  </body>
</html>
<script>
      var x=document.getElementById("low");
      var y=document.getElementById("high");
      var dev1=document.getElementById("low_price");
      var dev2=document.getElementById("high_price");
      dev1.innerHTML=x.value;
      dev2.innerHTML=y.value;

      x.oninput=function() {
        if (parseInt(x.value,10)>parseInt(y.value,10)) {
        dev1.innerHTML=y.value;
        dev2.innerHTML=this.value;
      }
        else dev1.innerHTML=this.value;
      }
      y.oninput=function() {
        if (parseInt(x.value,10)>parseInt(y.value,10)) {
          dev2.innerHTML=x.value;
          dev1.innerHTML=this.value;
        }
        else dev2.innerHTML=this.value;
      }
  </script>

<?php function afisare($sql,$connection){
$result=mysqli_query($connection,$sql);
$queryResult=mysqli_num_rows($result);
    if($queryResult>0){?>
        
            <?php
        while ($row=mysqli_fetch_array($result)){
            ?>
             <div class="card">
     
    
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
            }?>
<?php
    }else{
        echo "Nu sunt rezultate pentru cautarea dumneavoastra!!!";
    }

?>
  <?php } ?>

  <?php 

  function paginatie($sql,$connection,$results_per_page){

    $query_run=mysqli_query($connection,$sql);
    $number_of_results=mysqli_num_rows($query_run);
    $number_of_pages=ceil($number_of_results/$results_per_page);
   
    if(!isset($_GET['page'])){
      $page=1;
   
    }else{
      $page=$_GET['page'];
    }
   
    $this_page_first_result = ($page-1)*$results_per_page;

      return $this_page_first_result;

  }
  
  ?>
<?php
function number_of_pages($sql,$connection,$results_per_page){

$query_run=mysqli_query($connection,$sql);
$number_of_results=mysqli_num_rows($query_run);
$number_of_pages=ceil($number_of_results/$results_per_page);

  return $number_of_pages;

}

?>