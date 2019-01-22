<!doctype html>

<html>
	<head>
		<title><?= $data['title'] ?> - Ville d'Audruicq</title>
        <meta name="description" content="<?= htmlspecialchars(strip_tags(substr($data['content'], 0, 150))); ?>...">
        <meta name="author" content="Ville d'Audruicq">
        <meta name="keywords" content="">
		<meta charset="UTF-8">
        <meta name="robots" content="index, follow">
		<meta name="viewport" content="initial-scale=1.0">
        <meta name="csrf-token" content="<?= $csrf_token ?>">
        <link rel="stylesheet" href="/public/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/css/all.min.css">
        <link rel="stylesheet" href="/public/plugins/lightbox/dist/jquery.fancybox.min.css">
        <link rel="stylesheet" href="/public/css/styles.css">
        <script src='https://www.google.com/recaptcha/api.js?render=6Le46YkUAAAAAOr5n00D7yCdtbQjFHpQBZ1DSZKD'></script>
	</head>

	<body>
        <div id="barba-wrapper">
  <div class="barba-container" data-namespace="recaptcha">
        <div class="container">
            <?= $function->BannerLeft(); ?>
            <?= $function->BannerRight(); ?>
            <div class="header">
            <div class="img"></div>
        </div>
        <?php include 'partials/nav.partial.php'; ?>
        <?= $function->MessagesAlert($pageid); ?>
            <div style="display:none;" id="event_url"><?= $eventid ?></div>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="far fa-calendar"></i> <?= $data['title']; ?>
                    </div>
                    <div class="panel-body" id="load_fancy">
                       <?= $data['content']; ?>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-comments"></i> Commentaires
                    </div>
                    <div class="panel-body">
                        <form id="__comment_event">
                            <div class="row">
                                <input name="url" value="<?= $eventid ?>" style="display:none">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" rows="3" placeholder="Exprimez-vous..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" name="first_name" placeholder="Votre prénom">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" id="addcome" class="btn btn-primary btn-block">Envoyer</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="add_c_event">
                            <?php

                            $request = $db->prepare('SELECT * FROM events_comments WHERE event_url = ? ORDER BY date DESC LIMIT 10');
                            $request->execute(array($eventid));

                            $rowcount = $request->rowCount();

                            $months = array("Janvier","Février","Mars","Avril","Mai","Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre");

                            if($rowcount > 0) {
                                echo '<hr style="margin-top: 6px;">';
                                while($t = $request->fetch()) {

                                    $month = date("n", strtotime($t['date']));
                                    echo '<div class="comment_post">
                                      <div class="name">'.$t['first_name'].' • '.date("j", strtotime($t['date'])).' '.strtolower($months[$month-1]).' '.date("Y", strtotime($t['date'])).' à '.date("H:i", strtotime($t['date'])).'</div>
                                      <div class="content">'.$t['content'].'</div>
                                      </div><hr>';
                                }
                            }

                            ?>
                        </div>

                    </div>
                </div>
                <div class="legacy" style="margin-bottom: 20px; color: #000; text-align: center;">
                    <small>Ce site est protégé par reCAPTCHA et les <a style="color: #757575" href="https://policies.google.com/privacy" target="_blank">règles de confidentialité</a> et les <a style="color: #757575" href="https://policies.google.com/terms" target="_blank">conditions d'utilisation de Google</a> s'appliquent.</small>
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