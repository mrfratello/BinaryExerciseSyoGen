<?php
    session_start();
?>
<?php
    include_once "header.php";
?>
<h1>Генератор упражнений</h1>
<h2>Перевод чисел в разные системы счисления и арифмечиские действия с двоичными числами</h2>
<form method="GET" action="tickets.php">
    <div class="form-group">
        <label for="examFile">Количество билетов:</label>
        <input type="text" id="count_tickets" name="count_tickets" class="form-control">
    </div>
     <button class="btn btn-primary" type="submit">Генерировать</button>
</form>
<?php
    include_once "footer.php";
?>
