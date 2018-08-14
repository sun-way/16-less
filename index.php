<?php
require "core/core.php";
@$searchResults = new SearchResults(getParam('address'), getParam('addressID')); // создаем объект
$lastSearchID = $searchResults->getLastSearchID(); // ID элемента, который будет отображаться на карте
$resultForMap = $searchResults->getItemByID($lastSearchID); // элемент, который будет отображаться на карте
$searchQuery = (getParam('address') !== null OR getParam('addressID') !== null) ?
    $searchResults->getSearchQuery() : ''; // поисковой запрос
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Домашнее задание по теме <?= $homeWorkNum ?> <?= $homeWorkCaption ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript">
    </script>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
<h1>Определение точки на карте по введенному адресу</h1>
<div class="form-container">

    <form class="form" method="POST">
        <h2>Введите адрес:</h2>
        <input class="text_input" type="text" name="address"
               placeholder="Например: г. Москва, ул. Таганрогская, д. 26"
               value="<?= $searchQuery ?>"/>
        <input type="submit" name="find" value="Найти"/>
    </form>

    <?php
    if ($searchResults->getFoundCount() > 0) : ?>

        <h2>Найденные результаты:</h2>
        <table>
            <tr>
                <th>Адрес</th>
                <th>Координаты</th>
            </tr>

            <?php
            $i = 0;
            foreach ($searchResults->getList() as $item) :
                ?>

                <tr>
                    <td>
                        <a href="?addressID=<?= $i ?>">
                            <?= $i === $lastSearchID ? '<strong>' : '' ?>
                            <?= $item->getAddress() ?>
                            <?= $i === $lastSearchID ? '</strong>' : '' ?>
                        </a>
                    </td>
                    <td><?= sprintf('Широта: %s, долгота: %s', $item->getLatitude(), $item->getLongitude()) ?></td>
                </tr>

                <?php
                $i++;
            endforeach; ?>
        </table>

    <?php if (!empty($resultForMap)) : ?>

        <script type="text/javascript">
            ymaps.ready(init);
            var myMap, myPlacemark;
            function init() {
                myMap = new ymaps.Map("map", {
                    center: [<?= $resultForMap->getLatitude() ?>, <?= $resultForMap->getLongitude() ?>],
                    zoom: 10
                });
                myPlacemark = new ymaps.Placemark([<?= $resultForMap->getLatitude() ?>, <?= $resultForMap->getLongitude() ?>], {
                    hintContent: '<?= $resultForMap->getAddress() ?>',
                    balloonContent: '<?= $resultForMap->getAddress() ?>'
                });
                myMap.geoObjects.add(myPlacemark);
            }
        </script>

        <div id="map" style="width: 600px; height: 400px"></div>
    <?php endif; ?>
    <?php endif; ?>

</div>
</body>
</html>