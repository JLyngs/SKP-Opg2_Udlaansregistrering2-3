<div class="row">
    <div class="col-md-12">
        <h2>Computere</h2>
        <a href="index.php?page=add_computer" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tilføj Ny Computer
        </a>
        <hr>
    </div>
</div>

<?php

if (isset($_POST['delete_computer']) && isset($_POST['computer_id'])) {
    $computerId = $_POST['computer_id'];
    if (deleteComputer($conn, $computerId)) {
        echo '<div class="alert alert-success">Computer blev slettet.</div>';
    } else {
        echo '<div class="alert alert-danger">Fejl: Computer kunne ikke slettes. Computeren er muligvis udlånt.</div>';
    }
}
?>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Tilgængelige Computere
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Computer Nr.</th>
                            <th>Fabrikat</th>
                            <th>Model</th>
                            <th>Mus</th>
                            <th>Tilstand</th>
                            <th>Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $computers = getAvailableComputers($conn);
                        while ($computer = mysqli_fetch_assoc($computers)) {
                            echo "<tr>";
                            echo "<td>" . $computer['id'] . "</td>";
                            echo "<td>" . $computer['fabricator'] . "</td>";
                            echo "<td>" . $computer['model'] . "</td>";
                            echo "<td>" . $computer['mouse_type'] . "</td>";
                            echo "<td>" . $computer['grade'] . " - " . $computer['state'] . "</td>";
                            echo "<td>
                                <a href='index.php?page=new_loan&computer_id=" . $computer['id'] . "' class='btn btn-sm btn-primary'>Udlån</a>
                                <button type='button' class='btn btn-sm btn-danger' onclick='confirmDelete(" . $computer['id'] . ")'>Slet</button>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Alle Computere
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Computer Nr.</th>
                            <th>Fabrikat</th>
                            <th>Model</th>
                            <th>Mus</th>
                            <th>Tilstand</th>
                            <th>Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $computers = getAllComputers($conn);
                        while ($computer = mysqli_fetch_assoc($computers)) {
                            echo "<tr>";
                            echo "<td>" . $computer['computer_number'] . "</td>";
                            echo "<td>" . $computer['fabricator'] . "</td>";
                            echo "<td>" . $computer['model'] . "</td>";
                            echo "<td>" . $computer['mouse_type'] . "</td>";
                            echo "<td>" . $computer['grade'] . " - " . $computer['state'] . "</td>";
                            echo "<td>
                                <button type='button' class='btn btn-sm btn-danger' onclick='confirmDelete(" . $computer['computer_number'] . ")'>Slet</button>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<form id="deleteForm" method="post" style="display: none;">
    <input type="hidden" name="computer_id" id="computerIdToDelete">
    <input type="hidden" name="delete_computer" value="1">
</form>

<script>
function confirmDelete(computerId) {
    if (confirm("Er du sikker på, at du vil slette computer nummer " + computerId + "?\nDenne handling kan ikke fortrydes.")) {
        document.getElementById('computerIdToDelete').value = computerId;
        document.getElementById('deleteForm').submit();
    }
}
</script>