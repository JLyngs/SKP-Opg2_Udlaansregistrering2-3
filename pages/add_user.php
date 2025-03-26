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
    <div class="col-md-8">
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
                    $address = $_POST['address'];
                    $postalCode = $_POST['postalcode'];
                    $city = $_POST['city'];
                    $cpr = $_POST['cpr'];
                    $roleId = $_POST['role_id'];
                    $isBlacklisted = isset($_POST['is_blacklisted']) ? 1 : 0;
                    
                    $errors = [];
                    if (empty($name)) $errors[] = "Navn er påkrævet";
                    if (empty($email)) $errors[] = "Email er påkrævet";
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email adressen er ikke gyldig";
                    if (empty($class)) $errors[] = "Klasse er påkrævet";
                    if (empty($address)) $errors[] = "Adresse er påkrævet";
                    if (empty($postalCode)) $errors[] = "Postnummer er påkrævet";
                    if (empty($city)) $errors[] = "By er påkrævet";
                    if (empty($cpr)) $errors[] = "CPR nummer er påkrævet";
                    if (empty($roleId)) $errors[] = "Rolle er påkrævet";
                    
                    if (empty($errors)) {
                        if (addUser($conn, $name, $email, $class, $address, $postalCode, $city, $cpr, $roleId, $isBlacklisted)) {
                            echo '<div class="alert alert-success">Bruger er blevet tilføjet!</div>';
                            $name = $email = $class = $address = $postalCode = $city = $cpr = "";
                            $roleId = "";
                            $isBlacklisted = 0;
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
                    <div class="row">
                        <div class="col-md-6">
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
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($address) ? $address : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="postalcode" class="form-label">Postnummer</label>
                                        <input type="text" class="form-control" id="postalcode" name="postalcode" value="<?php echo isset($postalCode) ? $postalCode : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">By</label>
                                        <input type="text" class="form-control" id="city" name="city" value="<?php echo isset($city) ? $city : ''; ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="cpr" class="form-label">CPR Nummer</label>
                                <input type="text" class="form-control" id="cpr" name="cpr" placeholder="DDMMÅÅ-XXXX" value="<?php echo isset($cpr) ? $cpr : ''; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Rolle</label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="">Vælg rolle</option>
                                    <?php
                                    $roles = getAllRoles($conn);
                                    while ($role = mysqli_fetch_assoc($roles)) {
                                        $selected = (isset($roleId) && $roleId == $role['id']) ? 'selected' : '';
                                        echo "<option value='" . $role['id'] . "' $selected>" . $role['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_blacklisted" name="is_blacklisted" <?php echo (isset($isBlacklisted) && $isBlacklisted) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="is_blacklisted">Blacklistet</label>
                                <small class="form-text text-muted d-block">Markér hvis brugeren ikke må låne computere</small>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Tilføj Bruger</button>
                </form>
            </div>
        </div>
    </div>
</div>