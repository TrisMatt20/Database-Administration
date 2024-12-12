<?php include('connect.php');

$flightFilterList = array(
    'Below 100 mins',
    'Between 100 mins-300 mins',
    'Between 301 mins-500 mins',
    'More than 500 mins'
);

$filterConditionList = array(
    'flightDurationMinutes < 100',
    'flightDurationMinutes BETWEEN 100 AND 300',
    'flightDurationMinutes BETWEEN 301 AND 500',
    'flightDurationMinutes > 500'
);

$flightLogQuery = "SELECT * FROM flightLogs";

$aircraftFilter = isset($_GET['aircraftName']) ? $_GET['aircraftName'] : '';
$flightDurationFilter = isset($_GET['flightDuration']) ? $_GET['flightDuration'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';

if ($aircraftFilter != '' || $flightDurationFilter != '') {
    $flightLogQuery .= " WHERE";

    $conditions = [];

    if ($aircraftFilter != '') {
        $conditions[] = "aircraftType = '$aircraftFilter'";
    }

    if ($flightDurationFilter != '') {
        $conditions[] = $flightDurationFilter;
    }

    $flightLogQuery .= " " . implode(" AND ", $conditions);
}

if ($sort != '') {
    $flightLogQuery = $flightLogQuery . " ORDER BY $sort";

    if ($order != '') {
        $flightLogQuery = $flightLogQuery . " $order";
    }
}

$flightLogResult = executeQuery($flightLogQuery);
$aircraftTypeQuery = "SELECT DISTINCT(aircraftType) FROM flightlogs";
$aircraftTypeResults = executeQuery($aircraftTypeQuery);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PUP Airport</title>
    <link rel="icon" href="assets/img/pup-airport-favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="background-color: #800000 !important;">
        <div class="container-fluid d-flex justify-content-center">
            <a class="navbar-brand" href="./"><img src="assets/img/pup-airport-logo-brand.svg"></a>
        </div>
    </nav>
    <div class="filter-container">
        <form>
            <div class="row">
                <div class="col-lg-4">
                    <label for="select1">Aircraft type</label>
                    <select onchange="this.form.submit()" value="" name="aircraftName" id="aircraftName"
                        class="form-select form-select-sm" aria-label="Default select example">
                        <option value="" selected>All</option>
                        <?php if (mysqli_num_rows($aircraftTypeResults) > 0) {
                            while ($aircraftTypeRow = mysqli_fetch_assoc($aircraftTypeResults)) { ?>
                                <option <?php echo ($aircraftFilter == $aircraftTypeRow['aircraftType']) ? 'selected' : ''; ?>
                                    value="<?php echo $aircraftTypeRow['aircraftType'] ?>">
                                    <?php echo $aircraftTypeRow['aircraftType'] ?>
                                </option>
                            <?php }
                        } ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="select2">Flight duration</label>
                    <select onchange="this.form.submit()" value="" name="flightDuration" id="flightDuration"
                        class="form-select form-select-sm" aria-label="Default select example">
                        <option value="" selected>All</option>
                        <?php
                        for ($i = 0; $i < count($flightFilterList); $i++) {
                            $filterValue = $filterConditionList[$i];
                            $filterLabel = $flightFilterList[$i];
                            ?>
                            <option value="<?php echo $filterValue; ?>" <?php echo ($flightDurationFilter == $filterValue) ? 'selected' : ''; ?>>
                                <?php echo $filterLabel; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <label for="select3">Sort by</label>
                    <select onchange="this.form.submit()" value="" name="sort" id="sort"
                        class="form-select form-select-sm" aria-label="Default select example">
                        <option value="" selected>None</option>
                        <option <?php echo ($sort == "pilotName") ? "selected" : ''; ?> value="pilotName">By Pilot name</option>
                        <option <?php echo ($sort == "flightDurationMinutes") ? "selected" : ''; ?> value="flightDurationMinutes">By flight duration</option>
                        <option <?php echo ($sort == "flightNumber") ? "selected" : ''; ?> value="flightNumber">By flight number</option>
                    </select>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <label for="select3">Order</label>
                    <select onchange="this.form.submit()" value="" name="order" id="order"
                        class="form-select form-select-sm" aria-label="Default select example">
                        <option <?php echo ($order == "ASC") ? "selected" : '';?> value="ASC" selected>ASCENDING</option>
                        <option <?php echo ($order == "DESC") ? "selected" : '';?> value="DESC">DESCENDING</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="table-container m-3 rounded-4">
        <table class="table table-striped" style="border: 1px solid #D5D5D5;">
            <thead>
                <tr>
                    <th class="center-data" scope="col">Flight No.</th>
                    <th class="center-data" scope="col">Dept. Code</th>
                    <th class="center-data" scope="col">Dept. Time</th>
                    <th class="center-data" scope="col">Arriv. Time</th>
                    <th class="center-data" scope="col">Flight duration</th>
                    <th scope="col">Airline</th>
                    <th scope="col">Aircraft</th>
                    <th scope="col">Pilot</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($flightLogResult) > 0) {
                    while ($flightLogsRow = mysqli_fetch_assoc($flightLogResult)) { ?>
                        <tr>
                            <th class="center-data" scope="row"><?php echo $flightLogsRow['flightNumber']; ?></th>
                            <td class="center-data"><?php echo $flightLogsRow['departureAirportCode']; ?></td>
                            <td class="center-data"><?php echo $flightLogsRow['departureDatetime']; ?></td>
                            <td class="center-data"><?php echo $flightLogsRow['arrivalDatetime']; ?></td>
                            <td class="center-data"><?php echo $flightLogsRow['flightDurationMinutes']; ?></td>
                            <td><?php echo $flightLogsRow['airlineName']; ?></td>
                            <td><?php echo $flightLogsRow['aircraftType']; ?></td>
                            <td><?php echo $flightLogsRow['pilotName']; ?></td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>