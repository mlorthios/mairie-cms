Barba.Pjax.init();
Barba.Prefetch.init();
Barba.Pjax.cacheEnabled = false;

const Marquee = Barba.BaseView.extend({
    namespace: 'marquee', 
    onEnterCompleted: () => {
        $.getScript( "/public/plugins/marquee/jquery.marquee.min.js");

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
        

    }
});

const reCaptcha = Barba.BaseView.extend({
    namespace: 'recaptcha',
    onEnterCompleted: () => {
        $.getScript( "https://www.google.com/recaptcha/api.js?render=6Le46YkUAAAAAOr5n00D7yCdtbQjFHpQBZ1DSZKD");
        $.getScript( "/public/plugins/marquee/jquery.marquee.min.js");
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
    }
});

Marquee.init()
reCaptcha.init()

var links = document.querySelectorAll('a[href]');
var cbk = function(e) {
	if(e.currentTarget.href === window.location.href) {
		e.preventDefault();
		e.stopPropagation();
	}
};

for(var i = 0; i < links.length; i++) {
	links[i].addEventListener('click', cbk);
}

Barba.Pjax.start();

$(document).ready(function() {
    $('body').on('submit', '#__comment_event', function (e) {
        e.preventDefault();

        var $this = $(this);
        var csrf = $('meta[name="csrf-token"]').attr('content');
        grecaptcha.ready(function() {
            $('#addcome').html('Vérification reCaptcha...');
            $('#addcome').attr("disabled", "disabled");
            grecaptcha.execute('6Le46YkUAAAAAOr5n00D7yCdtbQjFHpQBZ1DSZKD', {action: 'action_name'})
                .then(function(token) {
                    var data = $this.serializeArray();
                    data.push({'name': 'token', 'value': token});
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        url: '/api/web/event/add/comment',
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(json) {
                            if(json.status == 'success') {
                                console.log('success');

                                var data = new Array(json.response);

                                $('#add_c_event').prepend('<div class="comment_post">\n' +
                                    '                                      <div class="name">'+data[0][0]+' • '+data[0][2]+'</div>\n' +
                                    '                                      <div class="content">'+data[0][1]+'</div>\n' +
                                    '                                      </div><hr>');
                                $('#addcome').html('Commentaire ajouté')
                            } else {
                                console.log(json.response);
                                $('#addcome').html('Envoyer')
                                $('#addcome').removeAttr("disabled");
                            }
                        },
                        error: function(a, b) {
                            $('#addcome').html('Envoyer')
                            $('#addcome').removeAttr("disabled");
                        }
                    });
                });
        });
    });
});

$(document).ready(function() {
    $('body').on('submit', '#__comment', function (e) {
        e.preventDefault();

        var $this = $(this);
        var csrf = $('meta[name="csrf-token"]').attr('content');
        grecaptcha.ready(function() {
            $('#addcom').html('Vérification reCaptcha...');
            $('#addcom').attr("disabled", "disabled");
            grecaptcha.execute('6Le46YkUAAAAAOr5n00D7yCdtbQjFHpQBZ1DSZKD', {action: 'action_name'})
                .then(function(token) {
                    var data = $this.serializeArray();
                    data.push({'name': 'token', 'value': token});
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        url: '/api/web/news/add/comment',
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(json) {
                            if(json.status == 'success') {
                                console.log('success');

                                var data = new Array(json.response);

                                $('#add_comment').prepend('<div class="comment_post">\n' +
                                    '                                      <div class="name">'+data[0][0]+' • '+data[0][2]+'</div>\n' +
                                    '                                      <div class="content">'+data[0][1]+'</div>\n' +
                                    '                                      </div><hr>');
                                $('#addcom').html('Commentaire ajouté')
                            } else {
                                console.log(json.response);
                                $('#addcom').html('Envoyer')
                                $('#addcom').removeAttr("disabled");
                            }
                        },
                        error: function(a, b) {
                            $('#addcom').html('Envoyer')
                            $('#addcom').removeAttr("disabled");
                        }
                    });
                });
        });
    });
});