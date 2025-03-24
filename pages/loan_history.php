<div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2>Udlåns Historik</h2>
        <a href="index.php?page=loans" class="btn btn-success">
            <i class="fas fa-clipboard-list"></i> Aktive Udlån
        </a>
    </div>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Tidligere Udlån
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Computer Nr.</th>
                            <th>Låner</th>
                            <th>Elev Nr.</th>
                            <th>Udlånsdato</th>
                            <th>Afleveringsdato</th>
                            <th>Afleveret</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $loanHistory = getLoanHistory($conn);
                        if (mysqli_num_rows($loanHistory) == 0) {
                            echo "<tr><td colspan='6' class='text-center'>Ingen tidligere udlån</td></tr>";
                        } else {
                            while ($loan = mysqli_fetch_assoc($loanHistory)) {
                                echo "<tr>";
                                echo "<td>" . $loan['computer_number'] . "</td>";
                                echo "<td>" . $loan['name'] . "</td>";
                                echo "<td>" . $loan['student_number'] . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($loan['start_date'])) . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($loan['end_date'])) . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($loan['return_date'])) . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>