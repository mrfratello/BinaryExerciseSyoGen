<?php
    function mustAll($number)
    {
        return false;
    }

    function mustBe3units($number)
    {
        return (substr_count(decbin($number), '1') != 3);
    }

    function mustBeLetters($number)
    {
        return !preg_match('/\D/', dechex($number));
    }

    function getRandomNumber($category, $rule='mustAll')
    {
        do {
            $number = 2 ** $category;
            for ($i = $category - 1; $i >= 0; $i--) {
                $digit = rand(0, 1);
                $number += $digit * 2 ** $i;
            }
        } while( $rule($number) );
        return array(
                'bin' => decbin($number),
                'dec' => $number,
                'hex' => dechex($number),
        );
    }

    function getTickets($count_tickets)
    {
        $tickets = array();
        for ($i = 0; $i < $count_tickets; $i++) {
            $single_ticket = array(
                'from_2_to_10' => getRandomNumber(rand(8, 10)),
                'from_10_to_2' => getRandomNumber(rand(6, 8)),
                'from_10_to_16' => getRandomNumber(rand(8, 10), "mustBeLetters"),
                'from_2_to_16' => getRandomNumber(array(8, 12, 14)[array_rand(array(8, 12, 14), 1)]),
                'sum' => array(
                    getRandomNumber(8),
                    getRandomNumber(6),
                ),
                'multi' => array(
                    getRandomNumber(6),
                    getRandomNumber(4, "mustBe3units"),
                ),
            );
            array_push($tickets, $single_ticket);
        }
        return $tickets;
    }

    function printNumberInNotation($number, $notation)
    {
        $notation_dict = array(
            'dec' => 10,
            'hex' => 16,
            'bin' => 2
        );
        return $number[$notation] . "<sub>" . $notation_dict[$notation] . "</sub>";
    }

    function printExpression($term, $result, $notation, $action)
    {
        return printNumberInNotation($term[0], $notation)
            . $action
            . printNumberInNotation($term[1], $notation)
            . " = "
            . printNumberInNotation($result, $notation) ;
    }

    if (isset($_GET['count_tickets'])) {
        include_once "header.php";
        $count_tickets = (int) $_GET['count_tickets'];
        $ticket_list = getTickets( $count_tickets );
        for ($i = 0; $i < count($ticket_list); $i++) {
?>
    <div class="ticket">
        <div class="ticket__header text-center">
            Билет №<?php echo $i + 1; ?>
        </div>
        <div class="ticket__body">
            <ol class="questions">
                <li>
                    Перевести в <strong>десятичную</strong> систему счисления: <br/>
                    <?php echo printNumberInNotation($ticket_list[$i]['from_2_to_10'], 'bin'); ?>
                </li>
                <li>
                    Перевести в <strong>двоичную</strong> систему счисления: <br/>
                    <?php echo printNumberInNotation($ticket_list[$i]['from_10_to_2'], 'dec'); ?>
                </li>
                <li>
                    Перевести в <strong>шестнадцатиричную</strong> систему счисления: <br/>
                    <?php echo printNumberInNotation($ticket_list[$i]['from_10_to_16'], 'dec'); ?>
                </li>
                <li>
                    Перевести в <strong>шестнадцатиричную</strong> систему счисления: <br/>
                    <?php echo printNumberInNotation($ticket_list[$i]['from_2_to_16'], 'bin'); ?>
                </li>
                <li>
                    Вычислить сумму двоичных чисел: <br/>
                    <?php echo printNumberInNotation($ticket_list[$i]['sum'][0], 'bin'); ?>
                    +
                    <?php echo printNumberInNotation($ticket_list[$i]['sum'][1], 'bin'); ?>
                </li>
                <li>
                    Вычислить произведение двоичных чисел: <br/>
                    <?php echo printNumberInNotation($ticket_list[$i]['multi'][0], 'bin'); ?>
                    *
                    <?php echo printNumberInNotation($ticket_list[$i]['multi'][1], 'bin'); ?>
                </li>
            </ol>
        </div>
    </div>

<?php
        }
?>
    <div class="ticket ticket_result">
        <div class="ticket__header ticket_result__header text-center">
            Ответы на билеты
        </div>
        <div class="ticket__body ticket_result__body">
            <?php
                for ($i = 0; $i < count($ticket_list); $i++) {
            ?>
                <div class="single-ticket-answer">
                    <div>
                        <strong>Билет №<?php echo $i + 1; ?></strong>
                    </div>
                    <ol>
                        <li>
                            <?php echo printNumberInNotation($ticket_list[$i]['from_2_to_10'], 'bin'); ?>,
                            <strong><?php echo printNumberInNotation($ticket_list[$i]['from_2_to_10'], 'dec'); ?></strong>,
                            <?php echo printNumberInNotation($ticket_list[$i]['from_2_to_10'], 'hex'); ?>
                        </li>
                        <li>
                            <strong><?php echo printNumberInNotation($ticket_list[$i]['from_10_to_2'], 'bin'); ?></strong>,
                            <?php echo printNumberInNotation($ticket_list[$i]['from_10_to_2'], 'dec'); ?>,
                            <?php echo printNumberInNotation($ticket_list[$i]['from_10_to_2'], 'hex'); ?>
                        </li>
                        <li>
                            <?php echo printNumberInNotation($ticket_list[$i]['from_10_to_16'], 'bin'); ?>,
                            <?php echo printNumberInNotation($ticket_list[$i]['from_10_to_16'], 'dec'); ?>,
                            <strong><?php echo printNumberInNotation($ticket_list[$i]['from_10_to_16'], 'hex'); ?></strong>
                        </li>
                        <li>
                            <?php echo printNumberInNotation($ticket_list[$i]['from_2_to_16'], 'bin'); ?>,
                            <?php echo printNumberInNotation($ticket_list[$i]['from_2_to_16'], 'dec'); ?>,
                            <strong><?php echo printNumberInNotation($ticket_list[$i]['from_2_to_16'], 'hex'); ?></strong>
                        </li>
                        <li>
                            <?php
                                $sum_result = $ticket_list[$i]['sum'][0]['dec'] + $ticket_list[$i]['sum'][1]['dec'];
                                $sum_result = array(
                                    'bin' => decbin($sum_result),
                                    'dec' => $sum_result,
                                    'hex' => dechex($sum_result),
                                );
                                echo printExpression($ticket_list[$i]['sum'], $sum_result, 'bin', " + ") . ", <br/>";
                                echo printExpression($ticket_list[$i]['sum'], $sum_result, 'dec', " + ");
                            ?>
                        </li>
                        <li>
                            <?php
                                $multi_result = $ticket_list[$i]['multi'][0]['dec'] * $ticket_list[$i]['multi'][1]['dec'];
                                $multi_result = array(
                                    'bin' => decbin($multi_result),
                                    'dec' => $multi_result,
                                    'hex' => dechex($multi_result),
                                );
                                echo printExpression($ticket_list[$i]['multi'], $multi_result, 'bin', " * ") . ", <br/>";
                                echo printExpression($ticket_list[$i]['multi'], $multi_result, 'dec', " * ");
                            ?>
                        </li>
                    </ol>
                </div>
            <?php
                }
            ?>
        </div>
    </div>
<?php

        include_once "footer.php";
    } else {
        header("Location: /");
    }
?>
