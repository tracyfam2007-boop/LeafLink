<?php

    function generateUserID($conn){
        $sql = "SELECT userId FROM user
            ORDER BY userId DESC
            LIMIT 1";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $lastID = $row['userId'];
            $number = substr($lastID, 1);
            $number++;
            $newID = "U" . str_pad($number, 6, "0", STR_PAD_LEFT);
        }else{
            $newID = "U000001";
        }
        return $newID;
    }

    function generateParticipantID($conn){
        $sql = "SELECT participantId FROM participant
                ORDER BY participantId DESC
                LIMIT 1";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $lastID = $row['participantId'];
            $number = substr($lastID, 1);
            $number++;
            $newID = "P" . str_pad($number, 6, "0", STR_PAD_LEFT);
        }else{
            $newID = "P000001";
        }
        return $newID;
    }

    function emailExists($conn, $email){
        $sql = "SELECT * FROM user
                WHERE emailAddress = '$email'";

        $result = mysqli_query($conn, $sql);

        return mysqli_num_rows($result) > 0;
    }

    function phoneExists($conn, $phone){
        $sql = "SELECT * FROM user
                WHERE phoneNumber = '$phone'";

        $result = mysqli_query($conn, $sql);

        return mysqli_num_rows($result) > 0;
    }

?>