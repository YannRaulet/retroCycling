(function(){
    let popupCenter = function(url, title, width, height){
        /*Get pop up size width, height and if undefined gives the value */
        let popupWidth = width || 640;
        let popupHeight = height || 320;

        /*Pop up position compatible for all browsers
            Get the current frame's height and width
        */
        let windowLeft = window.screenLeft || window.screenX;
        let windowTop = window.screenTop || window.screenY;
        let windowWidth = window.innerWidth || document.documentElement.clientWidth;
        let windowHeight = window.innerHeight || document.documentElement.clientHeight;

        /*Calculation to center the window in the middle of the page*/
        let popupLeft = windowLeft + windowWidth / 2 - popupWidth / 2 ;
        let popupTop = windowTop + windowHeight / 2 - popupHeight / 2;

        /* displays a social network pop-up */
        let popup = window.open(url, title, 'scrollbars=yes, width=' + popupWidth + ', height=' + popupHeight + ', top=' + popupTop + ', left=' + popupLeft);
        popup.focus();
        return true;
    };

    document.querySelector('.share_twitter').addEventListener('click', function(e){
        e.preventDefault();

        /*Allows you to retrieve the url of the article in twig*/
        let url = this.getAttribute('data-url');

        /*Share the article and escape all characters except: letters of the Latin alphabet, numbers (Arabic)*/
        let shareUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(document.title) +
            "&url=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Twitter");
    });

    document.querySelector('.share_facebook').addEventListener('click', function(e){
        e.preventDefault();
        let url = this.getAttribute('data-url');
        let shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur facebook");
    });

    document.querySelector('.share_gplus').addEventListener('click', function(e){
        e.preventDefault();
        let url = this.getAttribute('data-url');
        let shareUrl = "https://plus.google.com/share?url=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Google+");
    });

    document.querySelector('.share_linkedin').addEventListener('click', function(e){
        e.preventDefault();
        let url = this.getAttribute('data-url');
        let shareUrl = "https://www.linkedin.com/shareArticle?url=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Linkedin");
    });

})();