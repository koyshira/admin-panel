<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>

    <!-- Styles -->
    <link href="css/style.css" rel="stylesheet" />
</head>
<body>

<?php
require_once 'php/modules/fetchData.php';
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Admin Panel</h1>
        </div>

        <!-- Buttons -->
        <div class="card">
            <!-- User Lookup -->
            <button class="button" onclick="toggleVisibility('user-data')">User Info</button>
            <!-- Admin Logs -->
            <button class="button" onclick="toggleVisibility('adminlogs')">Admin Logs</button>
            <!-- Ban Logs -->
            <button class="button" onclick="toggleVisibility('banlogs')">Ban Logs</button>
            <!-- Ticket Logs -->
            <button class="button" onclick="toggleVisibility('ticketlogs')">Ticket Logs</button>
            <!-- Refresh Data -->
            <button class="button" onclick="location.reload()">Refresh Data</button>
        </div>

        <!-- Account -->
        <div class="card">
            <div class="card-header">
                <div id="user-data">
                    <?php 
                    if(!isset($_GET['Login']) && !isset($_GET['accessLevel'])) {
                      $userData = fetchData($connections["pixel"], "SELECT Login, Email, Redbucks, Gocoins, Totalplayed, Totalweekplayed FROM accounts LIMIT 1");
                      $accessLevel = fetchData($connections["pixel"], "SELECT adminlvl FROM characters LIMIT 1");
                    } else {
                      $userData = array (
                        array (
                          'Login' => urldecode($_GET['Login']),
                          'Email' => urldecode($_GET['Email']),
                          'Redbucks' => urldecode($_GET['Redbucks']),
                          'Gocoins' => urldecode($_GET['Gocoins']),
                          'Totalplayed' => urldecode($_GET['Totalplayed']),
                          'Totalweekplayed' => urldecode($_GET['Totalweekplayed']),
                          'AccessLevel' => urldecode($_GET['accessLevel'])
                        )
                      );
                    }
                    ?>

                    <fieldset class="user-info">
                        <legend>User Data for <em><?php echo $userData[0]['Login']; ?></em></legend>

                        <div class="card">
                            <p><span title="<?php echo $userData[0]['Email']; ?>">Email: <?php echo $userData[0]['Email']; ?> (email icon)</span></p>
                        </div>

                        <fieldset>
                            <legend>Access Level</legend>

                            <div class="card">
                                <p><strong>Admin Level:</strong> 
                                <?php 
                                if(isset($_GET['accessLevel'])) {
                                  echo $userData[0]['AccessLevel']; 
                                } else {
                                  echo $accessLevel[0]['adminlvl'];
                                }
                                ?>
                              </p>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Currency</legend>

                            <div class="card">
                                <p><strong>Redbucks:</strong> <?php echo $userData[0]['Redbucks']; ?></p>
                            </div>

                            <div class="card">
                                <p><strong>Gocoins:</strong> <?php echo $userData[0]['Gocoins']; ?></p>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Play Time</legend>

                            <div class="card">
                                <p><strong>Total Played:</strong> <?php echo $userData[0]['Totalplayed']; ?></p>
                            </div>

                            <div class="card">
                                <p><strong>Total Weekly Played:</strong> <?php echo $userData[0]['Totalweekplayed']; ?></p>
                            </div>
                        </fieldset>
                    </fieldset>
                    
                    <!-- Lookup user by name or id -->
                    <fieldset>
                        <form action="php/lookup.php" method="post">
                            <input type="text" name="lookup" placeholder="Enter ID" />
                            <input type="submit" value="Lookup" />
                        </form>
                    </fieldset>
                </div>
                <div id="adminlogs">
                    <?php
                    $adminLogs = fetchData($connections["pixellogs"], "SELECT * FROM adminlog ORDER BY time DESC LIMIT 100");
                  
                    echo '<fieldset class="logs"><legend>Admin Logs (Recent 100)</legend>';
                    if (!$adminLogs) {
                        echo '<p>No admin logs found</p>';
                    } else {
                        foreach ($adminLogs as $log) {
                            echo '<div class="card">';
                            echo '<p>' . $log['time'] . ' - ' . $log['admin'] . ': ' . $log['action'] . ' ' . $log['player'] . '</p>';
                            echo '</div>';
                        }
                    }
                    echo '</fieldset>';
                    ?>
                </div>
                <div id="banlogs">
                    <?php
                    $banLogs = fetchData($connections["pixellogs"], "SELECT * FROM banlog ORDER BY time DESC LIMIT 100");
                  
                    echo '<fieldset class="logs"><legend>Ban Logs (Recent 100)</legend>';
                    if (!$banLogs) {
                        echo '<p>No ban logs found</p>';
                    } else {
                        foreach ($banLogs as $log) {
                            echo '<div class="card">';
                            echo '<p>' . $log['time'] . ' - ' . $log['player'] . 'banned ' . $log['target'] . ' (' . $log['reason'] . ')</p>';
                            echo '</div>';
                        }
                    }
                    echo '</fieldset>';
                    ?>
                </div>
                <div id="ticketlogs">
                    <?php
                    $ticketLogs = fetchData($connections["pixellogs"], "SELECT * FROM ticketlog ORDER BY time DESC LIMIT 100");
                  
                    echo '<fieldset class="logs"><legend>Ticket Logs (Recent 100)</legend>';
                    if (!$ticketLogs) {
                        echo '<p>No ticket logs found</p>';
                    } else {
                        foreach ($ticketLogs as $log) {
                            echo '<div class="card">';
                            echo '<p>' . $log['time'] . ' - ' . $log['pnick'] . 'opened ticket for ' . $log['tnick'] . ' (' . $log['reason'] . ')</p>';
                            echo '</div>';
                        }
                    }
                    echo '</fieldset>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="scripts/buttons.js"></script>
</body>
</html>
