<!doctype html>
<html>
<head>
    <title>Contact - Ville d'Audruicq</title>
    <meta name="description" content="Contact">
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
                            <i class="fa fa-paper-plane"></i> Nous contacter
                        </div>
                        <div class="panel-body">
                            <form id="__contact">
                                <div class="form-group">
                                    <label>Votre prénom et nom</label>
                                    <input class="form-control" placeholder="Votre prénom et nom" name="fullname">
                                </div>
                                <div class="form-group">
                                    <label>Votre adresse email</label>
                                    <input class="form-control" placeholder="Votre adresse email" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Sujet</label>
                                    <input class="form-control" placeholder="Sujet" name="subject">
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" placeholder="Message" name="message" rows="8"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Envoyer</button>
                            </form>
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
                            <?php if($function->ListEvents('nonull') > 0) { ?>
                                <hr>
                                <a style="color: #444040" href="/events"><i class="fa fa-angle-double-right"></i> Voir tous les événements</a>
                            <?php } ?>
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
