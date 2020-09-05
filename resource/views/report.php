<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report</title>
</head>
<body>
<style>
    tr, th, td {
        border: 1px solid black
    }
</style>
<div>
    <?php if ($usersReports):?>
        <table>

            <tr>
                <th>Customer Id</th>
                <th>Total Count Calls</th>
                <th>Total Duration Calls</th>
                <th>Continent Count Calls</th>
                <th>Continent Duration Calls</th>
            </tr>

            <?php foreach ($usersReports as $item):?>
                <tr>
                    <td><?=$item->id?></td>
                    <td><?=$item->totalCountCalls?></td>
                    <td><?=$item->totalDurationCalls?></td>
                    <td><?=$item->continentCountCalls?></td>
                    <td><?=$item->continentDurationCalls?></td>
                </tr>
            <?php endforeach;?>

        </table>
    <?php else:?>

        <p>empty</p>

    <?php endif;?>
</div>
</body>
</html>
