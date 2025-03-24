<div class="row">
    <div class="col-md-12">
        <h2>Brugere</h2>
        <a href="index.php?page=add_user" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tilføj Ny Bruger
        </a>
        <hr>
    </div>
</div>

<?php
// Handle blacklist/unblacklist actions
if (isset($_POST['toggle_blacklist'])) {
    $userId = $_POST['user_id'];
    $action = $_POST['action']; // 'blacklist' or 'unblacklist'
    
    if ($action === 'blacklist') {
        if (blacklistUser($conn, $userId)) {
            // Send email notification
            $user = getUserById($conn, $userId);
            sendBlacklistEmail($user, true);
            echo '<div class="alert alert-success">Bruger er blevet blacklistet.</div>';
        } else {
            echo '<div class="alert alert-danger">Fejl: Kunne ikke blackliste bruger.</div>';
        }
    } elseif ($action === 'unblacklist') {
        if (unblacklistUser($conn, $userId)) {
            // Send email notification
            $user = getUserById($conn, $userId);
            sendBlacklistEmail($user, false);
            echo '<div class="alert alert-success">Bruger er blevet fjernet fra blacklist.</div>';
        } else {
            echo '<div class="alert alert-danger">Fejl: Kunne ikke fjerne bruger fra blacklist.</div>';
        }
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Alle Brugere
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Elev Nr.</th>
                            <th>Navn</th>
                            <th>Email</th>
                            <th>Klasse</th>
                            <th>Status</th>
                            <th>Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = getAllUsers($conn);
                        while ($user = mysqli_fetch_assoc($users)) {
                            $isBlacklisted = $user['is_blacklisted'] == 1;
                            $statusBadge = $isBlacklisted 
                                ? '<span class="badge bg-danger">Blacklistet</span>' 
                                : '<span class="badge bg-success">Aktiv</span>';
                            
                            echo "<tr>";
                            echo "<td>" . $user['id'] . "</td>";
                            echo "<td>" . $user['name'] . "</td>";
                            echo "<td>" . $user['email'] . "</td>";
                            echo "<td>" . $user['class'] . "</td>";
                            echo "<td>" . $statusBadge . "</td>";
                            echo "<td class='d-flex gap-2'>";
                            
                            if (!$isBlacklisted) {
                                echo "<a href='index.php?page=new_loan&user_id=" . $user['id'] . "' class='btn btn-sm btn-primary'>Udlån</a>";
                                echo "<form method='post' onsubmit='return confirmBlacklist(\"" . htmlspecialchars($user['name']) . "\")'>
                                        <input type='hidden' name='user_id' value='" . $user['id'] . "'>
                                        <input type='hidden' name='action' value='blacklist'>
                                        <button type='submit' name='toggle_blacklist' class='btn btn-sm btn-danger'>Blacklist</button>
                                      </form>";
                            } else {
                                echo "<form method='post' onsubmit='return confirmUnblacklist(\"" . htmlspecialchars($user['name']) . "\")'>
                                        <input type='hidden' name='user_id' value='" . $user['id'] . "'>
                                        <input type='hidden' name='action' value='unblacklist'>
                                        <button type='submit' name='toggle_blacklist' class='btn btn-sm btn-success'>Fjern Blacklist</button>
                                      </form>";
                            }
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmBlacklist(userName) {
    return confirm("Er du sikker på, at du vil blackliste " + userName + "? Brugeren vil ikke kunne låne computere og vil modtage en email om dette.");
}

function confirmUnblacklist(userName) {
    return confirm("Er du sikker på, at du vil fjerne " + userName + " fra blacklist? Brugeren vil igen kunne låne computere og vil modtage en email om dette.");
}
</script>