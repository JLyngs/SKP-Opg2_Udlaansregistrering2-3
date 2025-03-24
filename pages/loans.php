<div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2>Aktive Udlån</h2>
        <a href="index.php?page=loan_history" class="btn btn-secondary">
            <i class="fas fa-history"></i> Udlåns Historik
        </a>
    </div>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                Udlånte Computere
            </div>
            <div class="card-body">
                <?php
                
                if (isset($_POST['return_loan'])) {
                    $loanId = $_POST['loan_id'];
                    if (returnLoan($conn, $loanId)) {
                        echo '<div class="alert alert-success">Computer registreret som afleveret.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Der opstod en fejl. Prøv igen.</div>';
                    }
                }
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Computer Nr.</th>
                            <th>Låner</th>
                            <th>Elev Nr.</th>
                            <th>Udlånsdato</th>
                            <th>Afleveringsdato</th>
                            <th>Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $loans = getLoanedComputers($conn);
                        if (mysqli_num_rows($loans) == 0) {
                            echo "<tr><td colspan='6' class='text-center'>Ingen aktive udlån</td></tr>";
                        } else {
                            while ($loan = mysqli_fetch_assoc($loans)) {
                                $currentDate = date('Y-m-d');
                                $rowClass = ($loan['end_date'] < $currentDate) ? 'table-danger' : '';
                                
                                echo "<tr class='" . $rowClass . "'>";
                                echo "<td>" . $loan['computer_number'] . "</td>";
                                echo "<td>" . $loan['name'] . "</td>";
                                echo "<td>" . $loan['student_number'] . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($loan['start_date'])) . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($loan['end_date'])) . "</td>";
                                echo "<td>
                                        <form method='post' onsubmit='return confirmReturn(" . $loan['computer_number'] . ")'>
                                            <input type='hidden' name='loan_id' value='" . $loan['loan_id'] . "'>
                                            <button type='submit' name='return_loan' class='btn btn-sm btn-success'>Aflever</button>
                                        </form>
                                      </td>";
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

<script>
function confirmReturn(computerNumber) {
    return confirm("Er du sikker på du vil registrere computer " + computerNumber + " som afleveret?");
}
</script>