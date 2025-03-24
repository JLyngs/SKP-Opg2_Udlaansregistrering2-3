<?php

function addUser($conn, $name, $email, $class) {
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $class = mysqli_real_escape_string($conn, $class);
    
    $sql = "INSERT INTO user (name, email, class, is_active) 
            VALUES ('$name', '$email', '$class', 1)";
    
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function addComputer($conn, $fabricator, $model, $mouseType, $gradeStateId) {
    $fabricator = mysqli_real_escape_string($conn, $fabricator);
    $model = mysqli_real_escape_string($conn, $model);
    $mouseType = mysqli_real_escape_string($conn, $mouseType);
    $gradeStateId = mysqli_real_escape_string($conn, $gradeStateId);
    
    $sql = "INSERT INTO computer (fabricator, model, mouse_type, grade_state_id) 
            VALUES ('$fabricator', '$model', '$mouseType', '$gradeStateId')";
    
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function deleteComputer($conn, $computerId) {
    $sql = "SELECT cl.loan_id 
            FROM computer_loan cl
            JOIN loan l ON cl.loan_id = l.id
            WHERE cl.computer_id = '$computerId' AND l.is_returned = 0";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        return false;
    }
    
    $sql = "DELETE FROM computer_loan WHERE computer_id = '$computerId'";
    mysqli_query($conn, $sql);
    
    $sql = "DELETE FROM computer WHERE id = '$computerId'";
    return mysqli_query($conn, $sql);
}

function getAllGradeStates($conn) {
    $sql = "SELECT * FROM grade_state ORDER BY grade, state";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getAvailableComputers($conn) {
    $sql = "SELECT c.id, c.fabricator, c.model, c.mouse_type, gs.grade, gs.state 
            FROM computer c
            LEFT JOIN grade_state gs ON c.grade_state_id = gs.id
            LEFT JOIN computer_loan cl ON c.id = cl.computer_id
            LEFT JOIN loan l ON cl.loan_id = l.id
            WHERE l.id IS NULL OR l.is_returned = 1
            GROUP BY c.id";
    
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getLoanedComputers($conn) {
    $sql = "SELECT c.id as computer_number, u.name, u.id as student_number, l.start_date, l.end_date, l.id as loan_id
            FROM loan l
            JOIN computer_loan cl ON l.id = cl.loan_id
            JOIN computer c ON cl.computer_id = c.id
            JOIN user u ON l.user_id = u.id
            WHERE l.is_returned = 0
            ORDER BY l.end_date ASC";
    
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getOverdueLoans($conn) {
    $currentDate = date('Y-m-d');
    $sql = "SELECT c.id as computer_number, u.name, u.email, u.id as student_number, l.start_date, l.end_date, DATEDIFF('$currentDate', l.end_date) as days_overdue, l.id as loan_id
            FROM loan l
            JOIN computer_loan cl ON l.id = cl.loan_id
            JOIN computer c ON cl.computer_id = c.id
            JOIN user u ON l.user_id = u.id
            WHERE l.is_returned = 0 AND l.end_date < '$currentDate'
            ORDER BY l.end_date ASC";
    
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getAllUsers($conn) {
    $sql = "SELECT * FROM user WHERE is_active = 1";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getAllComputers($conn) {
    $sql = "SELECT c.id as computer_number, c.fabricator, c.model, c.mouse_type, gs.grade, gs.state 
            FROM computer c
            LEFT JOIN grade_state gs ON c.grade_state_id = gs.id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function createLoan($conn, $userId, $computerId, $startDate, $endDate) {
    $sql = "INSERT INTO loan (user_id, start_date, end_date, is_returned) 
            VALUES ('$userId', '$startDate', '$endDate', 0)";
    
    if (mysqli_query($conn, $sql)) {
        $loanId = mysqli_insert_id($conn);
        
        $sql = "INSERT INTO computer_loan (computer_id, loan_id) 
                VALUES ('$computerId', '$loanId')";
        
        if (mysqli_query($conn, $sql)) {
            return true;
        }
    }
    
    return false;
}

function returnLoan($conn, $loanId) {
    $sql = "UPDATE loan SET is_returned = 1 WHERE id = '$loanId'";
    return mysqli_query($conn, $sql);
}