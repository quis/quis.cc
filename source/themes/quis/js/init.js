//     =============================================
//
//     WWW.QUIS.CC
//     ---------------------------------------------
//
//     By Chris Hill-Scott, except where noted.
//
//     =============================================

$(function() {

    for (var module in QUIS) {

      if (QUIS[module].init) QUIS[module].init();

    }

    if (!QUIS.isMobile) {

      $(".next-link")
          .hide();

    }

    // Automatically load new photos when scrolling near bottom of page
    $("#photos")
      .infinitescroll(
        {
          navSelector: "footer",
          nextSelector: ".next-link a",
          itemSelector: ".unit",
          loadingText: "Loading more photos",
          donetext: "No more photos",
          callback: function(path, pageID) {

            // size newly-loaded images
            $("#" + pageID + " " + QUIS.imageSelector)
              .imageScale();

            QUIS.map.renderMap();

            if (_gaq) {
              // Notify Google Analytics of page view
              _gaq.push(['_trackPageview', path]);
            }

          }
        }
      );

    // Keyboard navigation controller
    $(document)
      .keydown(
        function(event) {

          switch (event.keyCode || event.which) {
            case 74: // j
            case 40: // down arrow
              return scrollPhotos.go(1);
            case 75: // k
            case 38: // up arrow
              return scrollPhotos.go(-1);
          }

        }
      );

});
