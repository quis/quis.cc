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


var scrollPages = (function() { // Module pattern

  var  self = {

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

    }

  };

  // Public methods
  return {
    nearest: function() { // Get nearest image to current scroll position (as jQuery object)

      var $pages = $(".infscr-pages"), // This should use a cache
	        offsets = [0];

      if ($pages.length < 1) return 1;

      $pages.each(
        function(i) {
          offsets[i + 1] = parseInt($(this).offset().top, 10);
        }
      );

      return self.nearestNumber(
        offsets,
        parseInt(QUIS.$document.scrollTop(), 10)
      ) + 1;

    }
  };

}());
