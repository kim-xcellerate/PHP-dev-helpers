<?php


compareFunctionSpeed(100000, 'substring', 'calculate', [65489]);

function compareFunctionSpeed($loops, $callable1, $callable2, $args = []) {

    $avg1 = getAvgFunctionTime($loops, $callable1, $args);
    $avg2 = getAvgFunctionTime($loops, $callable2, $args);

    $decrease = $avg1 - $avg2;
    $decreasePercentage = $decrease / $avg1 * 100;

    switch(true) {
        case $decreasePercentage === 0:
            echo 'Function "' . $callable1 . '" was as fast as "' . $callable2 . '"';
            break;
        case $decreasePercentage < 0:
            echo 'Function "' . $callable1 . '" was ' . (int)abs($decreasePercentage) . '% faster "' . $callable2 . '"';
            break;
        case $decreasePercentage > 0:
            echo 'Function "' . $callable1 . '" was ' . (int)abs($decreasePercentage) . '% slower "' . $callable2 . '"';
            return 1;
            break;
    }
}

function getAvgFunctionTime($loops, $callable, $args = []) {
    $totalTime = 0;
    
    for($i = 0; $i < $loops; $i++) {
        $totalTime += timeFunction($callable, $args);
    }
    
    return $totalTime / $loops;
}

function timeFunction($callable, $args = []) {
    $time_start = microtime(true);

    call_user_func_array($callable, $args);
    
    $time_end = microtime(true);
    return $time_end - $time_start;
}


function substring($input) {
    return substr($input, 0, -2);
}

function calculate($input) {
    return (int)($input / 100);
}