// Infinite Scroll jQuery plugin
// copyright Paul Irish
// version 1.1.2008.09.25

// Modified by Chris Hill-Scott
// (stripped out bits I didn't need and made more readable)

// project home  : http://www.infinite-scroll.com
// documentation : http://www.infinite-scroll.com/infinite-scroll-jquery-plugin/

// dual license  : GPL : http://creativecommons.org/licenses/GPL/2.0/
//               : MIT : http://creativecommons.org/licenses/MIT/

// todo: add callback for the complete (404) state.
//       add preloading option.
//       fix with jorn's syntax improvements.

;(function($){

  $.fn.infinitescroll = function(options) {

    if (QUIS.isMobile) {

      return this;

    }

    var opts = $.extend({}, $.fn.infinitescroll.defaults, options),
      props = $.fn.infinitescroll, // shorthand
      path = $(opts.nextSelector).attr("href") || "invalid"; // get the relative URL - everything past the domain name

    if (null === path.match("page")) return this;

    path = path.split("page");
    props.currPage = (path[1].replace(/\//gi, "")) - 1;
    path = path[0];

    // contentSelector is just the element you're calling the infinitescroll() method on.
    opts.contentSelector = opts.contentSelector || this;

    $.fn.infinitescroll.loadingMsg = $('<div id="infscr-loading" />');

    QUIS.$document
      .ajaxError(
        function(e,xhr,opt) {
          if (404 == xhr.status) {
            props.isDone = true; // die if we're out of pages
          }
        }
      );

    QUIS.rateLimit.queue(
      function() {
        infscrSetup(path,opts,props); // hook up the function to the window scroll event.
      }
    );

    // Behave nicely
    return this;

  };


  function isNearBottom() {

    var alltheway = QUIS.$document.height(),
	      scrolling = QUIS.$window.scrollTop() + (QUIS.$window.height() * 4);

    return (scrolling > alltheway);

  }

  function infscrSetup(path,opts,props) {

    var nearest = scrollPages.nearest();

    try {

      window.history.replaceState(
        {
          "fragment": ""
	      },
        "",
        (1 === nearest) ? path : path + "page/" + scrollPages.nearest()
      );

    } catch(err) {

    }

    if (props.isDuringAjax || props.isInvalidPage || props.isDone || !isNearBottom() || QUIS.isMobile) return;

    props.isDuringAjax = true; // we dont want to fire the ajax multiple times
    props.currPage++;

    props.loadingMsg
      .appendTo(opts.contentSelector)
      .show();

    var analyticsPath = path + "page/" + props.currPage + "/?mode=AJAX",
      pageID = "infscr-page-" + props.currPage;

    path = path + "page/" + props.currPage + "/"; // AJAX caching on the server side is currently broken

    $("<div/>")
      .attr("id", pageID)
      .attr("class","infscr-pages")
      .appendTo(opts.contentSelector)
      .load(
        path + " " + opts.itemSelector,
        null,
        function() {

          props.loadingMsg
            .delay(600)
            .fadeOut(
              "fast",
              function() {
                $(this)
                  .remove();
              }
            );

          if (props.isDone) { // if we've hit the last page...

            $("footer nav")
              .fadeIn("slow");

          }

          opts.callback.apply(this, [analyticsPath, pageID]);
          props.isDuringAjax = false;

        }
      );

  }

  $.extend(
    $.fn.infinitescroll,
    {
      defaults: {
        debug: false,
        nextSelector: "",
        loadingText: "",
        donetext: "",
        navSelector: "",
        contentSelector: null,           // not really a selector. :) it's whatever the method was called on..
        itemSelector: "",
        callback: function(path) {},
        offset: 1200
      },
      currPage: 1,
      currDOMChunk: null,  // defined in setup()'s load()
      isDuringAjax: false,
      isInvalidPage: false,
      isDone: false  // for when it goes all the way through the archive.
    }
  );

})(jQuery);
