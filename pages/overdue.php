<div class="row">
    <div class="col-md-12">
        <h2>Overskredet Afleveringsfrist</h2>
        <hr>
    </div>
</div>

<?php
if (isset($_POST['send_email'])) {
    $loanId = $_POST['loan_id'];
    $studentName = $_POST['student_name'];
    $studentEmail = $_POST['student_email'];
    $computerNumber = $_POST['computer_number'];
    $endDate = $_POST['end_date'];
    $daysOverdue = $_POST['days_overdue'];
    
    if (sendOverdueEmail($studentName, $studentEmail, $computerNumber, $endDate, $daysOverdue)) {
        echo '<div class="alert alert-success">Påmindelse er blevet sendt til ' . $studentEmail . '</div>';
    } else {
        echo '<div class="alert alert-danger">Fejl: Kunne ikke sende email.</div>';
    }
}

if (isset($_POST['return_loan'])) {
    $loanId = $_POST['loan_id'];
    if (returnLoan($conn, $loanId)) {
        echo '<div class="alert alert-success">Computer registreret som afleveret.</div>';
    } else {
        echo '<div class="alert alert-danger">Der opstod en fejl. Prøv igen.</div>';
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                Overskredet Udlån
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Computer Nr.</th>
                            <th>Låner</th>
                            <th>Email</th>
                            <th>Elev Nr.</th>
                            <th>Udlånsdato</th>
                            <th>Afleveringsdato</th>
                            <th>Dage Overskredet</th>
                            <th>Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $overdue = getOverdueLoans($conn);
                        if (mysqli_num_rows($overdue) == 0) {
                            echo "<tr><td colspan='8' class='text-center'>Ingen overskredet udlån</td></tr>";
                        } else {
                            while ($loan = mysqli_fetch_assoc($overdue)) {
                                $formattedStartDate = date('d/m/Y', strtotime($loan['start_date']));
                                $formattedEndDate = date('d/m/Y', strtotime($loan['end_date']));
                                
                                echo "<tr>";
                                echo "<td>" . $loan['computer_number'] . "</td>";
                                echo "<td>" . $loan['name'] . "</td>";
                                echo "<td>" . $loan['email'] . "</td>";
                                echo "<td>" . $loan['student_number'] . "</td>";
                                echo "<td>" . $formattedStartDate . "</td>";
                                echo "<td>" . $formattedEndDate . "</td>";
                                echo "<td>" . $loan['days_overdue'] . "</td>";
                                echo "<td class='d-flex gap-2'>
                                        <form method='post'>
                                            <input type='hidden' name='loan_id' value='" . $loan['loan_id'] . "'>
                                            <input type='hidden' name='student_name' value='" . $loan['name'] . "'>
                                            <input type='hidden' name='student_email' value='" . $loan['email'] . "'>
                                            <input type='hidden' name='computer_number' value='" . $loan['computer_number'] . "'>
                                            <input type='hidden' name='end_date' value='" . $formattedEndDate . "'>
                                            <input type='hidden' name='days_overdue' value='" . $loan['days_overdue'] . "'>
                                            <button type='submit' name='send_email' class='btn btn-sm btn-warning'>Send Påmindelse</button>
                                        </form>
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