<div class="row">
    <div class="col-md-12">
        <h2>Brugere</h2>
        <a href="index.php?page=add_user" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tilføj Ny Bruger
        </a>
        <hr>
    </div>
</div>

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
                            <th>Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = getAllUsers($conn);
                        while ($user = mysqli_fetch_assoc($users)) {
                            echo "<tr>";
                            echo "<td>" . $user['id'] . "</td>";
                            echo "<td>" . $user['name'] . "</td>";
                            echo "<td>" . $user['email'] . "</td>";
                            echo "<td>" . $user['class'] . "</td>";
                            echo "<td><a href='index.php?page=new_loan&user_id=" . $user['id'] . "' class='btn btn-sm btn-primary'>Udlån</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>