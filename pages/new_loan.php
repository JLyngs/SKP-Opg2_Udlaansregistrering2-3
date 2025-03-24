<div class="row">
    <div class="col-md-12">
        <h2>Nyt Udlån</h2>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Registrer Nyt Udlån
            </div>
            <div class="card-body">
                <?php
                
                if (isset($_POST['create_loan'])) {
                    $userId = $_POST['user_id'];
                    $computerId = $_POST['computer_id'];
                    $startDate = $_POST['start_date'];
                    $endDate = $_POST['end_date'];
                    
                    if (createLoan($conn, $userId, $computerId, $startDate, $endDate)) {
                        echo '<div class="alert alert-success">Udlån oprettet med succes!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Der opstod en fejl. Prøv igen.</div>';
                    }
                }
                
                $selectedUserId = isset($_GET['user_id']) ? $_GET['user_id'] : '';
                $selectedComputerId = isset($_GET['computer_id']) ? $_GET['computer_id'] : '';
                ?>
                
                <form method="post">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Bruger</label>
                        <select class="form-select" name="user_id" id="user_id" required>
                            <option value="">Vælg Bruger</option>
                            <?php
                            $users = getAllUsers($conn);
                            while ($user = mysqli_fetch_assoc($users)) {
                                $selected = ($user['id'] == $selectedUserId) ? 'selected' : '';
                                echo "<option value='" . $user['id'] . "' " . $selected . ">" . $user['name'] . " (Elev Nr: " . $user['id'] . ")</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="computer_id" class="form-label">Computer</label>
                        <select class="form-select" name="computer_id" id="computer_id" required>
                            <option value="">Vælg Computer</option>
                            <?php
                            $computers = getAvailableComputers($conn);
                            while ($computer = mysqli_fetch_assoc($computers)) {
                                $selected = ($computer['id'] == $selectedComputerId) ? 'selected' : '';
                                echo "<option value='" . $computer['id'] . "' " . $selected . ">";
                                echo "Nr. " . $computer['id'] . " - ";
                                echo $computer['fabricator'] . " " . $computer['model'] . " | ";
                                echo "Mus: " . $computer['mouse_type'] . " | ";
                                echo "Tilstand: " . $computer['grade'] . " - " . $computer['state'];
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Udlånsdato</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Afleveringsdato</label>
                        <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required>
                    </div>
                    
                    <button type="submit" name="create_loan" class="btn btn-primary">Registrer Udlån</button>
                </form>
            </div>
        </div>
    </div>
</div>