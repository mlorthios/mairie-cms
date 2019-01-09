<!doctype html>

<html>
	<head>
		<title>Erreur 404</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="/public/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/css/all.min.css">
        <link rel="stylesheet" href="/public/plugins/lightbox/dist/jquery.fancybox.min.css">
        <link rel="stylesheet" href="/public/css/styles.css">
	</head>

	<body>
        <div class="container">
            <?= $function->BannerLeft(); ?>
            <?= $function->BannerRight(); ?>
            <div class="header">
            <div class="img"></div>
        </div>
        <?php include 'app/Views/web/partials/nav.partial.php'; ?>
        <?= $function->MessagesAlert($pageid); ?>
        <div class="row">
            <div class="col-md-8">
                <div class="alert alert-danger">Oups, une erreur s'est produite, cette page n'existe pas ou plus.</div>
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
            </div>
        </div>
            
        </div>
       
        <script src="/public/js/jquery-3.3.1.min.js"></script>
        <script src="/public/js/bootstrap.min.js"></script>
        <script src="/public/plugins/lightbox/dist/jquery.fancybox.min.js"></script>
        <script src="/public/js/global.js"></script>
        <script>
            $('#load_fancy img').each(function(){
                var src = $(this).attr('src');
                $(this).wrap('<a data-fancybox="gallery" href="'+src+'"></a>');
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
	</body>
</html>