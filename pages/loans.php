<div class="row">
    <div class="col-md-12">
        <h2>Aktive Udlån</h2>
        <hr>
    </div>
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
                        while ($loan = mysqli_fetch_assoc($loans)) {
                            $currentDate = date('Y-m-d');
                            $rowClass = ($loan['end_date'] < $currentDate) ? 'table-danger' : '';
                            
                            echo "<tr class='" . $rowClass . "'>";
                            echo "<td>" . $loan['computer_number'] . "</td>";
                            echo "<td>" . $loan['name'] . "</td>";
                            echo "<td>" . $loan['student_number'] . "</td>";
                            echo "<td>" . $loan['start_date'] . "</td>";
                            echo "<td>" . $loan['end_date'] . "</td>";
                            echo "<td>
                                    <form method='post'>
                                        <input type='hidden' name='loan_id' value='" . $loan['loan_id'] . "'>
                                        <button type='submit' name='return_loan' class='btn btn-sm btn-success'>Aflever</button>
                                    </form>
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