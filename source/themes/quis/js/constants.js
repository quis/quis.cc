var QUIS = (function(my) {

  my.focus = false; // Track element focus
  my.imageSelector = "img:not(.static)"; // Selector for the resizable images
  my.isMobile = (function() {

    //Initialize our user agent string to lower case.
    return !!navigator.userAgent.toLowerCase().match(/(iphone|ipod|ipad|symbian|android|palm|blackberry)/gi);

  }());

    my.$body = $("body");
    my.$page = $("html, body");
    my.$window = $(window);
    my.$document = $(document);

    return my;

}(QUIS||{}));
