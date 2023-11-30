<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo os valores do formulário e convertendo para números
    $peso = filter_input(INPUT_POST, 'peso', FILTER_VALIDATE_FLOAT);
    $alturaRaw = $_POST["altura"];

    // Substituindo vírgula por ponto na altura, caso exista
    $altura = str_replace(',', '.', $alturaRaw);
    
    // Se não houver ponto ou vírgula na altura, assumimos que está em metros
    if (strpos($altura, '.') === false) {
        $altura /= 100; // Convertendo para metros
    }

    $altura = filter_var($altura, FILTER_VALIDATE_FLOAT);

    // Verificando se os valores são válidos
    if ($peso !== false && $altura !== false && $peso > 0 && $altura > 0) {
        // Calculando o IMC
        $imc = $peso / ($altura * $altura);

        // Determinando a situação do usuário
        if ($imc < 17) {
            $situacao = "Muito abaixo do peso";
        } elseif ($imc >= 17 && $imc < 18.5) {
            $situacao = "Abaixo do peso";
        } elseif ($imc >= 18.5 && $imc < 25) {
            $situacao = "Peso normal";
        } elseif ($imc >= 25 && $imc < 30) {
            $situacao = "Acima do peso";
        } elseif ($imc >= 30 && $imc < 35) {
            $situacao = "Obesidade I";
        } elseif ($imc >= 35 && $imc < 40) {
            $situacao = "Obesidade II (severa)";
        } else {
            $situacao = "Obesidade III (mórbida)";
        }

        // Exibindo resultados
        echo "<h2>Resultado do IMC</h2>";
        echo "<p>Seu IMC é: " . number_format($imc, 2) . "</p>";
        echo "<p>Situação: " . $situacao . "</p>";
    } else {
        echo "<p>Por favor, insira valores válidos para peso e altura.</p>";
    }
}
?>
