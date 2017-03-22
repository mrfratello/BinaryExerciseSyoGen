<?php
    session_start();
    $start_number_ticket = (int) file_get_contents("../current_number.txt");
?>
<?php
    include_once "header.php";
?>
<h1>Генератор упражнений</h1>
<h2>Перевод чисел в разные системы счисления и арифмечиские действия с двоичными числами</h2>
<div class="row">
    <form method="GET" action="tickets.php" class="col-md-offset-3 col-md-6">
        <div class="form-group">
            <label for="examFile">Количество билетов:</label>
            <input type="text"
                   id="count_tickets"
                   class="form-control"
                   name="count_tickets"
                   value="9">
        </div>
        <div class="form-group">
            <label for="start_number_ticket">Начальный номер билета:</label>
            <input type="text"
                   id="start_number_ticket"
                   class="form-control"
                   name="start_number_ticket"
                   value="<?php echo $start_number_ticket; ?>">
        </div>
         <button class="btn btn-primary" type="submit">Генерировать</button>
    </form>
</div>
<?php
    include_once "footer.php";
?>
