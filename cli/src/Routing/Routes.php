<?php
$router = new AltoRouter();

// Add your routes here
$router->map('GET', '/', 'IncidentReporter\Controllers\GeneralController@map', 'map_home');

$router->map('GET', '/login', 'IncidentReporter\Controllers\GeneralController@login', 'login');
$router->map('POST', '/login', 'IncidentReporter\Controllers\GeneralController@auth', 'auth');

$router->map('GET', '/submit', 'IncidentReporter\Controllers\GeneralController@index', 'submit');
$router->map('POST', '/submit', 'IncidentReporter\Controllers\GeneralController@submit', 'submit-event');

$router->map('GET', '/success', 'IncidentReporter\Controllers\GeneralController@success', 'success');

$router->map('GET', '/event-list', 'IncidentReporter\Controllers\GeneralController@getList', 'events');
$router->map('POST', '/event-toggle/[i:id]', 'IncidentReporter\Controllers\GeneralController@toggleEvent', 'change_evt_status');

$router->map('GET', '/401', 'IncidentReporter\Controllers\GeneralController@unauthorized', '401');

$router->map('GET', '/map', 'IncidentReporter\Controllers\GeneralController@map', 'map');

$router->map('GET', '/check-events', 'IncidentReporter\Controllers\ServiceController@checkEvents', 'check');
$router->map('GET', '/vessel-pos', 'IncidentReporter\Controllers\ServiceController@getVesselPos', 'vpos');
$router->map('GET', '/nearby-pos', 'IncidentReporter\Controllers\ServiceController@getNearbyPos', 'npos');




