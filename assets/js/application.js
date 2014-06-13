//-- Initialize -------------------------------------------------------------
$(document).ready(function () {
  var team_tiles = $('.team-tile');
  if (team_tiles.length > 0) {
    $.each(team_tiles, function (index, value) {
      new TeamTile($(value));
    });
  }
});


//-- TeamTile Class ---------------------------------------------------------
function TeamTile(el) {
  this.max_tile_info_height = 77;
  this.tile_el = el;

  var resizeTile = function (tile, max_height) {
    var tile_height = tile.outerHeight();
    var info = tile.find('.team-info');
    var info_height = info.outerHeight();
    if (info_height > max_height) {
      var top = (info_height - max_height) * -1;
      var height = (tile_height - (  info_height - max_height));
      info.css('position', 'relative').css('top', top);
      tile.css('height', height);
    }
  };

  this.init = function () {
    resizeTile(this.tile_el, this.max_tile_info_height);
  };

  this.init();
}

//-- Migrating to Angular ---------------------------------------------------
angular.module('TEDxTheme', []);