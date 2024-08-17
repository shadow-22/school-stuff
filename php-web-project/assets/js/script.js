$(function() {
  $.scrollify({
    section: ".panel",
    sectionName: false,
    scrollSpeed: 1100,
    overflowScroll: true,
    setHeights: false,
    interstitialSection: ".headersec,.footersec",
    standardScrollElements: ".modal",
    before: function(i,panels) {
      var ref = panels[i].attr("data-section-name");
    },
    after: function(i,panels) {
      var ref = panels[i].attr("data-section-name");

      if(ref==="header") {
         $.scrollify.instantNext();
      }
    }
  });
});
