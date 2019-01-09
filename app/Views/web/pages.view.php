<!doctype html>

<html>
	<head>
		<title><?= $data['name'] ?> - Ville d'Audruicq</title>
        <meta name="description" content="<?= $data['description'] ?>">
        <meta name="author" content="Ville d'Audruicq">
        <meta name="keywords" content="<?= strtolower($data['description']) ?>">
        <meta name="robots" content="index, follow">
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
                        <?= $data['name']; ?>
                    </div>
                    <div class="panel-body" id="load_fancy">
                       <?= $data['content']; ?>
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
            
        </div>
            </div></div>
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