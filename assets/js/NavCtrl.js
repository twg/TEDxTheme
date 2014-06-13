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