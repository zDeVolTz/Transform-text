<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["text"])) {
    $text = $_POST["text"];

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

            if ($charCount > 6 && $currentCharIndex === $charCount - 1) {
              $word .= $symbol;
            }

            $currentCharIndex++;
          }
        }

        $newWord = $word;
        $result .= $word . " "; // Добавляем слово к итоговой строке
      }

      return trim($result); // Удаляем лишние пробелы в конце строки и возвращаем итоговый результат
    }

    $response = addSymbolToWords($text, ")");
    echo json_encode($response);
  } else {
    echo json_encode("Ошибка: Ключ 'text' не найден в данных POST.");
  }
} else {
  echo json_encode("Ошибка: Запрос должен быть выполнен методом POST.");
}
?>
