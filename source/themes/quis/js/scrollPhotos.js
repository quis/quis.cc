//     =============================================
//
//     SCROLL A PAGE FROM ONE ELEMENT TO ANOTHER
//     ---------------------------------------------
//
//     By Chris Hill-Scott, except where noted.
//
//     Code is public domain, reuse as desired.
//
//     Requires jQuery
//
//     ---------------------------------------------
//
//     TODO: Add an event queue
//
//     =============================================


var scrollPhotos = (function() { // Module pattern

  var self = {

    to: function(offset, time) { // Animate a scroll

      self.inProgress = true;

      QUIS.$page.animate(
        {
          scrollTop: offset
        },
        time,
        function() {

          self.inProgress = false;

        }
      );

      QUIS.$window.trigger("scroll");

      return false;

    },
    nearestNumber: function(a, n) { // nearestNumber(a: Array, n: Number): Integer

      if ((l = a.length) < 2) {
        return l - 1;
      }

      for (var l, p = Math.abs(a[--l] - n); l--;) {
        if (p < (p = Math.abs(a[l] - n))) {
          break;
        }
      }

      return l + 1;

    },
    go: function() {

      var scrollTop = parseInt(QUIS.$document.scrollTop(), 10),
	        current = scrollPhotos.nearest(0).offset(),
	        next = scrollPhotos.nearest(self.direction).offset();

      if ((scrollTop < 250) && (-1 == self.direction)) {
        return self.to(0, self.time / 2);
      }

      if ((scrollTop < 150) && (1 == self.direction)) {
        return self.to((current.top - self.topMargin), self.time / 2);
      }

      if (next) {
        return self.to((next.top - self.topMargin), self.time);
      }

    },
    inProgress: false,
    direction: null,
    time: 200,
    topMargin: 18

  };

  // Public methods
  return {
    go: function goWrapper(direction) {

      self.direction = direction;

      if (self.inProgress) {

        setTimeout(
          goWrapper,
          100
        );

        return false;

      }

      self.go();

    },
    nearest: function(traverse) { // Get nearest image to current scroll position (as jQuery object)

//    var $photos = $("img, .blogPost > h2, .blogPost > p:not(.meta)"),
      var $photos = $("img"), // This should use a cache
        offsets = [];

      $photos.each(
        function(i) {
          offsets[i] = parseInt($(this).offset().top, 10);
        }
      );

      return $photos.eq(
        self.nearestNumber(
          offsets,
          parseInt(QUIS.$document.scrollTop(), 10)
        ) + traverse
      );

    }
  };

}());
