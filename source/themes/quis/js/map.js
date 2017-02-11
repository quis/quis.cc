var QUIS = (function(my) {

    var styles = [
          {
            "featureType":"administrative",
            "elementType":"all",
            "stylers":[
              {
                "visibility":"on"
              },
              {
                "saturation":-100
              },
              {
                "lightness":20
              }
            ]
          },
          {
            "featureType":"road",
            "elementType":"all",
            "stylers":[
              {
                "visibility":"on"
              },
              {
                "saturation":-100
              },
              {
                "lightness":40
              }
            ]
          },
          {
            "featureType":"water",
            "elementType":"all",
            "stylers":[
              {
                "visibility":"on"
              },
              {
                "saturation":-10
              },
              {
                "lightness":30
              }
            ]
          },
          {
            "featureType":"landscape.man_made",
            "elementType":"all",
            "stylers":[
              {
                "visibility":"simplified"
              },
              {
                "saturation":-60
              },
              {
                "lightness":10
              }
            ]
          },
          {
            "featureType":"landscape.natural",
            "elementType":"all",
            "stylers":[
              {
                "visibility":"simplified"
              },
              {
                "saturation":-60
              },
              {
                "lightness":60
              }
            ]
          },
          {
            "featureType":"poi",
            "elementType":"all",
            "stylers":[
              {
                "visibility":"off"
              },
              {
                "saturation":-100
              },
              {
                "lightness":60
              }
            ]
          },
          {
            "featureType":"transit",
            "elementType":"all",
            "stylers":[
              {
                "visibility":"off"
              },
              {
                "saturation":-100
              },
              {
                "lightness":60
              }
            ]
          }
        ],
        paths, lines,
        inProgress = false, $canvas = $([]),
        map,
        firstLoad = true,
        bounds,
        init = function() {

          google.maps.event.addDomListener(window, 'load', renderMap);

        },
        renderMap = function() {

          inProgress = true;

          bounds = new google.maps.LatLngBounds();

          paths = [];
          lines = [];

          $("#map-wrapper").remove();
          $("body").prepend("<div id='map-wrapper' class='map'><div id='map-canvas'></div></div>");

          $(".blogPost").each(function() {

            if ($(this).find(".onMap").length) $(this).addClass("hasMap");

          });

          $canvas = $("#map-canvas");

          map = new google.maps.Map(
            $canvas.get(0),
            {
              center: new google.maps.LatLng(48.7574884, 5.5816387),
              zoom: 6,
              mapTypeId: google.maps.MapTypeId.TERRAIN,
              mapTypeControl: false,
              disableDoubleClickZoom: true,
              draggable: false,
              scrollwheel: false,
              panControl: false,
              rotateControl: false,
              scaleControl: false,
              streetViewControl: false,
              zoomControl: false,
              styles: styles
            }
          );

          $(".onMap")
            .each(function(index) {

              var j = 0,
                  decodedPath = google.maps.geometry.encoding.decodePath(
                    $(this).data("route-to")
                  );

              $(this).attr("data-index", index);

              paths.push(
                {
                  numberOfPoints: decodedPath.length,
                  points: decodedPath,
                  lastProgress: 0,
                  pointsUsed: 0
                }
              );

              for (; j < decodedPath.length; j++) bounds.extend(decodedPath[j]);

              lines.push(
                new google.maps.Polyline({
                  strokeWeight: 2,
                  strokeColor: '#f82858',
                  strokeOpacity: 0.7,
                  icons: [{
                    icon: {
                      path: google.maps.SymbolPath.CIRCLE,
                      scale: 4,
                      strokeColor: '#ffffff',
                      strokeOpacity: 1,
                      fillColor: "#f82858",
                      fillOpacity: 0.7,
                      strokeWeight: 3
                    },
                    offset: '100%'
                  }],
                  map: map
                })
              );

            });

          map.fitBounds(bounds);

          inProgress = false;

          if (firstLoad) {
            scrollCircle();
            my.rateLimit.queue(scrollCircle);
            firstLoad = false;
          }

          showHideMap();

        },
        scrollCircle = function() {

          var $photoBlocks = $(".onMap"),
              index = $photoBlocks.filter(":above-the-fold").last().data("index"),
              $img,
              complete,
              icon,
              i, k,
              fudge, fudge2,
              path,
              progress,
              windowHeight = QUIS.$window.height(),
              scrollTop = QUIS.$body.scrollTop(),
              leg;

          if (inProgress) return;
          inProgress = true;

          for (i = 0; i < lines.length; i++) {

            fudge  = (0 === i) ? 0 : windowHeight;
            fudge2 = (0 === i) ? windowHeight : 0;

            $img = $photoBlocks.filter("[data-index=" + i +"]");

            complete = (scrollTop + fudge - $img.offset().top) / (parseInt($img.css('padding-top'), 10) - fudge2);
            complete = (complete < 0) ? 0 : complete;
            complete = (complete > 1) ? 1 : complete;

            icon = lines[i].get("icons")[0];

            icon.icon.fillOpacity = (i === index) ? 0.4 : 0;
            icon.icon.strokeOpacity = (i === index) ? 0.9 : 0;
            icon.offset = (paths[i].pointsUsed < paths[i].numberOfPoints) ? "100%" : (complete * 100) + "%";

            lines[i].set("icons", [icon]);

            if (i > index) {
              inProgress = false;
              break;
            }

            progress = Math.round(paths[i].numberOfPoints * complete);
            leg = paths[i].points.slice(paths[i].lastProgress, progress);
            path = leg.length ? lines[i].getPath() : null;

            for (k = 0; k < leg.length; k++) {

              if (progress < paths[i].lastProgress) {
                inProgress = false;
                break;
              }

              path.push(leg[k]);
              paths[i].pointsUsed++;

            }

            if (progress > paths[i].lastProgress) paths[i].lastProgress = progress;

          }

          inProgress = false;

        },
        showHideMap = function() {

          var show = !!$(".blogPost:above-the-fold").last().find(".onMap").length,
              $map = $("#map-wrapper"),
              mapVisibility = $map.is(":visible");

          if (mapVisibility && !show) $map.hide();

          if (!mapVisibility && show) $map.show();

        };

    my.map = {
      init: init,
      renderMap: renderMap
    };

    return my;

}(QUIS||{}));
