<?php
$text = "1442мама14423";

function addSymbolToWords($text, $symbol) {
    $words = explode(" ", $text);
    $result = ""; // Переменная для хранения итогового результата

    foreach ($words as &$word) {
        $chars = [];
        $symbols = [];
        $letterCount = 0;
        $newWord = '';

        for ($i = 0; $i < mb_strlen($word, 'UTF-8'); $i++) {
            $char = mb_substr($word, $i, 1, 'UTF-8');
            if (preg_match('/^[\p{L}]+$/u', $char)) {
                $letterCount++;
                $chars[$i] = $char;
            } else {
                $symbols[$i] = $char;
            }
        }
        
        ksort($chars);
        ksort($symbols);

        $word = '';
        $keys = array_keys($chars + $symbols);
        sort($keys);
        
        $charCount = count($chars);
        $currentCharIndex = 0;
        
        foreach ($keys as $key) {
            if (isset($symbols[$key])) {
                $word .= $symbols[$key];
            }
          
            if (isset($chars[$key])) {
                $word .= $chars[$key];
                
                if ($charCount > 3 && $currentCharIndex === $charCount - 1) {
                    $word .= $symbol;
                }
                
                $currentCharIndex++;
            }
        }
        
        echo $word;
        $word = $newWord;
        $result .= $word . " "; // Добавляем слово к итоговой строке
    }

    return trim($result); // Удаляем лишние пробелы в конце строки и возвращаем итоговый результат
}

$response = addSymbolToWords($text, "*");
echo $response;