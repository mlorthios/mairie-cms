<!doctype html>
<html>
	<head>
		<title>Ville d'Audruicq</title>
		<meta name="description" content="Site officiel de la Mairie d'Audruicq. Services, infos pratiques, événements, culture...">
		<meta name="author" content="Ville d'Audruicq">
        <meta name="robots" content="index, follow">
		<meta name="keywords" content="audruicq, mairie, commune, ville, région, maire, canton, informations, chef lieu, accueil, village, communaute, bienvenue site, officiel, administrative, administratif, demarches, communication, administres">
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <meta name="csrf-token" content="<?= $csrf_token ?>">
		<link rel="stylesheet" href="/public/css/bootstrap.min.css">
		<link rel="stylesheet" href="/public/css/all.min.css">
        <link rel="stylesheet" href="/public/plugins/lightbox/dist/jquery.fancybox.min.css">
		<link rel="stylesheet" href="/public/css/styles.css">
	</head>
	<body>
        <div id="barba-wrapper">
  <div class="barba-container" data-namespace="marquee">
		<div class="container">
			<?= $function->BannerLeft(); ?>
            <?= $function->BannerRight(); ?>
			<div class="header">
				<div class="img"></div>
			</div>
			<?php include 'partials/nav.partial.php'; ?>
			<?= $function->MessagesAlert($pageid); ?>
			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="fa fa-newspaper"></i> Actualités
						</div>
						<div class="panel-body">
							<?php 
                            
                            $News = $db->query('SELECT * FROM news');
                            $row = $News->rowCount();
                            
                            if($row > 0) { ?>
                            
                            <div id="NewsVille" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
                                    <?php
                                    
                                    $News = $db->query('SELECT * FROM news ORDER BY date DESC LIMIT 5');
                                    
                                    $nb = 0;
                                    
                                    while($n = $News->fetch()) {

                                        if($nb == 0) {
                                            echo '<li data-target="#NewsVille" data-slide-to="'.$nb.'" class="active"></li>'; 
                                        } else {
                                            echo '<li data-target="#NewsVille" data-slide-to="'.$nb.'"></li>';
                                        }
                                        
                                        
                                        
                                        $nb = $nb + 1;
                                    }
                                    
                                    ?>
								</ol>
								<div class="carousel-inner">
									
                                    <?php
                                    
                                    $News = $db->query('SELECT * FROM news ORDER BY date DESC LIMIT 5');
                                    
                                    $nb = 0;
                                    
                                    while($n = $News->fetch()) {
                                        
                                        echo '<div class="item';
                                        
                                        if($nb == 0) {
                                            echo ' active'; 
                                        }
                                        
                                        echo '">
										<img src="'.$n['image'].'" alt="Los Angeles" style="width:100%;">
										<div class="carousel-caption">
											<h3>'.$n['title'].'</h3>
											<p>
												'.$n['description'].'
											</p>
											<a style="margin-bottom: 7px" href="/news/'.$n['url'].'" class="btn btn-primary">Découvrir</a>
										</div>
									</div>';
                                        
                                        $nb = $nb + 1;
                                    }
                                    
                                    ?>
									
								</div>
								<a class="left carousel-control" href="#NewsVille" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left"></span>
									<span class="sr-only">Précédent</span>
								</a>
								<a class="right carousel-control" href="#NewsVille" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right"></span>
									<span class="sr-only">Suivant</span>
								</a>
							</div>
                            
                            <?php } else {
                                echo '<p>Aucun article n\'a été mis en ligne.</p>';
                            } ?>
						</div>
					</div>

				</div>
				<div class="col-md-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
                            <i class="fa fa-align-justify"></i> Accès rapide
						</div>
						<div class="panel-body accessfast">
							<ul>
								<?= $function->SousMenu(); ?>
							</ul>
						</div>
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="far fa-calendar"></i> Événements
						</div>
						<div class="panel-body">
							<?= $function->ListEvents(); ?>
							<hr>
							<a style="color: #444040" href="/events"><i class="fa fa-angle-double-right"></i> Voir tous les événements</a>
						</div>
					</div>
                    <?= $function->RightMenu(); ?>
				</div>
                <?php include 'partials/footer.partial.php'; ?>
			</div>
      </div></div></div>
		<script src="/public/js/jquery-3.3.1.min.js"></script>
		<script src="/public/js/bootstrap.min.js"></script>
        <script src="/public/plugins/barba/barba.min.js"></script>
        <script src="/public/plugins/lightbox/dist/jquery.fancybox.min.js"></script>
        <?php if($newsletter->Data('active') == 1) { ?>
        <script src="/public/js/plugins/newsletter.js"></script>
        <?php } ?>
        <script>
            $('#load_fancy img').each(function(){
                var src = $(this).attr('src');
                $(this).wrap('<a class="no-barba" data-fancybox="gallery" href="'+src+'"></a>');
            });
            
            $('[data-fancybox]').fancybox({
                protect: true,
                buttons: [
                    "zoom",
                    "share",
                    "slideShow",
                    "fullScreen",
                    "thumbs",
                    "close"
                ],
            });
        </script>
		<script src="/public/js/global.js"></script>
        <script src="/public/plugins/marquee/jquery.marquee.min.js"></script>
        <script>
            $('.marquee').marquee({pauseOnHover:true,speed: 80});
        </script>
	</body>
</html>
