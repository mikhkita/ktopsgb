<?php
return array (
  'readUser' => 
  array (
    'type' => 0,
    'description' => 'Просмотр пользователей',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateUser' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление пользователей',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readContainer' => 
  array (
    'type' => 0,
    'description' => 'Просмотр контейнеров',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateContainer' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление контейнеров',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateLocation' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление локации',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readDryer' => 
  array (
    'type' => 0,
    'description' => 'Просмотр раздела сушилок',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateDryer' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление сушилок',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateDryerQueue' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение загрузок в сушилки',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readCash' => 
  array (
    'type' => 0,
    'description' => 'Просмотр раздела платежей',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateCash' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление платежей',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'widgetCash' => 
  array (
    'type' => 0,
    'description' => 'Виджет',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readSaw' => 
  array (
    'type' => 0,
    'description' => 'Просмотр раздела пилорам',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateSaw' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление пилорам',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readWood' => 
  array (
    'type' => 0,
    'description' => 'Просмотр раздела отгрузок',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateWood' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление отгрузок',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readParabel' => 
  array (
    'type' => 0,
    'description' => 'Просмотр раздела машины из Парабели',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateParabel' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление отгрузок',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readIncoming' => 
  array (
    'type' => 0,
    'description' => 'Просмотр раздела входящий транспорт',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateIncoming' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление транспорта',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'readBoard' => 
  array (
    'type' => 0,
    'description' => 'Просмотр раздела доски Чин',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateBoard' => 
  array (
    'type' => 0,
    'description' => 'Создание/изменение/удаление раздела доски Чин',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'userAdmin' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readUser',
      1 => 'updateUser',
    ),
  ),
  'containerManager' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readContainer',
      1 => 'updateContainer',
      2 => 'updateLocation',
    ),
  ),
  'dryerManager' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readDryer',
      1 => 'updateDryerQueue',
    ),
    'assignments' => 
    array (
      5 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'dryerAdmin' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'dryerManager',
      1 => 'updateDryer',
    ),
  ),
  'cashManager' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readCash',
      1 => 'updateCash',
    ),
    'assignments' => 
    array (
      5 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'woodManager' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readWood',
      1 => 'updateWood',
    ),
    'assignments' => 
    array (
      5 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'parabelManager' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readParabel',
      1 => 'updateParabel',
    ),
    'assignments' => 
    array (
      5 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'incomingManager' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readIncoming',
      1 => 'updateIncoming',
    ),
    'assignments' => 
    array (
      5 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'boardManager' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readBoard',
      1 => 'updateBoard',
    ),
  ),
  'sawManager' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'readSaw',
      1 => 'updateSaw',
    ),
  ),
  'director' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'containerManager',
      1 => 'readDryer',
      2 => 'cashManager',
      3 => 'readWood',
      4 => 'readBoard',
      5 => 'readIncoming',
      6 => 'readParabel',
      7 => 'readSaw',
    ),
    'assignments' => 
    array (
      4 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
  'root' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'userAdmin',
      1 => 'dryerAdmin',
      2 => 'woodManager',
      3 => 'parabelManager',
      4 => 'incomingManager',
      5 => 'boardManager',
      6 => 'sawManager',
      7 => 'director',
    ),
    'assignments' => 
    array (
      1 => 
      array (
        'bizRule' => NULL,
        'data' => NULL,
      ),
    ),
  ),
);
