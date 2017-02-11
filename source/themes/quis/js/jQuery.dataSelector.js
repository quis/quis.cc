$.expr[":"].data = function(el, idx, selector) {

  var attr = selector[3].split(", ");
  return el.dataset[attr[0]] == attr[1];

};
