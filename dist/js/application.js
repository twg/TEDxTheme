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
/**
*   I know I'm not supposed to manipulate DOM elements in a controller, but
*   WordPress is making it very hard to write this properly. So please
*   excuse the mess.
*/
angular.module('TEDxTheme').controller('NavCtrl', function($scope) {

  $scope.toggleMenu = function() {
    if($scope.isVisible) {
      $('nav.primary-nav ul.menu').css('max-height', 0);
      $scope.isVisible = false;
    }else{
      $('nav.primary-nav ul.menu').css('max-height', $scope.maxHeight());
      $scope.isVisible = true;
    }
  };

  $scope.maxHeight = function() {
    var count = $('nav.primary-nav ul.menu > li').length;
    return count * 65; // 65px height for nav elements
  };

});