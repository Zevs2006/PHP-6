<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Задания</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
        h2 { color: #333; }
        pre { background: #f4f4f4; padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>PHP Задания</h1>
    
    <!-- Задание 1 -->
    <h2>1. Обратный массив</h2>
    <pre>
        <?php
        $array = [];
        for ($i = 0; $i < 10; $i++) {
            $array[] = rand(1, 100);
        }
        echo "Оригинальный массив: " . implode(", ", $array) . "\n";
        echo "Обратный массив: ";
        for ($i = count($array) - 1; $i >= 0; $i--) {
            echo $array[$i] . " ";
        }
        ?>
    </pre>

     <!-- Задание 2: Группировка по возрастам -->
     <h2>2. Группировка по возрастам</h2>
    <!-- Форма для ввода возрастов -->
    <form method="POST">
        <label for="ages">Введите возраст через запятую (например: 12,25,17,8):</label><br>
        <input type="text" name="ages" id="ages" required>
        <button type="submit" name="task2">Группировать</button>
    </form>
    <pre>
        <?php
        if (isset($_POST['task2'])) {
            // Получаем строку возрастов от пользователя
            $agesInput = $_POST['ages']; // "12,25,17,8"
            
            // Преобразуем строку в массив, убираем пробелы
            $ages = array_map('trim', explode(',', $agesInput)); // [12, 25, 17, 8]

            // Создаем массивы для каждой группы
            $children = []; // Дети (младше 18)
            $adults = [];   // Взрослые (от 18 до 35)
            $elders = [];   // Пожилые (старше 35)

            // Распределяем по группам
            foreach ($ages as $age) {
                if ($age < 18) {
                    $children[] = $age;
                } elseif ($age <= 35) {
                    $adults[] = $age;
                } else {
                    $elders[] = $age;
                }
            }

            // Выводим группы
            echo "Дети: " . implode(", ", $children) . "\n";
            echo "Взрослые: " . implode(", ", $adults) . "\n";
            echo "Пожилые: " . implode(", ", $elders) . "\n";
        }
        ?>
    </pre>

    <!-- Задание 3 -->
    <h2>3. Частотный анализ символов</h2>
    <pre>
        <?php
        $string = "banana";
        $frequency = [];
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if (isset($frequency[$char])) {
                $frequency[$char]++;
            } else {
                $frequency[$char] = 1;
            }
        }
        foreach ($frequency as $char => $count) {
            echo "$char => $count\n";
        }
        ?>
    </pre>

     <!-- Задание 4: Сумма цифр числа -->
     <h2>4. Сумма цифр числа</h2>
    <!-- Форма для ввода числа -->
    <form method="POST">
        <label for="number">Введите число:</label><br>
        <input type="number" name="number" id="number" required>
        <button type="submit" name="task4">Вычислить сумму цифр</button>
    </form>
    <pre>
        <?php
        if (isset($_POST['task4'])) {
            // Получаем число от пользователя
            $number = (int)$_POST['number']; // Преобразуем в число
            echo "Число: $number\n";

            // Преобразуем число в строку и разбиваем на массив цифр
            $digits = str_split((string)$number); // Например, [5, 4, 3, 2, 1]

            // Считаем сумму
            $sum = 0;
            foreach ($digits as $digit) {
                $sum += (int)$digit; // Суммируем цифры
            }

            // Выводим результат
            echo "Сумма цифр: $sum\n";
        }
        ?>
    </pre>

    <!-- Задание 5 -->
    <h2>5. Календарь месяца</h2>
     <!-- Форма для ввода месяца и года -->
     <form method="POST">
        <label for="month">Месяц (1-12):</label>
        <input type="number" id="month" name="month" min="1" max="12" required>
        <label for="year">Год:</label>
        <input type="number" id="year" name="year" required>
        <button type="submit">Показать календарь</button>
    </form>
    <pre>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получаем введенные пользователем месяц и год
            $month = (int)$_POST['month'];
            $year = (int)$_POST['year'];

            // Убеждаемся, что данные корректны
            if ($month < 1 || $month > 12 || $year < 1) {
                echo "<p>Пожалуйста, введите корректные значения месяца (1-12) и года.</p>";
            } else {
                // Определяем количество дней в месяце
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                // Определяем день недели первого числа месяца
                $firstDayOfWeek = date('w', mktime(0, 0, 0, $month, 1, $year));
                if ($firstDayOfWeek == 0) {
                    $firstDayOfWeek = 7; // Преобразуем воскресенье (0) в 7 для удобства
                }

                // Массив с названиями дней недели
                $daysOfWeek = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];

                // Выводим таблицу
                echo "<h2>Календарь для $month/$year</h2>";
                echo "<table>";
                echo "<tr>";
                foreach ($daysOfWeek as $day) {
                    echo "<th>$day</th>";
                }
                echo "</tr><tr>";

                // Пустые ячейки перед первым днем месяца
                for ($i = 1; $i < $firstDayOfWeek; $i++) {
                    echo "<td></td>";
                }

                // Заполняем календарь днями месяца
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    echo "<td>$day</td>";
                    // Переход на следующую строку после воскресенья
                    if (($day + $firstDayOfWeek - 1) % 7 == 0) {
                        echo "</tr><tr>";
                    }
                }

                // Пустые ячейки после последнего дня месяца
                $lastDayOfWeek = ($daysInMonth + $firstDayOfWeek - 1) % 7;
                if ($lastDayOfWeek != 0) {
                    for ($i = $lastDayOfWeek; $i < 7; $i++) {
                        echo "<td></td>";
                    }
                }

                echo "</tr>";
                echo "</table>";
            }
        }
        ?>
    </pre>

</body>
</html>
