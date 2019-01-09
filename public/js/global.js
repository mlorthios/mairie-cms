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

Marquee.init()

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