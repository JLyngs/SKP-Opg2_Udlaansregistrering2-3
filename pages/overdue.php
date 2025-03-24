<div class="row">
    <div class="col-md-12">
        <h2>Overskredet Afleveringsfrist</h2>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                Overskredet Udlån
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
                        while ($loan = mysqli_fetch_assoc($overdue)) {
                            echo "<tr>";
                            echo "<td>" . $loan['computer_number'] . "</td>";
                            echo "<td>" . $loan['name'] . "</td>";
                            echo "<td>" . $loan['email'] . "</td>";
                            echo "<td>" . $loan['student_number'] . "</td>";
                            echo "<td>" . $loan['start_date'] . "</td>";
                            echo "<td>" . $loan['end_date'] . "</td>";
                            echo "<td>" . $loan['days_overdue'] . "</td>";
                            echo "<td>
                                    <a href='mailto:" . $loan['email'] . "?subject=Påmindelse: Overskredet Computer Udlån&body=Kære " . $loan['name'] . ",%0D%0A%0D%0ADu har lånt computer " . $loan['computer_number'] . " og afleveringsfristen var den " . $loan['end_date'] . ". Venligst aflever computeren hurtigst muligt.%0D%0A%0D%0AMed venlig hilsen,%0D%0AComputer Udlånssystem' class='btn btn-sm btn-warning'>Send Email</a>
                                  </td>";
                            echo "</tr>";
                        }
                        
                        if (mysqli_num_rows($overdue) == 0) {
                            echo "<tr><td colspan='8' class='text-center'>Ingen overskredet udlån</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>