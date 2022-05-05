<?php

require 'Calendar.php';

$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');


$calendar = new Calendar();
$array = $calendar->getMonth($year, $month);

$months = array(
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July ',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December',
);
//print '<pre>';
//print_r($array);

?>


<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            background: white;
            color: black;
        }

        th,
        td {
            font-weight: bold;
        }
    </style>
</head>

<body>
<!-- Here we are using attributes like
    cellspacing and cellpadding -->

<!-- The purpose of the cellpadding is
    the space that a user want between
    the border of cell and its contents-->

<!-- cellspacing is used to specify the
    space between the cell and its contents -->
<h2 align="center" style="color: orange;">
    <?php echo $months[$month]; ?> <?php echo $year; ?>
</h2>
<br />

<table bgcolor="lightgrey" align="center"
       cellspacing="21" cellpadding="21">


    <caption align="top">
        <!-- Here we have used the attribute
            that is style and we have colored
            the sentence to make it better
            depending on the web page-->
    </caption>

    <!-- Here th stands for the heading of the
        table that comes in the first row-->

    <!-- The text in this table header tag will
        appear as bold and is center aligned-->

    <thead>
    <tr>
        <!-- Here we have applied inline style
             to make it more attractive-->
        <th style="color: white; background: purple;">
            Sun</th>
        <th style="color: white; background: purple;">
            Mon</th>
        <th style="color: white; background: purple;">
            Tue</th>
        <th style="color: white; background: purple;">
            Wed</th>
        <th style="color: white; background: purple;">
            Thu</th>
        <th style="color: white; background: purple;">
            Fri</th>
        <th style="color: white; background: purple;">
            Sat</th>
    </tr>
    </thead>

    <tbody>

    <?php
        foreach ($array['days'] as $weeks) {
            echo '<tr>';
            foreach ($weeks as $week) {
                ?>
                    <td style="<?php echo ($week['included'] ? '' : 'color: #a1a1a1;'); ?>"><?php echo $week['day']; ?></td>
                <?php
            }
            echo '</tr>';
        }

    ?>

    </tbody>
</table>
</body>

</html>
