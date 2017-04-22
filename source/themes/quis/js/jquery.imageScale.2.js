//     =============================================
//
//     SCALE ELEMENTS TO FIT A FIXED CONTAINER SIZE
//     ---------------------------------------------
//
//     By Chris Hill-Scott 2009-10
//
//     Code is public domain, reuse as desired
//
//     Requires jQuery
//
//     ---------------------------------------------
//
//     NOTES: This is complex, but it's highly
//     optimized and it works.
//
//     ---------------------------------------------
//
//     USAGE: $("img").imageScale();
//
//     =============================================

// Use self-executing anonymous function to namespace
var imageScaleTools = (function() {

  return {

    // Object to hold our cache of jQuery objects and option objects
    selectors: {},

    // Wrapper for the image scaling function which scales
    // cached object collections, rather than do a re-lookup,
    // useful when the container resizes, for example
    cached: function() {

      $.each(
        imageScaleTools.selectors,
        function() {
          this.$collection.imageScale(this.options);
        }
      );

    },

    images: function() {

      // To implement: function to return the cache of images

    },

    // Apply image scaling to a jQuery collection
    live: function(options) {

      var defaults = {
          scale: {
            x: 1,
            y: 0.9
          }, // controls the ammount of matte around the image, "1" will completely fill the screen
          attr: {
            x: "data-width",
            y: "data-height"
          },
          speed: 100,
          updateCache: true
        },
        container = {
          x: $(".hasTooltip").width(),
          y: window.innerHeight ? window.innerHeight : $(window).height() // iOS workaround
        },
        max,
        $this = $(this);

            options = $.extend({}, defaults, options);
            max = {
                x: parseInt(container.x * options.scale.x, 10), // parseInt() makes things look better in FF
                y: parseInt(container.y * options.scale.y, 10) //
            };

      if (
        (QUIS.orientation == 90) ||
        (QUIS.orientation == -90)
      ) {

        var temp = max.x;
        max.x = max.y;
        max.y = temp;

        temp = null;

      }

      // Only do costly re-querying when we need to (and cache objects when we don't)
      if (options.updateCache) {

        options.updateCache = false; // Option that is sent into the cached version

        imageScaleTools.selectors[$this.selector] = {
          $collection: $this,
          options: options
        };

      }

      // Behave nicely, return a jQuery object
      return this.each(
        function() {

          var $img = $(this),
            nat = {
              x: $img.attr(options.attr.x),
              y: $img.attr(options.attr.y)
            },
            newHeight = max.x/(nat.x/nat.y),
            dimensions;

          // Determine if image needs resizing in some way
          if ((nat.x > max.x) || (nat.y > max.y)) {

            dimensions = {
              "width": (newHeight > max.y) ? "auto" : max.x, // This switch determines if we're resizing
              "height": (newHeight > max.y) ? max.y : "auto" // based on excess height or width
            };

          } else { // Image is naturaly smaller than viewport

            dimensions = {
              "width": "auto", // Give size control back to the browser
              "height": "auto"
            };
          }

          $img.css(dimensions);

        }
      );

    }

  };

}());

// Hook our function into jQuery
jQuery.fn.imageScale = imageScaleTools.live;

// Hook our function into the window resize event, avoiding conflicts and using caching
$(function(){

  $(window)
    .resize(imageScaleTools.cached);

  window.onorientationchange = function() {

    QUIS.orientation = window.orientation;
    imageScaleTools.cached();

  };

});
