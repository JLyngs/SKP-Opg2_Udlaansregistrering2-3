<div class="row">
    <div class="col-md-12">
        <h2>Dashboard</h2>
        <hr>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Tilgængelige Computere
            </div>
            <div class="card-body">
                <?php
                $computers = getAvailableComputers($conn);
                $count = mysqli_num_rows($computers);
                ?>
                <h3 class="display-4 text-center"><?php echo $count; ?></h3>
                <p class="text-center">
                    <a href="index.php?page=computers" class="btn btn-sm btn-outline-primary">Se detaljer</a>
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                Aktive Udlån
            </div>
            <div class="card-body">
                <?php
                $loans = getLoanedComputers($conn);
                $count = mysqli_num_rows($loans);
                ?>
                <h3 class="display-4 text-center"><?php echo $count; ?></h3>
                <p class="text-center">
                    <a href="index.php?page=loans" class="btn btn-sm btn-outline-success">Se detaljer</a>
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                Overskredet Afleveringsfrist
            </div>
            <div class="card-body">
                <?php
                $overdue = getOverdueLoans($conn);
                $count = mysqli_num_rows($overdue);
                ?>
                <h3 class="display-4 text-center"><?php echo $count; ?></h3>
                <p class="text-center">
                    <a href="index.php?page=overdue" class="btn btn-sm btn-outline-danger">Se detaljer</a>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                Seneste Udlån
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Computer</th>
                            <th>Bruger</th>
                            <th>Udlånsdato</th>
                            <th>Afleveringsdato</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $loans = getLoanedComputers($conn);
                        $counter = 0;
                        while ($loan = mysqli_fetch_assoc($loans)) {
                            if ($counter >= 5) break;
                            echo "<tr>";
                            echo "<td>" . $loan['computer_number'] . "</td>";
                            echo "<td>" . $loan['name'] . "</td>";
                            echo "<td>" . $loan['start_date'] . "</td>";
                            echo "<td>" . $loan['end_date'] . "</td>";
                            echo "</tr>";
                            $counter++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                Quick Links
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=new_loan" class="btn btn-lg btn-outline-primary">Registrer Nyt Udlån</a>
                    <a href="index.php?page=loans" class="btn btn-lg btn-outline-success">Håndter Aktive Udlån</a>
                    <a href="index.php?page=overdue" class="btn btn-lg btn-outline-danger">Håndter Overskredet Udlån</a>
                </div>
            </div>
        </div>
    </div>
</div>