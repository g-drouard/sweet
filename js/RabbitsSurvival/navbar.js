$("#nav-main-menu").menumaker({
    title: "Menu",
    breakpoint: 768,
    format: "multitoggle"
});

$('#nav-main-menu').prepend("<div id='menu-indicator'></div>");

var foundActive = false, activeElement, indicatorPosition, indicator = $('#nav-main-menu #menu-indicator'), defaultPosition;

$("#nav-main-menu > ul > li").each(function() {
  if ($(this).hasClass('active')) {
    activeElement = $(this);
    foundActive = true;
  }
});

if (foundActive === false) {
  activeElement = $("#nav-main-menu > ul > li").first();
}

defaultPosition = indicatorPosition = activeElement.position().left + activeElement.width()/2 - 5;
indicator.css("left", indicatorPosition);

$("#nav-main-menu > ul > li").hover(function() {
  activeElement = $(this);
  indicatorPosition = activeElement.position().left + activeElement.width()/2 - 5;
  indicator.css("left", indicatorPosition);
}, function() {
  indicator.css("left", defaultPosition);
});