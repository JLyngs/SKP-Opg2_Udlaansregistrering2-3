<div class="row">
    <div class="col-md-12">
        <h2>Tilføj Ny Bruger</h2>
        <a href="index.php?page=users" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Tilbage til Brugere
        </a>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                Indtast Bruger Detaljer
            </div>
            <div class="card-body">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $class = $_POST['class'];
                    
                    $errors = [];
                    if (empty($name)) $errors[] = "Navn er påkrævet";
                    if (empty($email)) $errors[] = "Email er påkrævet";
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email adressen er ikke gyldig";
                    if (empty($class)) $errors[] = "Klasse er påkrævet";
                    
                    if (empty($errors)) {
                        if (addUser($conn, $name, $email, $class)) {
                            echo '<div class="alert alert-success">Bruger er blevet tilføjet!</div>';
                            $name = $email = $class = "";
                        } else {
                            echo '<div class="alert alert-danger">Fejl: Bruger kunne ikke tilføjes. ' . mysqli_error($conn) . '</div>';
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
                
                <form method="post" action="index.php?page=add_user">                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Navn</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="class" class="form-label">Klasse</label>
                        <input type="text" class="form-control" id="class" name="class" value="<?php echo isset($class) ? $class : ''; ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Tilføj Bruger</button>
                </form>
            </div>
        </div>
    </div>
</div>