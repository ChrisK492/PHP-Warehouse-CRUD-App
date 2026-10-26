<?php
require_once "../private/autoloader.php";


class ChartsManager
{
    public static function MakeCharts(int $offset = 0): array
    {
        global $con;

        $monday = new DateTime('monday this week');
        $monday->setTime(0, 0);

        $startDate = (clone $monday)->modify("$offset weeks");
        $endDate   = (clone $startDate)->modify("+7 days");

        $stmt = $con->prepare(
            "SELECT DATE(`ChangeDate`) AS x, SUM(`quantity_change`) AS total
         FROM `stock_change`
         WHERE `ChangeDate` >= ? AND `ChangeDate` < ?
         GROUP BY DATE(`ChangeDate`)
         ORDER BY x ASC"
        );

        $stmt->bindValue(1, $startDate->format("Y-m-d"));
        $stmt->bindValue(2, $endDate->format("Y-m-d"));

        $stmt->execute();

        $totals = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $totals[$row['x']] = (float)$row['total'];
        }

        $xAs = [];
        $yAs = [];
        $loopDate = clone $startDate;

        for ($i = 0; $i < 7; $i++) {
            $day = $loopDate->format("Y-m-d");
            $xAs[] = $day;
            $yAs[] = $totals[$day] ?? 0;
            $loopDate->modify("+1 day");
        }

        return ['x' => $xAs, 'y' => $yAs];
    }

    public static function MakeProductChart(int $productId, int $offset = 0): array
    {
        global $con;

        $monday = new DateTime('monday this week');
        $monday->setTime(0, 0);

        $startDate = (clone $monday)->modify("$offset weeks");
        $endDate   = (clone $startDate)->modify("+7 days");

        $stmt = $con->prepare(
            "SELECT DATE(`ChangeDate`) AS x, SUM(`quantity_change`) AS total
         FROM `stock_change`
         WHERE `product_id` = ?
           AND `ChangeDate` >= ? AND `ChangeDate` < ?
         GROUP BY DATE(`ChangeDate`)
         ORDER BY x ASC"
        );

        // порядок bindValue = порядок знаков ? в запросе
        $stmt->bindValue(1, $productId, PDO::PARAM_INT);
        $stmt->bindValue(2, $startDate->format("Y-m-d"));
        $stmt->bindValue(3, $endDate->format("Y-m-d"));

        $stmt->execute();

        $totals = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $totals[$row['x']] = (float)$row['total'];
        }

        $xAs = [];
        $yAs = [];
        $loopDate = clone $startDate;

        for ($i = 0; $i < 7; $i++) {
            $day = $loopDate->format("Y-m-d");
            $xAs[] = $day;
            $yAs[] = $totals[$day] ?? 0;
            $loopDate->modify("+1 day");
        }

        return ['x' => $xAs, 'y' => $yAs];
    }
}
