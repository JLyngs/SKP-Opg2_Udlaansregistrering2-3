<div class="row">
    <div class="col-md-12">
        <h2>Tilføj Ny Computer</h2>
        <a href="index.php?page=computers" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Tilbage til Computere
        </a>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                Indtast Computer Detaljer
            </div>
            <div class="card-body">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $fabricator = $_POST['fabricator'];
                    $model = $_POST['model'];
                    $mouseType = $_POST['mouse_type'];
                    $gradeStateId = $_POST['grade_state_id'];

                    $errors = [];
                    if (empty($fabricator)) $errors[] = "Fabrikat er påkrævet";
                    if (empty($model)) $errors[] = "Model er påkrævet";
                    if (empty($mouseType)) $errors[] = "Mus type er påkrævet";
                    if (empty($gradeStateId)) $errors[] = "Tilstand er påkrævet";

                    if (empty($errors)) {
                        if (addComputer($conn, $fabricator, $model, $mouseType, $gradeStateId)) {
                            echo '<div class="alert alert-success">Computer er blevet tilføjet!</div>';
                            $fabricator = $model = $mouseType = $gradeStateId = "";
                        } else {
                            echo '<div class="alert alert-danger">Fejl: Computer kunne ikke tilføjes. ' . mysqli_error($conn) . '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger"><ul>';
                        foreach ($errors as $error) {
                            echo '<li>' . $error . '</li>';
                        }
                        echo '</ul></div>';
                    }
                }
                ?>

                <form method="post" action="index.php?page=add_computer">
                    <div class="mb-3">
                        <label for="fabricator" class="form-label">Fabrikat</label>
                        <input type="text" class="form-control" id="fabricator" name="fabricator" value="<?php echo isset($fabricator) ? $fabricator : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" value="<?php echo isset($model) ? $model : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="mouse_type" class="form-label">Mus Type</label>
                        <select class="form-select" id="mouse_type" name="mouse_type" required>
                            <option value="">Vælg mus type</option>
                            <option value="Optisk" <?php echo (isset($mouseType) && $mouseType == 'Optisk') ? 'selected' : ''; ?>>Optisk</option>
                            <option value="Almindelig" <?php echo (isset($mouseType) && $mouseType == 'Almindelig') ? 'selected' : ''; ?>>Almindelig</option>
                            <option value="Nej" <?php echo (isset($mouseType) && $mouseType == 'Nej') ? 'selected' : ''; ?>>Nej</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="grade_state_id" class="form-label">Tilstand</label>
                        <select class="form-select" id="grade_state_id" name="grade_state_id" required>
                            <option value="">Vælg tilstand</option>
                            <?php
                            $gradeStates = getAllGradeStates($conn);
                            while ($gradeState = mysqli_fetch_assoc($gradeStates)) {
                                $selected = (isset($gradeStateId) && $gradeStateId == $gradeState['id']) ? 'selected' : '';
                                echo "<option value='" . $gradeState['id'] . "' $selected>" . $gradeState['grade'] . " - " . $gradeState['state'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Tilføj Computer</button>
                </form>
            </div>
        </div>
    </div>
</div>