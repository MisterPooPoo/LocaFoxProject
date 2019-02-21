<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>LocaFox</title>

    <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/carlito" type="text/css"/>
    <link rel="stylesheet" href="http://localhost:8000/public/css/style.css"/>

    <link href="http://localhost:8000/lib/zoombox/zoombox.css" rel="stylesheet" type="text/css" media="screen" />

    <script type="text/javascript" src="http://localhost:8000/lib/zoombox/zoombox.js"></script>
    <script type="text/javascript" src="http://localhost:8000/lib/node_modules/jquery/dist/jquery.min.js"></script>
    
    <script type="text/javascript">
        jQuery(function($){
            $('a.zoombox').zoombox();
            $('a.zoombox').zoombox({
                theme : 'lightbox',
                opacity : 0.6,
                duration : 600,
                animation : true,
                width : 600,
                height : 500,
                gallery : false,
                autoplay : false
                });
        });
    </script>
  </head>

<body>

  <header>
      <?php include("header.php"); ?>
  </header>

  <div id = "corps_page">
      <section id = "section1">
            <?php include("menu.php"); ?>
      </section>

      <section id= "section2">
        <div id="fil_ariane">
          <a> Accueil </a> >
          <a> Confort du Chantier </a> >
          <span> Chauffage & Climatisation</span>
        </div>

        <?php include('pages_produits/OU01.php'); ?>
      </section>
  </div>

  <footer>
      <?php include("footer.php"); ?>
  </footer>

          <!-- code JS alert site étudiant -->
              <script>
                  alert ("Attention! Ce site a été réalisé dans le cadre d'un projet d'étude au CNAM de Lille") ;
              </script>

  </body>

</html>
