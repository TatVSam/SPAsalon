<?php
$monthsRus = ["January" => "января", "February" => "февраля", "March" => "марта", 
"April" => "апреля", "May" => "мая", "June" => "июня", "July" => "июля", "August" => "августа", 
"September" => "сентября", "October" => "октября", "November" => "ноября", "December" => "декабря"];

function getRussianDate ($engDate) {
    global $monthsRus;
    $temp = explode(" ", $engDate);
    $day = $temp[0];
    $month = $temp[1];
    return mb_substr($day, 0, -2) . " " . $monthsRus[$month];
}

function dayEnding ($days) {
    $tensOnes = $days % 100;
    if (($tensOnes >= 11) && ($tensOnes <= 14)) return "дней";
    if (($tensOnes < 11) || ($tensOnes > 14)) {
        if ($tensOnes % 10 == 1) {
            return "день";
        } elseif (($tensOnes % 10 == 2) || ($tensOnes % 10 == 3) || ($tensOnes % 10 == 4)) {
            return "дня";
        } else return "дней";

    }
}

?>