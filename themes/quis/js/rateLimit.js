var QUIS = (function(my) {

  var init = function() {

        QUIS.$window
            .on("scroll touchmove", flush);

      },

      enqueue = function() {

        var callbacks = Array.prototype.slice.call(arguments);

        for (var i in callbacks) queue.push(callbacks[i]);

      },

      flush = function() {

        if (!scrollEnabled) return;

        scrollEnabled = false;

        clearTimeout(timer);
        timer = setTimeout(doCallbacks, 25);

      },

      doCallbacks = function() {

        scrollEnabled = true;
        for (var i in queue) queue[i]();

      },
      timer,
      queue = [],
      scrollEnabled = true;


  my.rateLimit = {

    init: init,
    queue: enqueue

  };

  return my;

}(QUIS||{}));
