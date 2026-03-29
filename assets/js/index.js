import $ from "jquery";
import Foundation from "foundation-sites";

$(function () {
  $(document).foundation();

  $("#header-main").toggleClass("at-top", $(window).scrollTop() === 0);
  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    $("#header-main").toggleClass("at-top", scroll === 0);
  });
  $("#bubble-tabs").on("change.zf.tabs", function () {
    $(this).addClass("is-open");
  });
  $("#bubble-tabs").on("collapse.zf.tabs", function () {
    $(this).removeClass("is-open");
  });
});
