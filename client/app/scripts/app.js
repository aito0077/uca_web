'use strict';

/**
 * @ngdoc overview
 * @name ucaApp
 * @description
 * # ucaApp
 *
 * Main module of the application.
 */
angular
  .module('ucaApp', [
    'ngAnimate',
    'ngAria',
    'ngCookies',
    'ngMessages',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'config',
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl',
        controllerAs: 'main'
      })
      .when('/organizations/:id', {
        templateUrl: 'views/emprendimiento.html',
        controller: 'organization-controller'
      })
      .otherwise({
        redirectTo: '/'
      });
      moment.locale('es');

  })
.filter('moment', function() {
    return function(dateString, format) {
        return moment(dateString).format(format);
    };
});
